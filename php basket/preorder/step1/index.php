<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
$reset_cache = microtime(true);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css?<?=$reset_cache?>" />
<link rel="stylesheet" href="/preorder/style.css?<?=$reset_cache?>">
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

.sz-form__body {
	width: 100%;
	max-width: 640px;
	margin-bottom: 40px;
}

.uk-button-def {
    background: #265c80;
    border-radius: 21px;
    color: #fff;
    transition: 0.2s all;
}

.uk-button-def:hover {
    opacity: 0.8;
}
.sz_finish_price {
	display: none;
}
label.uk-form-label {
	margin-bottom: 10px;
	font-size: 16px;
	font-weight: 600;
}
.uk-checkbox:checked, .uk-checkbox:indeterminate, .uk-radio:checked {
	background-color: #265c80;
}
</style>
<?
$today = date("j.n.Y H:i");
?>
<div class='sz-form__body'>

	<form id="basket_finish" class=''>

		<input class="uk-input" type="text" name="order" placeholder="Состав заказа" id="orderval" hidden>

		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-text">ФИО</label>
			<div class="uk-form-controls">
				<input class="uk-input" id="form-stacked-text" type="text" name="fio" placeholder="ФИО" required>
			</div>
		</div>

		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-text">Дата и время визита</label>
			<div class="uk-form-controls">
				<input class="uk-input" id="form-stacked-text" type="text" name="date" placeholder="Дата и время визита" required value="<?=$today?>">
			</div>
		</div>

		<div class='uk-margin'>
			<label><input class="uk-checkbox" type="checkbox" onclick="check()" name="checkboxcard"> У меня есть карта лояльности</label>
		</div>
		
		<div id="salecard" class='uk-hidden'></div>

		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-text">Итог</label>
			<div class="uk-form-controls">
				<input class="uk-input orderprice" id="form-stacked-text" type="text" disabled>
			</div>
		</div>

		<input class="uk-input" type="text" name="price" hidden id="order_price">

		<div class='uk-margin'>
			<div class='uk-text-right'>+200 руб за забор крови</div>
		</div>

		<button class='uk-button uk-button-def' name="submit">Оформить заказ</button>

	</form>

</div>

<div class='add__new_element' hidden></div>

<script>
$(document).ready(function() {
	$cookie = Cookies.get('IdOrder');
	if ($cookie == "") {
		window.location.href = '/preorder/';
	}
});

$(document).ready(function() {
	var cookie = Cookies.get('IdOrder');
	$('#orderval').val(cookie);
	$.ajax({
		url: '/preorder/orderelements.php',
		method: 'get',
		dataType: 'html',
		data: {
			id: cookie,
		},
		success: function(data) {
			$('.add__new_element').append(data);
			var data = Cookies.get('IdOrder');

			$price = Number(0);
			const arr = cookie.split(',');
			arr.forEach(function(elem) {
				$price += Number($('#price_'+ elem + '').attr('data-price'));
			});
			
			$('.orderprice').attr('placeholder', $price + ' руб.');
			$('#order_price').val($price);
			$('.sz_finish_price').css('display', 'flex');
		}
	});
});

function check() {
	$('#salecard').removeClass('uk-hidden');
	$('#salecard').append("<label class='uk-margin-small-right'><input class='uk-radio' type='radio' name='card' value='5' checked> 5%</label><label class='uk-margin-small-right'><input class='uk-radio' type='radio' name='card' value='10'> 10%</label><label><input class='uk-radio' type='radio' name='card' value='15'> 15%</label>");

	if ($(".uk-checkbox").is(":checked")) {  
		
	} else {
		$('#salecard > *').remove();
		$('#salecard').addClass('uk-hidden');
	}
};

/* FORM */

$('#basket_finish').on('submit', function() {
   var form = $(this);
   var data = $(this).serialize();
   $.ajax({
      method: "POST",
      url: "/ajax/orderform.php",
      data: data
   }).done(function(msg) {
      if (msg == 'OK') {
         UIkit.notification("<span uk-icon='icon: check'>Заявка отправлена</span>", {
            status: 'success'
         });
         $('#basket_finish')[0].reset();

         function hidden() {
				window.location.href = '/preorder/';
         };
         setTimeout(hidden, 3000);
			var order = '';
			Cookies.set('IdOrder', order, {expires: 7});
      } else {
         var d = $.parseJSON(msg);
         UIkit.notification("<span uk-icon='icon: close'>Произошла ошибка, попробуйте позднее</span>", {
            status: 'danger'
         });
         $('#basket_finish')[0].reset();

         function hidden() {
				window.location.href = '/preorder/';
         };
         setTimeout(hidden, 3500);
      }
   });
   return false;
});

</script>

<script src="/ajax/basketscript.js?<?=$reset_cache?>"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.11/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>





