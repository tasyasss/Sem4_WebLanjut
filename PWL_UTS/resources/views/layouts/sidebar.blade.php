{{-- Sidebar navigasi utama dengan fitur pencarian dan menu untuk dashboard, data pengguna, data barang, dan transaksi --}}
<div class="sidebar">
    <!-- SidebarSearch Form -->
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
                <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Data Pengguna -->
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/petugas') }}" class="nav-link {{ $activeMenu == 'petugas' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-id-card"></i>
                    <p>Data Petugas</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/anggota') }}" class="nav-link {{ $activeMenu == 'anggota' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Data Anggota</p>
                </a>
            </li>

            <!-- Data Barang -->
            <li class="nav-header">Data Barang</li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori Buku</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/rak') }}" class="nav-link {{ $activeMenu == 'rak' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Rak Buku</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/buku') }}" class="nav-link {{ $activeMenu == 'buku' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book"></i>
                    <p>Data Buku</p>
                </a>
            </li>

            <!-- Data Transaksi -->
            <li class="nav-header">Data Transaksi</li>
            <li class="nav-item">
                <a href="{{ url('/pinjam') }}" class="nav-link {{ $activeMenu == 'pinjam' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Peminjaman Buku</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
