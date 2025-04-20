<div class="sidebar">
    <!-- Sidebar Search -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Menu Admin -->
            @if(Auth::user()->id_level == 1)
            <li class="nav-header">Master Data</li>

            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/kategori_ukm') }}" class="nav-link {{ ($activeMenu == 'kategori_ukm') ? 'active' : '' }}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori UKM</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/ukm') }}" class="nav-link {{ ($activeMenu == 'ukm') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Data UKM</p>
                </a>
            </li>
            @endif

            <!-- Profil (untuk semua user) -->
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ ($activeMenu == 'profile') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>

            <!-- Menu Mahasiswa -->
            @if(Auth::user()->id_level == 2)
            <li class="nav-item">
                <a href="{{ url('/ukm/mahasiswa') }}" class="nav-link {{ ($activeMenu == 'ukm-mahasiswa') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>UKM</p>
                </a>
            </li>
            @endif
        </ul>
    </nav>
</div>