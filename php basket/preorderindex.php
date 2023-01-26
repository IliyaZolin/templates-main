<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.11/dist/css/uikit.min.css" />
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.11/dist/js/uikit.min.js"></script>
<script src="/ajax/js.cookie.js"></script>

<style>
	.maps-footer {
		display: none;
	}

	.page-header {
		display: none;
	}

	.remove_to_cart {
		background: #c25d71;
		color: #fff;
		min-width: 75px;
		padding: 6px;
		border-radius: 10px;
		border: 1px solid #495A86;
	}

	.add_to_cart {
		min-width: 75px;
		padding: 6px;
		border-radius: 10px;
		border: 1px solid #495A86;
	}

	.sz-del-all {
		padding: 6px;
		border-radius: 10px;
		border: 1px solid #495A86;
		background: #495a86;
		color: #fff;
	}
</style>
<?
global $APPLICATION;

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

/*

Корзина	
	элементы
		получение элементов
		Добавление
		удаление
		удаление всех товаров


*/

?>

<div class='uk-margin-bottom uk-flex-right uk-flex'>
	<button onclick="delall()" class='sz-del-all'>Удалить все позиции</button>
</div>

<table class="prices-item-table" style="background-color: #495a86; min-width: 100%; color: #fff;">
	<thead>
		<tr class="prices-item-table-sect">
			<th class="prices-item-head-l" data-key="">
				<a href="" class="was"></a>
			</th>
			<th class="prices-item-head-2">
				<span class="was">Биоматериал</span>
			</th>
			<th class="prices-item-head-2">
				<span class="was">Срок</span>
			</th>
			<th class="prices-item-head-3">
				<span class="was">Цена</span>
			</th>
			<th class="prices-item-head-3"></th>
		</tr>
	</thead>

	<tbody>
		<tr class="prices-item-table-row product-buy-block">

			<td class="prices-item-table-title title-rows" data-label="Название"><a href="/uslugi/laboratoriya/gormony-v-slyune/Melatonin-v-slyune/">Мелатонин в слюне</a></td>
			<td class="prices-item-table-title bio-rows" data-label="Биоматериал"><span class="bio-text">Слюна</span></td>
			<td class="prices-item-table-title srok-rows" style="white-space: nowrap;" data-label="Срок">5 дней</td>
			<td class="prices-item-table-cost" data-label="Цена">2 415 руб.</td>
			<td class="prices-item-table-cost zapis-button" data-label="">
				<button style="padding: 6px; border-radius: 10px; border: 1px solid #495A86;" onclick="addorder('26771')" class="add_to_cart color-blue-dark" data-bio="Слюна" data-id="26771" data-count="1">Выбрать</button>
			</td>
		</tr>


		<tr class="prices-item-table-row product-buy-block">

			<td class="prices-item-table-title title-rows" data-label="Название"><a href="/uslugi/laboratoriya/gormony-v-slyune/Kortizol-v-slyune/">Кортизол в слюне</a></td>
			<td class="prices-item-table-title bio-rows" data-label="Биоматериал"><span class="bio-text">Слюна</span></td>
			<td class="prices-item-table-title srok-rows" style="white-space: nowrap;" data-label="Срок">6 дней</td>
			<td class="prices-item-table-cost" data-label="Цена">655 руб.</td>
			<td class="prices-item-table-cost zapis-button" data-label="">
				<button style="padding: 6px; border-radius: 10px; border: 1px solid #495A86;" onclick="addorder('26768')" class="add_to_cart color-blue-dark" data-bio="Слюна" data-id="26768" data-count="1">Выбрать</button>
			</td>
		</tr>

	</tbody>

</table>

<script>

	$(document).ready(function() {
		var cookiearr = Cookies.get('IdOrder');

		if (cookiearr != '') {
			const arr = cookiearr.split(',');
			arr.forEach(function(elem) {
				$data = $('[data-id=' + elem + ']').parent();
				$data.html('<button class="color-blue-dark remove_to_cart" onclick="delorder(' + elem + ')" data-id="' + elem + '" data-count="1">Удалить</button>');
			});
		};
	});
	
</script>

<script src="/ajax/basketscript.js"></script>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>