<?php

/**
 * Gacha Service
 */

namespace App\Services;

use App\Facades\Error;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\CreateGachaRequest;
use App\Repositories\MasterCardDataRepository;
use App\Repositories\UserGachaCardsRepository;
use App\Repositories\MstGachaRarityWeightlistRepository;
use App\Repositories\MasterConsecutiveGachaDataRepository;

class GachaService
{
    private $masterCardDataRepository;
    private $masterConsecutiveGachaDataRepository;
    private $masterGachaRarityWeightlistRepository;
    private $userGachaCardsRepository;

    private $maximumRareGachaRarityLevel;

    public function __construct(
        MasterCardDataRepository $masterCardDataRepository,
        MasterConsecutiveGachaDataRepository $masterConsecutiveGachaDataRepository,
        MstGachaRarityWeightlistRepository $masterGachaRarityWeightlistRepository,
        UserGachaCardsRepository $userGachaCardsRepository

    ) {
        $this->masterCardDataRepository = $masterCardDataRepository;
        $this->masterConsecutiveGachaDataRepository = $masterConsecutiveGachaDataRepository;
        $this->masterGachaRarityWeightlistRepository = $masterGachaRarityWeightlistRepository;
        $this->userGachaCardsRepository = $userGachaCardsRepository;

        $this->maximumRareGachaRarityLevel = $this->getMaximumRareGachaRarityLevel();
    }

    /**
     * Get maximum level for a rare gacha card
     *
     * @return integer
     */
    private function getMaximumRareGachaRarityLevel()
    {
        return $this->masterConsecutiveGachaDataRepository->getMaximumRareGachaRarityLevel();
    }


    /**
     * Create a gacha card
     *
     * @param CreateGachaRequest $request
     * @return object
     */
    function createGacha(CreateGachaRequest $request)
    {
        $userId = intval($request->id);

        $gachaWeightlist = $this->singleshotWeightlistRepository->getWeightlist();

        // Variables for the total weight and the percentage spread
        $totalWeight = 0;
        $percentageWeightArray = array();

        foreach ($gachaWeightlist as $weight) {
            $totalWeight += $weight['rarity_level_weight'];
        }
        foreach ($gachaWeightlist as $weight) {
            array_push($percentageWeightArray, $weight['rarity_level_weight'] / $totalWeight);
        }

        // Use function to determine weighted rarity level
        $rarityLevel = $this->assignRarityLevelFromPercentageArray($percentageWeightArray);

        // Generate a random card within the pool of that card's rarity
        $cardArray = $this->masterCardDataRepository->getCardsWithRarityLevel($rarityLevel);
        $cardInfo = $cardArray[array_rand($cardArray)];
        $cardId = $cardInfo['id'];
        $addUserCardResponse = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);
        // Add whether or not the card is new to the return object information
        $addUserCardResponse['new'] = !$this->userGachaCardsRepository->cardExistsForUser($userId, $cardId);
        // Add the rarity level to the return object also
        $addUserCardResponse['rarity'] = $rarityLevel;

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

    private function assignRarityLevelFromPercentageArray($percentageWeightArray)
    {
        // Generates a random number between 0 and 1
        $randNum = mt_rand() / mt_getrandmax();

        $cumulativeWeight = 0;
        $rarityIndex = 1;

        // Assign the rarity level based on the database value
        foreach ($percentageWeightArray as $percentageWeight) {
            if ($randNum >= $cumulativeWeight && $randNum < $cumulativeWeight + $percentageWeight) {
                return $rarityIndex;
            }
            // Increment the weight
            $cumulativeWeight = $cumulativeWeight + $percentageWeight;
            // Increment the counter
            $rarityIndex++;
        }

        // If for some reason no rarity level was assigned, assign most common (been incrementing)
        return $rarityIndex;
    }
}
