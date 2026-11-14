
<div class="sidebar-wrapper" id="sidebar">

    <!-- Brand Logo / Identity -->
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        @if ($setting?->logo)

            <img src="{{ Storage::url($setting->logo) }}"
                width="{{ $setting->logo_type == 'icon' ? '60' : '200' }}"
                alt="Logo">

            @if ($setting->logo_type == 'icon' && $setting->site_name)
                <span>{{ $setting->site_name }}</span>
            @endif

        @elseif($setting?->site_name)
            <span>{{ $setting->site_name }}</span>
        @else
            <span>My Website</span>
        @endif
    </a>


    <!-- Navigation Menu -->
    <div class="flex-grow-1 overflow-y-auto">

        @can('view dashboard')
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Menu</div>

                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-menu-link"
                            id="menu-overview"
                            title="Overview">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>
        @endcan


        <!-- User Management -->
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">User Management</div>

            <ul class="sidebar-menu-list">

                @can('view users')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('users.index') }}"
                            class="sidebar-menu-link"
                            title="Userlist">
                            <i class="bi bi-person-add"></i>
                            <span>Userlist</span>
                        </a>
                    </li>
                @endcan


                @can('view customers')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('customers.index') }}"
                            class="sidebar-menu-link"
                            title="Customerlist">
                            <i class="bi bi-person-fill-add"></i>
                            <span>Customerlist</span>
                        </a>
                    </li>
                @endcan


                @can('view categories')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('category.index') }}"
                            class="sidebar-menu-link"
                            title="Category">
                            <i class="bi bi-collection-fill"></i>
                            <span>Category</span>
                        </a>
                    </li>
                @endcan


                @can('view subcategories')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('subcategory.index') }}"
                            class="sidebar-menu-link"
                            title="Subcategory">
                            <i class="bi bi-folder-symlink-fill"></i>
                            <span>Subcategory</span>
                        </a>
                    </li>
                @endcan


                @can('view products')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('products.index') }}"
                            class="sidebar-menu-link"
                            title="Product">
                            <i class="bi bi-bag-plus-fill"></i>
                            <span>Product</span>
                        </a>
                    </li>
                @endcan


                @can('view sales')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('sales.index') }}"
                            class="sidebar-menu-link"
                            title="Sales">
                            <i class="bi bi-cart-fill"></i>
                            <span>Sales</span>
                        </a>
                    </li>
                @endcan


                @can('roles')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('role.create') }}"
                            class="sidebar-menu-link"
                            title="Role">
                            <i class="bi bi-people-fill"></i>
                            <span>Role</span>
                        </a>
                    </li>
                @endcan


                @can('role permissions')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('role.permission.create') }}"
                            class="sidebar-menu-link"
                            title="Permission">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Permission</span>
                        </a>
                    </li>
                @endcan


                @can('view leads')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('leads.index') }}"
                            class="sidebar-menu-link"
                            title="Leads">
                            <i class="bi bi-funnel-fill"></i>
                            <span>Leads</span>
                        </a>
                    </li>
                @endcan


                @can('view users')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('users.trash') }}"
                            class="sidebar-menu-link"
                            title="Trash">
                            <i class="bi bi-trash3-fill"></i>
                            <span>Trash</span>
                        </a>
                    </li>
                @endcan


                @can('settings')
                    <li class="sidebar-menu-item">
                        <a href="{{ route('setting.index') }}"
                            class="sidebar-menu-link"
                            title="Settings">
                            <i class="bi bi-gear-fill"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>

    </div>


    <!-- Sidebar Profile Card -->
    <div class="sidebar-profile">

        <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('default-user.png') }}"
            alt="User"
            class="sidebar-profile-img">

        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name">
                {{ Auth::user()->name }}
            </div>

            <div class="sidebar-profile-email">
                {{ Auth::user()->email }}
            </div>
        </div>

    </div>

</div>
