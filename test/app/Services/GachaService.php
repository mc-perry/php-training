<?php

/**
 * Gacha Service
 */

namespace App\Services;

use App\Facades\Error;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\CreateGachaRequest;
// Repositories
use App\Repositories\GachaMasterInfoRepository;
use App\Repositories\GachaToRarityMapRepository;
use App\Repositories\MasterCardDataRepository;
use App\Repositories\RarityToCardMapRepository;
use App\Repositories\UserGachaCardsRepository;

class GachaService
{
    private $gachaMasterInfoRepository;
    private $gachaToRarityMapRepository;
    private $masterCardDataRepository;
    private $rarityToCardMapRepository;
    private $userGachaCardsRepository;

    public function __construct(
        GachaMasterInfoRepository $gachaMasterInfoRepository,
        GachaToRarityMapRepository $gachaToRarityMapRepository,
        MasterCardDataRepository $masterCardDataRepository,
        RarityToCardMapRepository $rarityToCardMapRepository,
        UserGachaCardsRepository $userGachaCardsRepository

    ) {
        $this->gachaMasterInfoRepository = $gachaMasterInfoRepository;
        $this->gachaToRarityMapRepository = $gachaToRarityMapRepository;
        $this->masterCardDataRepository = $masterCardDataRepository;
        $this->rarityToCardMapRepository = $rarityToCardMapRepository;
        $this->userGachaCardsRepository = $userGachaCardsRepository;
    }

    /** Helper functions */

    private function assignItemFromPercentageArray($percentageWeightArray)
    {
        // Generates a random number between 0 and 1
        $randNum = mt_rand() / mt_getrandmax();

        $cumulativeWeight = 0;
        $itemIndex = 1;

        // Assign the rarity level based on the database value
        foreach ($percentageWeightArray as $percentageWeight) {
            if ($randNum >= $cumulativeWeight && $randNum < $cumulativeWeight + $percentageWeight) {
                return $itemIndex;
            }
            // Increment the weight
            $cumulativeWeight = $cumulativeWeight + $percentageWeight;
            // Increment the counter
            $itemIndex++;
        }

        // If for some reason no rarity level was assigned, assign first
        return $itemIndex;
    }

    private function assignIndexFromPercentageArray($percentageWeightArray)
    {
        // Generates a random number between 0 and 1
        $randNum = mt_rand() / mt_getrandmax();

        $cumulativeWeight = 0;
        $itemIndex = 0;

        // Assign the rarity level based on the database value
        foreach ($percentageWeightArray as $percentageWeight) {
            if ($randNum >= $cumulativeWeight && $randNum < $cumulativeWeight + $percentageWeight) {
                return $itemIndex;
            }
            // Increment the weight
            $cumulativeWeight = $cumulativeWeight + $percentageWeight;
            // Increment the counter
            $itemIndex++;
        }

        // If for some reason no rarity level was assigned, assign first
        return $itemIndex;
    }

    /**
     * Create a gacha card
     *
     * @param CreateGachaRequest $request
     * @return object
     */
    function createGacha(CreateGachaRequest $request)
    {
        $userId = intval($request->user_id);
        $gachaId = intval($request->gacha_id);

        $gachaToRarityMap = $this->gachaToRarityMapRepository->getMapForGacha($gachaId);

        // Variables for the total weight and the percentage spread
        $totalWeight = 0;
        $gachaPercentageWeightArray = array();

        foreach ($gachaToRarityMap as $rarity_item) {
            $totalWeight += $rarity_item['weight'];
        }

        foreach ($gachaToRarityMap as $rarity_item) {
            array_push($gachaPercentageWeightArray, $rarity_item['weight'] / $totalWeight);
        }

        // Use function to determine weighted rarity level
        $indexOfSelectedRarity = $this->assignIndexFromPercentageArray($gachaPercentageWeightArray);
        $cardRarityToUse = $gachaToRarityMap[$indexOfSelectedRarity]['card_rarity'];

        // Generate a random card within the pool of that card's rarity
        $cardArray = $this->rarityToCardMapRepository->getCardsWithRarityLevel($gachaId, $cardRarityToUse);

        $totalWeight = 0;
        $cardPercentageWeightArray = array();

        foreach ($cardArray as $card_item) {
            $totalWeight += $card_item['card_weight'];
        }

        foreach ($cardArray as $card_item) {
            array_push($cardPercentageWeightArray, $card_item['card_weight'] / $totalWeight);
        }

        // Use function to determine weighted rarity level
        $indexOfCardToIssue = $this->assignIndexFromPercentageArray($cardPercentageWeightArray);

        $cardInfo = $cardArray[$indexOfCardToIssue];
        $cardId = $cardInfo['card_id'];

        // Add  new to the return object before adding card to the db
        $cardExists = $this->userGachaCardsRepository->cardExistsForUser($userId, $cardId);

        // Add card to the db
        $addUserCardResponse = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);

