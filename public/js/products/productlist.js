$(function () {

	var promProductList = fetch('http://localhost/esenceweb_cart_task/API/Products');

	$.ajax("http://localhost/esenceweb_cart_task/API/Products").then(
		(rsp) => {
			console.log(rsp.data.arrProductInfo);
			$('#tblProducts').DataTable({
				'data': rsp.data.arrProductInfo,
				"columns": [
					{ "data": 'sName' },
					{ "data": 'rPrice' }
				]

			})
		},
		(err) => {
			console.error(err);
		}
	)
});
