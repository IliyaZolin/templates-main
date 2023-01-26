function addorder(id) {
	var arr = Cookies.get('IdOrder');
	$.ajax({
		url: '/ajax/orderindex.php',
		method: 'get',
		dataType: 'html',
		data: {
			id: id,
			arr: arr,
		},
		success: function (data) {
			Cookies.set('IdOrder', data, {
				expires: 7
			});
			UIkit.notification("Добавлен: " + id + "", {
				status: 'primary'
			});
			
			const result = data.split(',');
			result.forEach(function (elem) {
				var data = $('[data-id=' + elem + ']').parent();
				data.find('.add_to_cart').remove();
				data.html('<button class="color-blue-dark remove_to_cart" onclick="delorder(' + elem + ')" data-id="' + elem + '" data-count="1 ">Отменить</button>');
			});
			// меняем значение в корзине
			const numres = data.split(',');
			var numbasket = numres.length;
			
			$href = $('#SetNum_basket a').attr('href');
			if ($href == '') {
				$('#SetNum_basket>*').remove();
				$('#SetNum_basket').html('<a onclick="getitem()" href="#modal-container" uk-toggle><span id="Num_basket">' + numbasket + '</span></a>');
			} else {
				$('#Num_basket').text(numbasket);
			}
		}
	});

};

function delorder(id) {
	var arr = Cookies.get('IdOrder');
	data = $('[data-id=' + id + ']').parent();
	data.find('.remove_to_cart').remove();
	data.html('<button class="color-blue-dark add_to_cart" onclick="addorder(' + id + ')" data-id="' + id + '" data-count="1">Выбрать</button>');
	$.ajax({
		url: '/ajax/orderindex.php',
		method: 'get',
		dataType: 'html',
		data: {
			id: id,
			arr: arr,
		},
		success: function (data) {
			Cookies.set('IdOrder', data, {expires: 7});

			UIkit.notification("Удален: " + id + "", {
				status: 'primary'
			});

			$row = $('.add__new_element');
			$row.find('#prod_' + id + '').fadeOut("slow");

			$modal = $('.modal__new_element');
			$modal.find('#prod_' + id + '').fadeOut("slow");
			// установка цены
			$price = Number(200);

			if (data != '') {
				const arrid = data.split(',');
				arrid.forEach(function(elem) {
					$price += Number($('#price_'+ elem + '').attr('data-price'));
				});
			}
			
			if ($price > 200) {
				$('.sz_full_price_Modal').text($price);
				$('.sz-done-div__price').text($price);
			} else {
				$('.sz_full_price_Modal').text('0');
				$('.sz-done-div__price').text('0');
			}
			// меняем значение в корзине
			if (data != '') {
				const numres = data.split(',');
				var numbasket = numres.length;
				$('#Num_basket').text(numbasket);
			} else {
				$('#Num_basket').text('0');
			}

		}
	});
};

function delall() {
	var id = '';
	$.ajax({
		url: '/ajax/orderindex.php',
		method: 'get',
		dataType: 'html',
		data: {
			id: id,
			arr: '',
		},
		success: function (data) {
			Cookies.set('IdOrder', data, {expires: 7});
			UIkit.notification("Удалены все позиции", {
				status: 'primary'
			});
			$('#index_prod').addClass('uk-hidden');
			$('#sz-body-empty').removeClass('uk-hidden');

			setTimeout(function () {
				$('.uk-spinner').remove();
				$('.sz-body-empty__text').removeClass('uk-hidden');
			}, 2000);
		}
	});

};

function getitem() {
	$('.modal__new_element *').remove();
	$cookiearr = Cookies.get('IdOrder');
	if ($cookiearr != '') {
		var cookie = $cookiearr;
		$.ajax({
			url: '/preorder/orderelements.php',
			method: 'get',
			dataType: 'html',
			data: {
				id: cookie,
			},
			success: function(data) {
				$('.modal__new_element').append(data);

				var arrs = Cookies.get('IdOrder');
				$price = Number(200);
				const arr = arrs.split(',');
				arr.forEach(function(elem) {
					$price += Number($('#price_'+ elem + '').attr('data-price'));
				});
				$('.sz_full_price_Modal').text($price);
			}
		});
	};
};

/* обновление корзины при загрузке страницы */

$(document).ready(function() { //
	$cookiearr = Cookies.get('IdOrder');
	if ($cookiearr != '') {
		var cookiearr = $cookiearr;
		const arr = cookiearr.split(',');
		var num = arr.length;
		$('#SetNum_basket').html('<a onclick="getitem()" href="#modal-container" uk-toggle><span id="Num_basket">' + num + '</span></a>');
	} else {
		$('#SetNum_basket').html('<a href=""><span id="Num_basket">0</span></a>');
	};
});

$(document).ready(function() {
	$cookiearr = Cookies.get('IdOrder');
	if ($cookiearr != '') {
		var cookiearr = $cookiearr;
		const result = cookiearr.split(',');
		result.forEach(function (elem) {
			$data = $('[data-id=' + elem + ']').parent();
			$data.find('.add_to_cart').remove();
			$data.html('<button class="color-blue-dark remove_to_cart" onclick="delorder(' + elem + ')" data-id="' + elem + '" data-count="1 ">Отменить</button>');
		});
	}
	
});