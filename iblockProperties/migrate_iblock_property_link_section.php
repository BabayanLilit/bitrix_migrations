<?php
//добавление свойства типа привязка к разделам
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
$propertCode = "LINK_SECTION_CODE";
$iblId = $getIblIdByCode($iblockCode);
//отличие от строки только в этом
//"PROPERTY_TYPE" => "G" и LINK_IBLOCK_ID
$iblPropertyFields = array(
    "NAME" => "cвойство типа привязка к разделам",
    "SORT" => "500",
    "CODE" => $propertCode,
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "Y",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "G",
    "FILE_TYPE" => "",
    "IBLOCK_ID" => $iblId,
    "LIST_TYPE" => "",
    "ROW_COUNT" => "",
    "COL_COUNT" => 30,
    "USER_TYPE" => "",
    "LINK_IBLOCK_ID" => 6,
    "DEFAULT_VALUE" => "",
    "USER_TYPE_SETTINGS" => array(),
    "WITH_DESCRIPTION" => "N",
    "SEARCHABLE" => "N",
    "FILTRABLE" => "N",
    "MULTIPLE_CNT" => "",
    "HINT" => "",
    "VALUES" => "",
    "SECTION_PROPERTY" => "Y",
    "SMART_FILTER" => "N",
    "DISPLAY_TYPE" => "",
    "DISPLAY_EXPANDED" => "N",
    "FILTER_HINT" => "",
);
$dbList = CIBlockProperty::GetList(array(), array(
    "CODE" => $propertCode,
    "IBLOCK_ID" => $iblId
));
$obIblProperty = new CIBlockProperty();
if ($data = $dbList->Fetch()) {
    if (!$obIblProperty->Update($data["ID"], $iblPropertyFields)) {
        $fail(sprintf("Не удалось обновить свосйтво %s. Ошибка- %s",
            $propertCode,
            $obIblProperty->LAST_ERROR
        ));
    }
    $success(sprintf("Свойство %s обновлено" , $propertCode));
} else {
    if (!$obIblProperty->Add($iblPropertyFields)) {
        $fail(sprintf("Не удалось добавить свойство %s. Ошибка- %s",
            $propertCode,
            $obIblProperty->LAST_ERROR
        ));
    }
    $success(sprintf("Свойство %s добавлено" , $propertCode));
}
