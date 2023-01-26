<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION;

if(!CModule::IncludeModule("iblock"))

return; 

$Arr = $_GET['id'];

if (!empty($Arr)) {
	$arrencode = json_encode($Arr);
	$arrdecode = json_decode($arrencode, true);
	$SearchAr = explode(",", $arrdecode);
}

foreach ($SearchAr as $k => $val) {

	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_RERIOD", "PROPERTY_PRICE", "PROPERTY_BIO");
	$arFilter = Array("IBLOCK_ID"=> 29, "ID"=> $val, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$elem[$k] = $arFields;		
	}
}
?>

<?
foreach ($elem as $value) {
	$name = $value['NAME'];
	$id = $value['ID'];
	$day = $value['PROPERTY_RERIOD_VALUE'];
	$price = $value['PROPERTY_PRICE_VALUE'];
	$mater = $value['PROPERTY_BIO_VALUE'];
	$result =  <<<EOD
		<tr class="prices-item-table-row-new" id="prod_{$id}">
			<td class="prices-item-table-title name-div-title" data-label="{$name}">{$name}</td>
			<td class="prices-item-table-title" style="white-space: nowrap;">
				<select name="blood" id="blood" class="sz-selec__style">
					<option value="">Кровь (сыворотка)</option>
					<option value="">Кровь (цитрат натрия)</option>
				</select>
			</td>
			<td class="prices-item-table-title" style="white-space: nowrap;" data-label="Срок">{$day}</td>
			<td id="price_{$id}" class="prices-item-table-cost" data-price="{$price}">{$price} руб.</td>
			<td class="prices-item-table-cost zapis-button">
				<button class="remove_to_cart color-danger-dark" onclick="delorder({$id})">Удалить</button>
			</td>
		</tr>
	EOD;

echo $result;
}
?>