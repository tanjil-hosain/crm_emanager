    <div class="sidebar-wrapper" id="sidebar">
        <!-- Brand Logo / Identity -->
        <a href="index.html" class="sidebar-brand">
            @if ($setting?->logo)

                <img src="{{ Storage::url($setting->logo) }}" width="{{ $setting->logo_type == 'icon' ? '60' : '200' }}"
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
            <!-- Group: Menu -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Menu</div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('dashboard') }}" class="sidebar-menu-link active" id="menu-overview"
                            title="Overview">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Group: Components -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">User Managment</div>
                <ul class="sidebar-menu-list">
                    {{-- @can('view users') --}}
                    <li class="sidebar-menu-item">
                        <a href="{{ route('users.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Userlist</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('customers.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Customerlist</span>
                        </a>
                    </li>
                    {{-- @endcan --}}
                    <li class="sidebar-menu-item">
                        <a href="{{ route('category.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Category</span>
                        </a>

                                         <li class="sidebar-menu-item">
                        <a href="{{ route('subcategory.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Subcategory</span>
                        </a>
                    </li>
                                        </li>
                     <li class="sidebar-menu-item">
                        <a href="{{ route('products.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Product</span>
                        </a>
                    </li>
                                        </li>
                     <li class="sidebar-menu-item">
                        <a href="{{ route('sales.index') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Sales</span>
                        </a>
                    </li>
                    {{-- @can('roles') --}}
                    <li class="sidebar-menu-item">
                        <a href="{{ route('role.create') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Role</span>
                        </a>
                    </li>
                    {{-- @endcan --}}
                    {{-- @can('permissions') --}}
                    <li class="sidebar-menu-item">
                        <a href="{{ route('role.permission.create') }}" class="sidebar-menu-link" id="menu-basictables"
                            title="Basic Tables">
                            <i class="bi bi-table"></i>
                            <span>Permission</span>
                        </a>
                    </li>
                    {{-- @endcan --}}
                    <li class="sidebar-menu-item">
                        <a href="{{ route('leads.index') }}" class="sidebar-menu-link" id="menu-uiforms"
                            title="Forms and Input">
                            <i class="bi bi-input-cursor-text"></i>
                            <span>Leads</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('users.trash') }}" class="sidebar-menu-link" id="menu-uiforms"
                            title="Forms and Input">
                            <i class="bi bi-input-cursor-text"></i>
                            <span>Trash</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('setting.index') }}" class="sidebar-menu-link" id="menu-uibuttons"
                            title="Buttons">
                            <i class="bi bi-menu-button-wide-fill"></i>
                            <span>Settings</span>
                        </a>

                    </li>
                </ul>
            </div>


        </div>

        <!-- Sidebar Profile Card (Dynamic Footer) -->
        <div class="sidebar-profile">
            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Administrator" class="sidebar-profile-img">
            <div class="sidebar-profile-info">
                <div class="sidebar-profile-name">{{ Auth::user()->name }}</div>
                <div class="sidebar-profile-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
