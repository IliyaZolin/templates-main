<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
$reset_cache = microtime(true);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css?<?=$reset_cache?>" />
<link rel="stylesheet" href="style.css?<?=$reset_cache?>">
<style>
.maps-footer {display: none;}

.sz-body-empty {
    width: 100%;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.sz-body-empty__text {font-size: 24px;line-height: 110%;color: #9ea1a2;}
.sz-body-empty__text > a {color: #265C80;}
</style>

<div class='sz-busket' id="SetNum_basket"></div>

<div class='uk-margin-large-bottom uk-hidden' id="index_prod">

	<div class='uk-margin-bottom uk-flex-right uk-flex'>
		<button onclick="delall()" class='sz-del-all'>Удалить все позиции</button>
	</div>

	<div class='uk-margin-medium-bottom'>

		<div class='uk-margin-bottom sz-h3 uk-padding-left uk-background-primary'>Список анализов</div>

		<div class="table-wrap-new">

			<table class="prices-item-table product-buy-block">

				<thead>

					<tr class="prices-item-table-row">

						<th class="prices-item-table-title name-div-title">Биоматериал</th>
						<th class="prices-item-table-cost zapis-button-a"></th>
						<th class="prices-item-table-title" style="white-space: nowrap;">Срок</th>
						<th class="prices-item-table-cost" style="padding-left: 35px;">Цена</th>
						<th class="prices-item-table-cost zapis-button"></th>

					</tr>

				</thead>

				<tbody class="add__new_element">

				</tbody>

			</table>

		</div>

	</div>

	<div class='uk-margin-medium-bottom'>

		<div class='uk-margin-bottom sz-h3 uk-padding-left uk-background-primary'>Взятие биоматериала <span class='uk-text-danger'>*</span></div>

		<div class="table-wrap-new">

			<table class="prices-item-table product-buy-block">

				<tbody>

					<tr class="prices-item-table-row-new">

						<td class="prices-item-table-title name-div-title" data-label="Биоматериал">
							<span class="bio-text">Кровь (сыворотка)</span>
						</td>

						<td class="prices-item-table-title uk-invisible" style="white-space: nowrap;">
							<select name="blood" id="blood">
								<option value="">Кровь (сыворотка)</option>
								<option value="">Кровь (цтьрат натрия)</option>
							</select>
						</td>

						<td class="prices-item-table-title uk-invisible" style="white-space: nowrap;" data-label="Срок">1 день </td>

						<td class="prices-item-table-cost">200 руб.</td>

						<td class="prices-item-table-cost zapis-button uk-invisible" data-label="">

							<a class="add_to_cart color-blue-dark">Выбрать</a>

						</td>

					</tr>

				</tbody>

			</table>

			</table>

		</div>

	</div>

	<div class='sz-done-div'>
		<div class='uk-flex uk-flex-between'>
			<div class='sz-done-div__text'>Сумма заказа:</div>
			<div class='sz-done-div__price-text'><span class='sz-done-div__price'>0</span> руб.</div>
		</div>
	</div>

	<div>

		<a href="/preorder/step1/" class="uk-button">Перейти к оформлению</a>

	</div>

</div>

<div id="sz-body-empty" class='sz-body-empty'>

	<div uk-spinner="" class="uk-icon uk-spinner"><svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" cx="15" cy="15" r="14"></circle></svg></div>

	<div class='sz-body-empty__text uk-hidden'>Ваша корзина пуста, перейдите в <a href="/uslugi/laboratoriya/">каталог</a> и добавьте услугу.</div>

</div>


<style>
.modal__new_element {
	margin-top: 25px;
	padding: 0px 10px;
}

.sz-back__blue {
	background: #265c80;
	color: #fff;
}
</style>

<script>
$(document).ready(function() {
	$cookiearr = Cookies.get('IdOrder');
	if ($cookiearr != '') {
		var cookie = $cookiearr;
		$.ajax({
			url: 'orderelements.php',
			method: 'get',
			dataType: 'html',
			data: {
				id: cookie,
			},
			success: function(data) {
				$('#sz-body-empty').addClass('uk-hidden');
				$('#index_prod').removeClass('uk-hidden');
				$('.add__new_element').append(data);

				var data = Cookies.get('IdOrder');
				$price = Number(200);
				const arr = data.split(',');
				arr.forEach(function(elem) {
				$price += Number($('#price_'+ elem + '').attr('data-price'));
				
				$('.sz-done-div__price').text($price);
				});
			}
		});
	} else {
		$('.sz-body-empty__text').removeClass('uk-hidden');
		$('.uk-spinner').remove();
	};
});

$(document).ready(function() {
	$('#SetNum_basket').remove();
});
</script>


<? $reset_cache = microtime(true); ?>
<script src="/ajax/basketscript.js?<?=$reset_cache?>"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.11/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>