$(function () {

	$.ajax("http://localhost/esenceweb_cart_task/API/Cart/myCart").then(
		(rsp) => {
			var renderQuantityColumn = function (data, type, row, meta ) {
				if(type=='display'){
					if(SESSION_ID != null) {
						return (
							'<div class="badge pill bg-primary btn-reduce-quantity">-</div>'+
							' ' + data + ' ' +
							'<div class="badge pill bg-primary btn-increase-quantity">+</div>'+
							' ' +
							'<div class="badge pill bg-danger btn-remove-item" alt="Remove">X</div>'
						);
					}
				}
				return '';
			};

			var tblCart = $('#tblCart').DataTable({
				'data': rsp.data.arrCartProductInfo,
				"columns": [
					{ "data": 'sProductName' },
					{ "data": 'rProductPrice' },
					{
						"data": 'nQuantity',
						"render": renderQuantityColumn
					},
				]

			});

			var refreshData = function() {
				$.ajax("http://localhost/esenceweb_cart_task/API/Cart/myCart").then(
					(rsp) => {
						tblCart.clear();
						tblCart.rows.add(rsp.data.arrCartProductInfo);
						tblCart.draw();
					},
					(err) => {}
				)
			}

			$('#tblCart').off('click', '.btn-reduce-quantity').on('click', '.btn-reduce-quantity', function(event) {
				var rowData = tblCart.row($(event.target).closest('tr')).data();
				// alert(JSON.stringify(rowData));
				$.ajax({
					method: "POST",
					url: "http://localhost/esenceweb_cart_task/API/Cart/removeProductFromCart",
					data: { uidProductFK: rowData.uidProductPK, nQuantity: 1 }
				})
				.done(function(rsp) {
					console.log(rsp);
					refreshData();
				});

			});

			$('#tblCart').off('click', '.btn-increase-quantity').on('click', '.btn-increase-quantity', function(event) {
				var rowData = tblCart.row($(event.target).closest('tr')).data();
				// alert(JSON.stringify(rowData));
				$.ajax({
					method: "POST",
					url: "http://localhost/esenceweb_cart_task/API/Cart/addProductToCart",
					data: { uidProductFK: rowData.uidProductPK, nQuantity: 1 }
				})
				.done(function(rsp) {
					console.log(rsp);
					refreshData();
				});

			});



			$('#tblCart').off('click', '.btn-remove-item').on('click', '.btn-remove-item', function(event) {
				var rowData = tblCart.row($(event.target).closest('tr')).data();
				// alert(JSON.stringify(rowData));
				$.ajax({
					method: "POST",
					url: "http://localhost/esenceweb_cart_task/API/Cart/removeProductFromCart",
					data: { uidProductFK: rowData.uidProductPK, nQuantity: rowData.nQuantity }
				})
				.done(function(rsp) {
					console.log(rsp);
					refreshData();
				});

			});
		},
		(err) => {
			console.error(err);
		}
	)
});
