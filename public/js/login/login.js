$(function () {
	$('#btnLogin').on('click', function (event) {
		$.ajax({
			method: "POST",
			url: "http://localhost/esenceweb_cart_task/API/Auth/login",
			data: {
				sUserName: $('#txtUserName').val(),
				sPassHash: $('#txtPassword').val()
			}
		}).done(
			(rsp) => { window.location = "Home"; }
		).fail(
			(err) => { alert('Failed to log in'); }
		);
	})
})
