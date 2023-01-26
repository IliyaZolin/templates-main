<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
$request = Context::getCurrent()->getRequest(); // true - GET-запрос, иначе false

$flag = $request->isPost(); // true - POST-запрос, иначе false
$flag = $request->isAjaxRequest();  // true - AJAX-запрос, иначе false
if ($flag === true) {

	if ($request['checkboxcard'] == 'on') {
		$arEventFields = array(
			"FIO" => $request['fio'],
			"DATE" => $request['date'],
			"ORDER" => $request['order'],
			"PRICE" => $request['price'],
			"CARD" => $request['card'],
		);
	}else{
		$arEventFields = array(
			"FIO" => $request['fio'],
			"DATE" => $request['date'],
			"ORDER" => $request['order'],
			"PRICE" => $price,
		);
	}
	
	CEvent::Send("BASKET", 's1', $arEventFields, "N", 18);

	

	CModule::IncludeModule('iblock');
	$el = new CIBlockElement;
	global $USER;
	$PROP = array();

	$PROP[244] = $request['fio']; // ФИО
	$PROP[245] = $request['date']; // Дата заказа
	$PROP[246] = $request['order']; // ID товаров в заказе
	$PROP[247] = $request['price']; // Сумма заказа
	$PROP[248] = $request['card']; // Карта лояльности

	$arLoadProductArray = array(
		"MODIFIED_BY"    => 1,
		"IBLOCK_SECTION_ID" => false,
		"IBLOCK_ID"      => 39, // ID инфоблока
		"PROPERTY_VALUES" => $PROP,
		"NAME"           => $request['fio'],
		"ACTIVE"         => "Y",
		//"PREVIEW_TEXT"   => $request['COM'], // Комментарий
	);

	if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
		echo 'OK';
	} else {
		$arResult["ERROR_MESSAGE"][] = $el->LAST_ERROR;
	}

}