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
$iblCode = "sbl_social_links";
CModule::IncludeModule("iblock");
$ID = $getIblIdByCode($iblCode);
$fields = CIBlock::getFields($ID);
$fields["CODE"]["IS_REQUIRED"] = "Y";
$fields["CODE"]["DEFAULT_VALUE"]["UNIQUE"] = "Y";//Если код задан, то проверять на уникальность
$fields["CODE"]["DEFAULT_VALUE"]["TRANSLITERATION"] = "Y";//Транслитерировать из названия при добавлении элемента
CIBlock::setFields($ID, $fields);
$success("Свойства инфоблока обновлены, но проверьте, так как CIBlock::setFields не возвращает результат");