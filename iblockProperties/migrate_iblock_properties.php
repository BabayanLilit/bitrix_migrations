<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$fail = function ($meaasge) {
    echo "<p>" . $meaasge;
    exit;
};
$success = function ($meaasge, $exit = false) {
    echo "<p>" . $meaasge;
    if ($exit) {
        exit;
    }
};
$getIblIdByCode = function ($iblockCode) use ($fail) {
    $iblockBD = CIBlock::GetList(array(), array(
        "CODE" => $iblockCode,
    ));

    if ($iblExist = $iblockBD->Fetch()) {
        return $iblExist["ID"];
    } else {
        $fail("Не найден инфоблок с кодом " . $iblockCode);
    }
    
    return false;
};
CModule::IncludeModule("iblock");
$iblockCode = "sbl_social_links";

$iblId = $getIblIdByCode($iblockCode);
$iblPropertyFields[] = array(
    "NAME" => "Ссылка",
    "SORT" => "500",
    "CODE" => "LINK",
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "Y",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "S",
    "IBLOCK_ID" => $iblId,
    "LIST_TYPE" => "L",
    "ROW_COUNT" => 1,
    "COL_COUNT" => 30,
    "USER_TYPE" => "",
    "FILE_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "DEFAULT_VALUE" => "",
    "USER_TYPE_SETTINGS" => array(),
    "WITH_DESCRIPTION" => "N",
    "SEARCHABLE" => "N",
    "FILTRABLE" => "N",
    "MULTIPLE_CNT" => 5,
    "HINT" => "",
    "VALUES" => array(),
    "SECTION_PROPERTY" => "Y",
    "SMART_FILTER" => "N",
    "DISPLAY_TYPE" => "",
    "DISPLAY_EXPANDED" => "N",
    "FILTER_HINT" => "",
);
$iblPropertyFields[] = array(
    "NAME" => "CSS класс",
    "SORT" => "500",
    "CODE" => "CSS_CLASS",
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "Y",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "S",
    "IBLOCK_ID" => $iblId,
    "LIST_TYPE" => "L",
    "ROW_COUNT" => 1,
    "COL_COUNT" => 30,
    "USER_TYPE" => "",
    "FILE_TYPE" => "",
    "LINK_IBLOCK_ID" => "",
    "DEFAULT_VALUE" => "",
    "USER_TYPE_SETTINGS" => array(),
    "WITH_DESCRIPTION" => "N",
    "SEARCHABLE" => "N",
    "FILTRABLE" => "N",
    "MULTIPLE_CNT" => 5,
    "HINT" => "",
    "VALUES" => array(),
    "SECTION_PROPERTY" => "Y",
    "SMART_FILTER" => "N",
    "DISPLAY_TYPE" => "",
    "DISPLAY_EXPANDED" => "N",
    "FILTER_HINT" => "",
);
foreach ($iblPropertyFields as $item) {
    $propertCode = $item["CODE"];
    $dbList = CIBlockProperty::GetList(array(), array(
        "CODE" => $propertCode,
        "IBLOCK_ID" => $iblId
    ));
    $obIblProperty = new CIBlockProperty();
    if ($data = $dbList->Fetch()) {
        if (!$obIblProperty->Update($data["ID"], $item)) {
            $fail(sprintf("Не удалось обновить свосйтво %s. Ошибка- %s",
                $propertCode,
                $obIblProperty->LAST_ERROR
            ));
        }
        $success(sprintf("Свойство %s обновлено" , $propertCode));
    } else {
        if (!$obIblProperty->Add($item)) {
            $fail(sprintf("Не удалось добавить свойство %s. Ошибка- %s",
                $propertCode,
                $obIblProperty->LAST_ERROR
            ));
        }
        $success(sprintf("Свойство %s добавлено" , $propertCode));
    }
}
