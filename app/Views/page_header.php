<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <img class="me-2" width="200" role="img" src="./Resources/Images/main-logo-black.png" alt="" />
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="Home" class="nav-link px-2 link-dark<?= (($sNavLink??'')=='Home' ? 'active' : '') ?>">Home</a></li>
                <li><a href="Products" class="nav-link px-2 link-dark<?= (($sNavLink??'')=='Products' ? 'active' : '') ?>">Products</a></li>
                <?php if(!isset($userData)) :?>
                <li><a href="Login" class="nav-link px-2 link-dark<?= (($sNavLink??'')=='Log In' ? 'active' : '') ?>">Log In</a></li>
            <?php endif; ?>
            </ul>

            <?php if(isset($userData)) :?>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" class="rounded-circle" width="32" height="32">
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="Cart">My Cart</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('API/Auth/logout') ?>">Sign out</a></li>
                </ul>
            </div>
        <?php endif; ?>
        </div>
    </div>
</header>
