<?php
const matchesCategoryTitle = 'Матчи';
const leaguesCategoryTitle = 'Лиги';

$newCategories = getCategoriesWithSeparateLeaguesAndMatches($arResult["CATEGORIES"], matchesCategoryTitle, leaguesCategoryTitle);
$arResult["CATEGORIES"] = $newCategories;


/**
 * @param array $categories
 * @param string $matchesCategoryTitle
 * @param string $leaguesCategoryTitle
 * @return array
 * Получает все категории, но
 * в матчах сохраняет только матчи, без лиг,
 * в лигах - только лиги, без матчей
 */
function getCategoriesWithSeparateLeaguesAndMatches(array $categories, string $matchesCategoryTitle, string $leaguesCategoryTitle): array
{
    $newCategories = [];
    foreach ($categories as $arCategory) {

        if ($arCategory['TITLE'] == $matchesCategoryTitle) {
            $onlyMatches = [];
            foreach ($arCategory['ITEMS'] as $arItem) {
                // сохраняем только матчи, без разделов-лиг

                // у раздела ITEM_ID начинается с S, проверяем, что не раздел
                $isNotSection = (substr($arItem["ITEM_ID"], 0, 1) != "S");

                if ($isNotSection) {
                    array_push($onlyMatches, $arItem);
                }
            }
            $newCategories[] = [
                'TITLE' => $arCategory['TITLE'],
                'ITEMS' => $onlyMatches
            ];

        } elseif ($arCategory['TITLE'] == $leaguesCategoryTitle) {
            $onlyLeagues = [];
            foreach ($arCategory['ITEMS'] as $arItem) {
                // сохраняем только лиги, без элементов-матчей

                // у раздела ITEM_ID начинается с S
                $isSection = (substr($arItem["ITEM_ID"], 0, 1) == "S");

                if ($isSection) {
                    array_push($onlyLeagues, $arItem);
                }
            }
            $newCategories[] = [
                'TITLE' => $arCategory['TITLE'],
                'ITEMS' => $onlyLeagues
            ];
        } else {
            // добавляем как есть
            array_push($newCategories, $arCategory);
        }

    }

    return $newCategories;
}
