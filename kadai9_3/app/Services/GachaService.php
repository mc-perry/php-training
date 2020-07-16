<?php

/**
 * ガチャサービス
 */

namespace App\Services;

use App\Http\Requests\CreateGachaRequest;
// Repositories
use App\Repositories\MstCardDataRepository;
use App\Repositories\MstGachaInfoRepository;
use App\Repositories\MstGachaToRarityMapRepository;
use App\Repositories\MstRarityToCardMapRepository;
use App\Repositories\UserGachaCardsRepository;

class GachaService
{
    private $mstCardDataRepository;
    private $mstGachaInfoRepository;
    private $mstGachaToRarityMapRepository;
    private $mstRarityToCardMapRepository;
    private $userGachaCardsRepository;

    public function __construct(
        MstCardDataRepository $mstCardDataRepository,
        MstGachaInfoRepository $mstGachaInfoRepository,
        MstGachaToRarityMapRepository $mstGachaToRarityMapRepository,
        MstRarityToCardMapRepository $mstRarityToCardMapRepository,
        UserGachaCardsRepository $userGachaCardsRepository
    ) {
        $this->mstCardDataRepository = $mstCardDataRepository;
        $this->mstGachaInfoRepository = $mstGachaInfoRepository;
        $this->mstGachaToRarityMapRepository = $mstGachaToRarityMapRepository;
        $this->mstRarityToCardMapRepository = $mstRarityToCardMapRepository;
        $this->userGachaCardsRepository = $userGachaCardsRepository;
    }

    /** ヘルパー関数 */

    private function assignIndexFromPercentageArray($percentageWeightArray)
    {
        // 0と1の間の乱数を生成します
        $randNum = mt_rand() / mt_getrandmax();

        $cumulativeWeight = 0;
        $itemIndex = 0;

        // データベースの値に基づいて希少性レベルを割り当てる
        foreach ($percentageWeightArray as $percentageWeight) {
            if ($randNum >= $cumulativeWeight && $randNum < $cumulativeWeight + $percentageWeight) {
                return $itemIndex;
            }
            // 重み付けを増やす
            $cumulativeWeight = $cumulativeWeight + $percentageWeight;
            // カウンターをインクリメントする
            $itemIndex++;
        }

        // 何らかの理由でレアリティレベルが割り当てられていない場合は、最初に割り当てます
        return $itemIndex;
    }

    private function generatePctArrayAndAssignIndex($gachaToRarityMap)
    {
        // 総重量と割合のばらつきの変数
        $gachaPercentageWeightArray = array();

        $totalWeight = array_sum(array_column($gachaToRarityMap, 'weight'));

        foreach ($gachaToRarityMap as $rarity_item) {
            array_push($gachaPercentageWeightArray, $rarity_item['weight'] / $totalWeight);
        }

        return $this->assignIndexFromPercentageArray($gachaPercentageWeightArray);
    }


    /**
     * ガチャカードを作成する
     *
     * @param CreateGachaRequest $request
     * @return object
     */
    function createGacha(CreateGachaRequest $request)
    {
        $userId = intval($request->user_id);
        $gachaId = intval($request->gacha_id);

        $gachaToRarityMap = $this->mstGachaToRarityMapRepository->getMapForGacha($gachaId);

        // 関数を使用して重み付き希少性レベルを決定する
        $indexOfSelectedRarity = $this->generatePctArrayAndAssignIndex($gachaToRarityMap);
        $cardRarityToUse = $gachaToRarityMap[$indexOfSelectedRarity]['card_rarity'];

        // そのカードの希少性のプール内でランダムなカードを生成します
        $cardArray = $this->mstRarityToCardMapRepository->getCardsWithRarityLevel($gachaId, $cardRarityToUse);

        // 関数を再利用して、発行するカードのインデックスを取得できます
        $indexOfCardToIssue = $this->generatePctArrayAndAssignIndex($cardArray);

        $cardInfo = $cardArray[$indexOfCardToIssue];
        $cardId = $cardInfo['card_id'];

        // カードをデータベースに追加する前に、returnオブジェクトにnewを追加します
        $userCardsArray = $this->userGachaCardsRepository->getUserCards($userId);
        $uniqueIdList = array_unique(array_column($userCardsArray, 'master_card_id'));

        // カードをデータベースに追加
        $addUserCardResponse = $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardId);

        // 新しいカードかどうかを設定します
        $addUserCardResponse['new'] = !in_array($cardId, $uniqueIdList);
        // 希少性レベルを返却オブジェクトにも追加します
        $addUserCardResponse['card_rarity'] = $cardRarityToUse;

