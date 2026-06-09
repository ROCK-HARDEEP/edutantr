<div class="app-sidebar sidebar-shadow">
    <div class="app-header-logo"></div>
    <div class="scrollbar-sidebar" data-ps-id="b8e525c7-2daf-4f3e-9b3d-0b0e0e0e0e0e">
        <div class="app-sidebar-inner">
            <ul class="vertical-nav-menu">
                <li class="menu-title">{{ __('Sales Portal') }}</li>
                <li>
                    <a href="{{ route('sales.dashboard') }}"
                        class="menu {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.students.index') }}"
                        class="menu {{ request()->routeIs('sales.students.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>{{ __('My Students') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.courses') }}"
                        class="menu {{ request()->routeIs('sales.courses') ? 'active' : '' }}">
                        <i class="fa-solid fa-book"></i>
                        <span>{{ __('Courses') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.leaderboard') }}"
                        class="menu {{ request()->routeIs('sales.leaderboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-trophy"></i>
                        <span>{{ __('Leaderboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.profile') }}"
                        class="menu {{ request()->routeIs('sales.profile') ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        <span>{{ __('Profile') }}</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="menu border-0 bg-transparent w-100 text-start">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>{{ __('Logout') }}</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
