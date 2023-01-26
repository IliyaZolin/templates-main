<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

$Id = $_GET['id'];
// получаем массив
$Arr = $_GET['arr'];


if (empty($Id)) {
	// нажали удалить все, перезаписываем на пустоту
	echo '';

}else{

	if (empty($Arr)) {

		echo $Id;
		
	}else{
		// перекодируем 
		$arrencode = json_encode($arr);
		$arrdecode = json_decode($arrencode, true);
		$SearchAr = explode(",", $arrdecode);

		// если массива еще нет

		// прроверяем на совпадение
		if (in_array($Id, $SearchAr)) {
			// при совпадении , удаляем из массива
			$Narray = array_diff($SearchAr, [$Id]);
			// переводим массив в сроку через запятую
			$NewCookie = implode(",", $Narray);

			// отправляем полученный массив
			echo $NewCookie;
		} else {
			// если совпадения нет, добавляем и отправляем массив
			$NewCookie = $arrdecode . ',' . $Id;
			echo $NewCookie;
		}
	}
}
?>