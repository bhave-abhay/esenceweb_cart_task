$(function () {

	var promProductList = fetch('http://localhost/esenceweb_cart_task/API/Products');


	$.ajax("http://localhost/esenceweb_cart_task/API/Products").then(
		(rsp) => {
			var renderAddToCartButton = function (data, type, row, meta ) {
				if(type=='display'){
					if(SESSION_ID != null) {
						return '<a href="#" class="badge rounded-pill bg-primary btn-add-product-to-cart">Add to cart</a>';
					}
				}
				return '';
			}
			console.log(rsp.data.arrProductInfo);
			var tblProducts = $('#tblProducts').DataTable({
				'data': rsp.data.arrProductInfo,
				"columns": [
					{ "data": 'sName' },
					{ "data": 'rPrice' },
					{
						"render": renderAddToCartButton,
						'orderable': false
					}
				]

			});
			$('#tblProducts').on('click', '.btn-add-product-to-cart', function(event) {
				var rowData = tblProducts.row($(event.target).closest('tr')).data();
				alert(JSON.stringify(rowData));
			})
		},
		(err) => {
			console.error(err);
		}
	)
});
