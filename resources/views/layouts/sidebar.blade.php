<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <h5 class="text-primary ms-3">
                {{ Auth::user()->role == 'Admin' ? 'Admin' : 'Petugas' }}
                </h5>
            <button class="btn btn-light d-xl-none d-block border-0" id="sidebarCollapse">
                <i class="ti ti-x"></i>
                </button>
            </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link"
                        href="{{ Auth::user()->role == 'Admin' ? route('admin.dashboard') : route('employee.dashboard') }}">
                        <i class="ti ti-home"></i> <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('products.index') }}">
                        <i class="ti ti-basket"></i> <span class="hide-menu">Product</span>
                        </a>
                    </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('orders.index') }}">
                        <i class="ti ti-shopping-cart"></i> <span
                            class="hide-menu">Penjualan</span>
                        </a>
                    </li>
                @if (Auth::user()->role == 'Admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.user') }}">
                            <i class="ti ti-user"></i> <span class="hide-menu">User
                                Management</span>
                            </a>
                        </li>
                @endif
                </ul>
            </nav>
        </div>
</aside>
