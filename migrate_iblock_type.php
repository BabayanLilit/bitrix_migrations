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
$inlTypeId = "sbl_social_links";
$arFieldsIType = array(
    "ID" => $inlTypeId,
    "SORT" => "500",
    "SECTIONS" => "Y", //включает секции
    "EDIT_FILE_BEFORE" => "",//Файл для редактирования элемента, позволяющий модифицировать поля перед сохранением
    "EDIT_FILE_AFTER" => "",//Файл с формой редактирования элемента
    "LANG" => array(
        "ru" => array(
            "NAME" => "Ссылки на группы в соц сетях",
            "ELEMENT_NAME" => "Ссылки на группы в соц сетях"
        ),
        "en" => array(
            "NAME" => "Social links",
            "ELEMENT_NAME" => "Social links"
        )
    )
);
$typeBd = CIBlockType::GetList(array(), array(
    "ID" => $inlTypeId,
));
$iblType = new CIBlockType();
if ($iblTypeExist = $typeBd->Fetch()) {
    if (!$iblType->Update($iblTypeExist["ID"], $arFieldsIType)) {
        $fail("Не удалось обновить тип инфоблока " . $iblType->LAST_ERROR);
    }
    $success("Тип инфоблока обновлен");
} else {
    if (!$iblType->Add($arFieldsIType)) {
        $fail("Не удалось добавить тип инфоблока " . $iblType->LAST_ERROR);
    }
    $success("Тип инфоблока добавлен");
}

