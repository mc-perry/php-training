<?php

/**
 * Gacha Service
 */

namespace App\Services;

use App\Facades\Error;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\CreateGachaRequest;
use App\Repositories\GachaRarityWeightlistRepository;
use App\Repositories\GachaMasterDataRepository;
use App\Repositories\UserGachaCardsRepository;

class GachaService
{
    private $gachaWeightlistRepository;
    private $gachaMasterDataRepository;
    private $userGachaCardsRepository;

    public $rarity_map = [
        1 => 'SR',
        2 => 'R',
        3 => 'N',
    ];

    public function __construct(
        GachaRarityWeightlistRepository $gachaWeightlistRepository,
        GachaMasterDataRepository $gachaMasterDataRepository,
        UserGachaCardsRepository $userGachaCardsRepository
    ) {
        $this->gachaWeightlistRepository = $gachaWeightlistRepository;
        $this->gachaMasterDataRepository = $gachaMasterDataRepository;
        $this->userGachaCardsRepository = $userGachaCardsRepository;
    }

    function createGacha(CreateGachaRequest $request)
    {
        $userId = intval($request->id);

        $gachaWeightlist = $this->gachaWeightlistRepository->getWeightlist();

        // Variables for the total weight and the percentage spread
        $totalWeight = 0;
        $percentageWeightArray = array();

        foreach ($gachaWeightlist as $weight) {
            $totalWeight += $weight['rarity_level_weight'];
        }
        foreach ($gachaWeightlist as $weight) {
            array_push($percentageWeightArray, $weight['rarity_level_weight'] / $totalWeight);
        }

        // Generates a random number between 0 and 1
        $randNum = mt_rand() / mt_getrandmax();

        $cumulativeWeight = 0;
        $rarityIndex = 1;
        // Assign the rarity level based on the database value
        foreach ($percentageWeightArray as $percentageWeight) {
            if ($randNum >= $cumulativeWeight && $randNum < $cumulativeWeight + $percentageWeight) {
                $rarityLevel = $rarityIndex;
            }
            // Increment the weight
            $cumulativeWeight = $cumulativeWeight + $percentageWeight;
            // Increment the counter
            $rarityIndex++;
        }
        // If for some reason no rarity level was assigned, assign common
        if (!$rarityLevel) {
            $rarityLevel = $rarityIndex;
        }

        // Generate a random card within the pool of that card's rarity
        $cardArray = $this->gachaMasterDataRepository->getCardsWithRarityLevel($rarityLevel);
        $cardInfo = $cardArray[array_rand($cardArray)];
        $cardId = $cardInfo['id'];
        $addUserCardResponse = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);

        return $addUserCardResponse;
    }
}
