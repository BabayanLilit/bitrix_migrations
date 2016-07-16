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
CModule::IncludeModule("iblock");
$iblockCode = "sbl_social_links";
$iblockTypeId = "sbl_social_links";
$iblockFields = array(
    "CODE" => array(
        "IS_REQUIRED" => "Y",
        "DEFAULT_VALUE" => array(
            "UNIQUE" => "Y",
            "TRANSLITERATION" => "Y",
            "TRANS_LEN" => "100",
            "TRANS_CASE" => "Y",
            "TRANS_SPACE" => "-",
            "TRANS_OTHER" => "-",
            "TRANS_EAT" => "Y"
         )
    )
);
$arFieldsIbl = array(
    "ACTIVE" => "Y",
    "NAME" => "Ссылки на группы соц сетей",
    "CODE" => $iblockCode,
    "LIST_PAGE_URL" => "#SITE_DIR#/sbl_social_links/index.php?ID=#IBLOCK_ID#",
    "DETAIL_PAGE_URL" => "#SITE_DIR#/sbl_social_links/detail.php?ID=#ELEMENT_ID#",
    "CANONICAL_PAGE_URL" => "",
    "INDEX_ELEMENT" => "N", //Индексировать элементы для модуля поиска
    "IBLOCK_TYPE_ID" => $iblockTypeId,
    "LID" => array(
        SITE_ID
    ),
    "SORT" => "500",
    "PICTURE" => array(),
    "DESCRIPTION" => "",
    "DESCRIPTION_TYPE" => "",
    "EDIT_FILE_BEFORE" => "", //Файл для редактирования элемента, позволяющий модифицировать поля перед сохранением:
    "EDIT_FILE_AFTER" => "",//Файл с формой редактирования элемента:
    "WORKFLOW" => "N",
    "BIZPROC" => "N",
    "SECTION_CHOOSER" => "L", //Интерфейс привязки элемента к разделам
    "LIST_MODE" => "",
    "FIELDS" => $iblockFields,
    "ELEMENTS_NAME" => "Элементы",
    "ELEMENT_NAME" => "Элемент",
    "ELEMENT_ADD" => "Добавить элемент",
    "ELEMENT_EDIT" => "Изменить элемент",
    "ELEMENT_DELETE" => "Удалить элемент",
    "RIGHTS_MODE" => "S", //Расширенное управление правами
    "GROUP_ID" => array(
        "2" => "R",
        "1" => "X"
    ),
    "IPROPERTY_TEMPLATES" => array(

    ),
    "VERSION" => 1,

);
$iblockBD = CIBlock::GetList(array(), array(
    "CODE" => $iblockCode,
));
$ibl = new CIBlock();
if ($iblExist = $iblockBD->Fetch()) {
    if (!$ibl->Update($iblExist["ID"], $arFieldsIbl)) {
        $fail("Не удалось обновить инфоблок " . $ibl->LAST_ERROR);
    }
    $success("инфоблок обновлен");
} else {
    if (!$ibl->Add($arFieldsIbl)) {
        $fail("Не удалось добавить инфоблок " . $ibl->LAST_ERROR);
    }
    $success("Инфоблок добавлен");
}

