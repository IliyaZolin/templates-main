<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

// получаем данные
$Id = $_GET['id'];
$Arr = $_GET['arr'];


if (!empty($Arr) && empty($Id)) {
	echo $Arr;
}else{

	if (empty($Id) && empty($Arr)) { // нажали удалить все, перезаписываем на пустоту
		echo '';
	}else{

		if (empty($Arr)) { // первая запись

			echo $Id; 
			
		}else{ // уже есть id в массиве и переменная
			// перекодируем 
			$arrencode = json_encode($arr);
			$arrdecode = json_decode($arrencode, true);
			$SearchAr = explode(",", $arrdecode); // переводим в массив

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
}
?>