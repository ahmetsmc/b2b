<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('storage/' . setting('site.logo_light')) }}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('storage/' . setting('site.logo_dark_')) }}" alt="" height="17">
                    </span>
        </a>
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('storage/' . setting('site.logo_sm')) }}" alt="" height="22">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('storage/' . setting('site.logo_light')) }}" alt="" height="17">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link menu-link">
                        <i class="ri-layout-3-line"></i> Yönetim Paneli
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#productsMenuContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="productsMenuContent">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Ürünler</span>
                    </a>
                    <div class="collapse menu-dropdown" id="productsMenuContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Ürün Listesi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.categories.index') }}" class="nav-link">Ürün Grubu Listesi</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#offersMenuContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="offersMenuContent">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Siparişler</span>
                    </a>
                    <div class="collapse menu-dropdown" id="offersMenuContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Bekleyen Siparişler</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Tamamlanan Siparişler</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Raporlar</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#customersMenuContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="customersMenuContent">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Firmalar ve Kullanıcılar</span>
                    </a>
                    <div class="collapse menu-dropdown" id="customersMenuContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Firma Listesi</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Kullanıcı Listesi</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#settingsMenuContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingsMenuContent">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Ayarlar</span>
                    </a>
                    <div class="collapse menu-dropdown" id="settingsMenuContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Genel Ayarlar</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.products.index') }}" class="nav-link">Sistem Ayarları</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
