<?php
use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\Model\Section;


// регистрируем обработчик
AddEventHandler(
    "search",
    "BeforeIndex",
    array(
        "EditEventsSectionsToSearchClass",
        "editEventsSectionsToSearch")
);

class EditEventsSectionsToSearchClass
{
    public static $ext = "|#EXT";


    /**
     * @param array $arFields
     * @return array
     * Пропускает в поисковый индекс разделы-лиги.
     * Удаляет из поискового индекса разделы, которые не являются лигами.
     */
    // создаем обработчик события "BeforeIndex"
    public static function editEventsSectionsToSearch(array $arFields): array
    {
        $iblockCode = 'events_betsapi';
        $iblockTypeId = 'EVENTS';

        $iblockID = self::getIblockIdByIblockCode($iblockCode, $iblockTypeId);

        // у раздела ITEM_ID начинается с S, проверяем, что раздел
        $isSection = (substr($arFields["ITEM_ID"], 0, 1) == "S");

        if ($arFields["MODULE_ID"] == "iblock"
            && $arFields["PARAM2"] == $iblockID    // ID ИБ
            && $isSection
        ) {
            $sectionId = substr($arFields["ITEM_ID"], 1);
            $fields = ['UF_LEAGUE_ID', 'UF_LEAGUE_NAME_RU'];
            $sectionProps = self::getSectionProperties($iblockID, $sectionId, $fields);

            $isLeague = false;
            if ($sectionProps['UF_LEAGUE_ID']) {
                $isLeague = true;
            }

            if ($isLeague) {
                if ($sectionProps['UF_LEAGUE_NAME_RU']) {
                    // переписываем заголовок, в начало ставим русское название
                    $currentTitle = $arFields['TITLE'];
                    $arFields['TITLE'] = '';
                    $arFields['TITLE'] .= $sectionProps['UF_LEAGUE_NAME_RU'] . self::$ext . '|' . $currentTitle;
                }
            } else {    // если не лига, удаляем из поискового индекса
                $arFields['TITLE'] = '';
                $arFields['BODY'] = '';
            }
        }

        return $arFields;
    }


    /**
     * @param string $iblockCode
     * @param string $iblockTypeId
     * @return string
     * Получает ID инфоблока по символьному коду
     */
    private static function getIblockIdByIblockCode(string $iblockCode, string $iblockTypeId): string
    {
        $iblockID = '';

        // проверка подключения модуля iblock
        if (Loader::includeModule("iblock")) {
            // запрос к базе данных
            $iblock = IblockTable::getList([
                'filter' => [
                    '=CODE' => $iblockCode,
                    '=IBLOCK_TYPE_ID' => $iblockTypeId // тип инфоблока
                ],
                'select' => ['ID']
            ])->fetch();

            if ($iblock) {
                $iblockID = $iblock['ID'];
            } else {
                // echo "Инфоблок с символьным кодом {$iblockCode} не найден.";
            }

        }

        return $iblockID;
    }


    /**
     * @param string $iblockID
     * @param string $sectionId
     * @param array $fields
     * @return array
     * Получает свойства и поля раздела
     */
    private static function getSectionProperties(string $iblockID, string $sectionId, array $fields): array
    {
        $entity = Section::compileEntityByIblock($iblockID);
        $dbSect = $entity::getList([
            "select" => $fields,
            "filter" => ['ID' => $sectionId],
        ]);

        return $dbSect->fetch();
    }

}