        // Set whether it is a new card
        $addUserCardResponse['new'] = !$cardExists;
        // Add the rarity level to the return object also
        $addUserCardResponse['card_rarity'] = $cardRarityToUse;

        return $addUserCardResponse;
    }

    /**
     * Create consecutive gacha cards
     *
     * @param CreateGachaRequest $request
     * @return object
     */
    function issueConsecutiveGachas(CreateGachaRequest $request)
    {
        // Get the user ID
        $userId = intval($request->id);

        // Get the weightlist object
        $gachaWeightlist = $this->consecutiveRarityWeightlistRepository->getWeightlist();

        // Get the number of consecutive cards to issue from the db
        $numOfGachaCards = $this->masterConsecutiveGachaDataRepository->getNumberOfConsecutiveGachaCards();

        // Variables for the total weight and the percentage spread
        $totalWeight = 0;
        $percentageWeightArray = array();

        // Return array containing the created gacha cards
        $returnGachaCardArray = array();

        foreach ($gachaWeightlist as $weight) {
            $totalWeight += $weight['rarity_level_weight'];
        }

        // Contruct the percentage weight array from the weightlist array
        foreach ($gachaWeightlist as $weight) {
            array_push($percentageWeightArray, $weight['rarity_level_weight'] / $totalWeight);
        }

        // Call x times for the first x-1 randomly generated gacha cards
        for ($i = 0; $i < $numOfGachaCards - 1; $i++) {
            // Assign rarity level from percentage array
            $rarityLevel = $this->assignRarityLevelFromPercentageArray($percentageWeightArray);
            var_dump($rarityLevel);
            // Generate a random card within the pool of that card's rarity
            $cardArray = $this->masterCardDataRepository->getCardsWithRarityLevel($rarityLevel);
            $cardInfo = $cardArray[array_rand($cardArray)];
            $cardId = $cardInfo['id'];

            // Get the new value before adding card to the db
            $cardExists = $this->userGachaCardsRepository->cardExistsForUser($userId, $cardId);
            $newValue = !$cardExists;

            $gachaCard = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);
            // Add the new value to the return array object
            $gachaCard['new'] = $newValue;
            // Add the rarity level to the return object also
            $gachaCard['rarity'] = $rarityLevel;

            array_push($returnGachaCardArray, $gachaCard);
        }

        // Generate one more gacha card for rare rarity or higher
        // Reset variables for the total weight and the percentage spread
        $totalWeight = 0;
        $percentageWeightArray = array();

        // Reduce the number by one index to align with the array indices
        $maximumRarityWeightIndex = $this->maximumRareGachaRarityLevel;

        // Calculate new total weight for rare categories
        for ($x = 0; $x < $maximumRarityWeightIndex; $x++) {
            $totalWeight += $gachaWeightlist[$x]['rarity_level_weight'];
        }

        // Contruct the new percentage weight array from the weightlist array
        for ($x = 0; $x < $maximumRarityWeightIndex; $x++) {
            $currentWeight = $gachaWeightlist[$x]['rarity_level_weight'];
            array_push($percentageWeightArray, $currentWeight / $totalWeight);
        }

        // Assign new weighted rarity level from smaller weighted array
        $rarityLevel = $this->assignRarityLevelFromPercentageArray($percentageWeightArray);

        // Generate a random card within the pool of that card's rarity
        $cardArray = $this->masterCardDataRepository->getCardsWithRarityLevel($rarityLevel);
        $cardInfo = $cardArray[array_rand($cardArray)];
        $cardId = $cardInfo['id'];

        // Get the new value before adding card to the db
        $cardExists = $this->userGachaCardsRepository->cardExistsForUser($userId, $cardId);
        $newValue = !$cardExists;

        // Add the card to the db
        $gachaCard = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);
        // Add the new value to the return array object
        $gachaCard['new'] = $newValue;
        // Add the rarity level to the return object also
        $gachaCard['rarity'] = $rarityLevel;
        array_push($returnGachaCardArray, $gachaCard);

        return $returnGachaCardArray;
    }
}
