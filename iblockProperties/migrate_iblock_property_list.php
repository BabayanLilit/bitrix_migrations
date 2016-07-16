<?php
//добавление свойства типа список
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
$propertCode = "LIST_CODE";
$iblId = $getIblIdByCode($iblockCode);
//отличие от строки только в этом
//"PROPERTY_TYPE" => "L" и VALUES
$iblPropertyFields = array(
    "NAME" => "cвойство типа список",
    "SORT" => "500",
    "CODE" => $propertCode,
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "Y",
    "ACTIVE" => "Y",
    "PROPERTY_TYPE" => "L",
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
    "MULTIPLE_CNT" => "",
    "HINT" => "",
    "VALUES" => array(
        "n0" => array(
            "ID" => "n0",
            "VALUE" => "vars 1",
            "XML_ID" => "vars_1",
            "SORT" => "100",
            "DEF" => "Y",
        ),
        "n1" => array(
            "ID" => "n1",
            "VALUE" => "vars 2",
            "XML_ID" => "vars_2",
            "SORT" => "200",
            "DEF" => "N",
        )
    ),
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
