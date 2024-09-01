<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <img class="app-brand-logo demo" src="/assets/img/icon.png" alt="">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Tables">Dashboard</div>
            </a>
        </li>
        {{-- <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboards">Dashboards</div>
                <div class="badge bg-danger rounded-pill ms-auto">5</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item active">
                    <a href="index.html" class="menu-link">
                        <div data-i18n="">Analytics</div>
                    </a>
                </li>


            </ul>
        </li> --}}
        <!-- Pages -->
        <li
            class="menu-item  {{ Request::is('data-gudang*') || Request::is('data-kecamatan*') || Request::is('data-biaya*') || Request::is('data-distribusi*') || Request::is('permintaan-kec*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="">Data</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('data-gudang*') ? 'active' : '' }}">
                    <a href="/data-gudang" class="menu-link">
                        <div data-i18n="">Data Gudang</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('data-kecamatan*') ? 'active' : '' }}">
                    <a href="/data-kecamatan" class="menu-link">
                        <div data-i18n="Notifications">Data Kecamatan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('permintaan-kec*') ? 'active' : '' }}">
                    <a href="/permintaan-kec" class="menu-link">
                        <div data-i18n="Notifications">Data Permintaan</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('data-biaya*') ? 'active' : '' }}">
                    <a href="/data-biaya" class="menu-link">
                        <div data-i18n="Notifications">Data Biaya Pengiriman</div>
                    </a>
                </li>
                <!-- <li class="menu-item">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                        <div data-i18n="Connections">Data Persediaan</div>
                    </a>
                </li> -->

                <li class="menu-item {{ Request::is('data-distribusi*') ? 'active' : '' }}">
                    <a href="/data-distribusi" class="menu-link">
                        <div data-i18n="Connections">Data Pendistribusian</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ Request::is('optimasi-biaya*') ? 'active' : '' }}">
                    <a href="/optimasi-biaya" class="menu-link">
                        <div data-i18n="Notifications">Perhitungan Optimasi Biaya</div>
                    </a>
                </li> --}}
            </ul>
        </li>

        <li class="menu-item {{ Request::is('optimasi-biaya') ? 'active' : '' }}">
            <a href="/optimasi-biaya" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calculator"></i>
                <div data-i18n="Tables">Perhitungan Optimasi Biaya</div>
            </a>
        </li>
    </ul>
</aside>