        return $addUserCardResponse;
    }

    /**
     * 連続したガチャカードを作成する
     *
     * @param CreateGachaRequest $request
     * @return object
     */
    function issueConsecutiveGachas(CreateGachaRequest $request)
    {
        $userId = intval($request->user_id);
        $gachaId = intval($request->gacha_id);

        // カードのレア度にガチャの重みを加える
        $gachaToRarityMap = $this->mstGachaToRarityMapRepository->getMapForGacha($gachaId);
        // ユーザーに発行されるカードの数を取得します
        $masterGachaInfo = $this->mstGachaInfoRepository->getGachaMasterInfo($gachaId);

        $numOfGachaCards = $masterGachaInfo['number_of_cards'];
        $minimum_rarity_lastgacha = $masterGachaInfo['minimum_rarity_lastgacha'];

        // 指定されたガチャの最大の希少性を取得します
        $numOfRarities = $this->mstGachaToRarityMapRepository->getMaximumRarityForGacha($gachaId)['card_rarity'];

        // 戻りオブジェクトとデータベース挿入オブジェクトの配列
        $returnGachaCardArray = array();
        $cardInsertData = array();
        $allRarityToCardMappings = $this->mstRarityToCardMapRepository->getAllRarityToCardMappings();

        $rarityToCardMappingArray = array();
        for ($x = 1; $x <= $numOfRarities; $x++) {
            array_push($rarityToCardMappingArray, array());
            foreach ($allRarityToCardMappings as $rarityMapping) {
                if ($rarityMapping['rarity_level'] == $x && $rarityMapping['gacha_id'] == $gachaId) {
                    array_push($rarityToCardMappingArray[$x - 1], $rarityMapping);
                }
            }
        }

        // カードをデータベースに追加する前に、returnオブジェクトにnewを追加します
        $userCardsArray = $this->userGachaCardsRepository->getUserCards($userId);

        // 最初に合計1個のランダムに生成されたガチャカードを要求する
        for ($i = 0; $i < $numOfGachaCards - 1; $i++) {
            // 新しい値を正しく更新するには、毎回これを生成する必要があります
            $uniqueIdList = array_unique(array_column($userCardsArray, 'master_card_id'));

            // 関数を使用して重み付き希少性レベルを決定する
            $indexOfSelectedRarity = $this->generatePctArrayAndAssignIndex($gachaToRarityMap);

            $cardRarityToUse = $gachaToRarityMap[$indexOfSelectedRarity]['card_rarity'];

            // 選択したレアリティのカードのウェイトマッピングを取得します
            $rarityMapForSelectedRarity = $rarityToCardMappingArray[$cardRarityToUse - 1];

            // 関数を使用して重み付き希少性レベルを決定する
            $indexOfCardToIssue = $this->generatePctArrayAndAssignIndex($rarityMapForSelectedRarity);

            $cardInfo = $rarityMapForSelectedRarity[$indexOfCardToIssue];
            $cardId = $cardInfo['card_id'];

            // 挿入するオブジェクトとユーザーカード（新規）にデータを追加します
            array_push($cardInsertData, ['user_id' => $userId, 'master_card_id' => $cardId]);
            array_push($userCardsArray, ['user_id' => $userId, 'master_card_id' => $cardId]);

            // カードIDを戻りオブジェクトに追加する
            $gachaCard['master_card_id'] = $cardId;
            // 現在のステータスに基づいて新しい値を設定します
            $gachaCard['new'] = !in_array($cardId, $uniqueIdList);
            // 希少性レベルを戻りオブジェクトに追加します
            $gachaCard['rarity'] = $cardRarityToUse;
            // user_idを戻りオブジェクトに追加します
            $gachaCard['user_id'] = $userId;

            array_push($returnGachaCardArray, $gachaCard);
        }

        // レア以上のガチャカードをもう1枚生成する
        // 珍しいカテゴリーの新しい総重量を計算する
        $cardsOfRarityOrAbove = $this->mstRarityToCardMapRepository->getCardsWithRarityLevelOrAbove($gachaId, $minimum_rarity_lastgacha);

        // 関数を使用して重み付き希少性レベルを決定する
        $indexOfSelectedRarity = $this->generatePctArrayAndAssignIndex($cardsOfRarityOrAbove);
        $cardIdToIssue = $cardsOfRarityOrAbove[$indexOfSelectedRarity]['card_id'];
        $rarityOfIssuedCard = $cardsOfRarityOrAbove[$indexOfSelectedRarity]['rarity_level'];

        // カードをdbに追加する
        $this->userGachaCardsRepository->addCardsToUserTableFromArray($cardInsertData);

        // カードをデータベースに追加する前に、returnオブジェクトにnewを追加します
        $userCardsArray = $this->userGachaCardsRepository->getUserCards($userId);
        $uniqueIdList = array_unique(array_column($userCardsArray, 'master_card_id'));

        // 新しいカードかどうかを設定します
        $gachaCard['new'] = !in_array($cardIdToIssue, $uniqueIdList);
        // 返却オブジェクトの最後のカードのcard_idを設定します
        $gachaCard['master_card_id'] = $cardIdToIssue;
        // 希少性レベルを返却オブジェクトにも追加します
        $gachaCard['rarity'] = $rarityOfIssuedCard;
        // このカードのuser_idを設定
        $gachaCard['user_id'] = $userId;

        array_push($returnGachaCardArray, $gachaCard);

        // 最後に発行されたカードをデータベースに追加します
        $this->userGachaCardsRepository->addSelectedCardToUserTable($userId, $cardIdToIssue);

        return $returnGachaCardArray;
    }
}
