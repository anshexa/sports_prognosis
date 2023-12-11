<?php
$APPLICATION->IncludeComponent(
    "devstar:search.title",
    ".default",
    array(
        "INPUT_ID" => "title-search-input",
        "COMPONENT_TEMPLATE" => ".default",
        'CONTAINER_ID' => 'header-search-container',
        'RESULT_CONTAINER_ID' => 'search-result-wrap',
        "NUM_CATEGORIES" => "2",
        "TOP_COUNT" => "5",
        "ORDER" => "rank",
        "USE_LANGUAGE_GUESS" => "N",
        "CHECK_DATES" => "Y",
        "SHOW_OTHERS" => "N",
        "PAGE" => "#SITE_DIR#search/index.php",
        "CATEGORY_0_TITLE" => "Матчи",
        "CATEGORY_0" => array(
            0 => "iblock_EVENTS",
        ),
        "CATEGORY_0_iblock_EVENTS" => array(
            0 => "41",
        ),
        "CATEGORY_1_TITLE" => "Команды",
        "CATEGORY_1" => array(
            0 => "iblock_team",
        ),
        "CATEGORY_1_iblock_team" => array(
            0 => "40",
        ),
        "CATEGORY_1_TOP_COUNT" => 10,
        "CATEGORY_1_ORDER" => "date",
    ),
    false
);
