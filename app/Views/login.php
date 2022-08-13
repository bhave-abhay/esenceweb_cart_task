<div class="mb-5"></div>
<div class="container center">
	<div class="col-4 offset-4 align-middle">
		<form id="formLogin" action="<?= site_url('API/Auth/login'); ?>" method="post">
			<img class="mb-4" src="./Resources/Images/main-logo-black.png" alt="" width="200" height="57">
			<h1 class="h3 mb-3 fw-normal">Please sign in</h1>

			<div class="form-floating">
				<input type="text" class="form-control" id="txtUserName" name="sUserName" placeholder="name@example.com">
				<label for="txtUserName">User name</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="txtPassword" name="sPassHash" placeholder="Password">
				<label for="txtPassword">Password</label>
			</div>
			<div class="mb-3">

			</div>
			<!-- <div class="checkbox mb-3">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div> -->
			<button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
		</form>

	</div>

</div>
