<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                    $user = Auth::user();
                    $profile = $user->profile;
                    $avatar = $profile->avatar;
                @endphp
                @if (isset($user->social->provider_id))
                    <img src="{{ $avatar }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ isset($avatar) ? asset('/profile/') . '/' . $avatar : asset('/profile/avatar.png') }}"
                        class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('fels.user.profile', $profile) }}" class="d-block">{{ $profile->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('messages.dashboard')
                        </p>
                    </a>
                </li>
                <li class="nav-header">@lang('messages.back_end.sidebar.resources')</li>
                <li class="nav-item">
                    <a href="{{ route('admin.courses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            @lang('messages.back_end.sidebar.courses')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.words.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            @lang('messages.back_end.sidebar.words')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.lessons.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            @lang('messages.back_end.sidebar.lessons')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.question.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-indent"></i>
                        <p>
                            @lang('messages.back_end.sidebar.questions')
                        </p>
                    </a>
                </li>
                <li class="nav-item" hidden>
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            @lang('messages.back_end.sidebar.options')
                        </p>
                    </a>
                </li>
                <li class="nav-header">@lang('messages.back_end.sidebar.account')</li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            @lang('messages.back_end.sidebar.management')
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" hidden>
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('messages.back_end.sidebar.roles')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users-list') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('messages.back_end.sidebar.users')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">@lang('messages.back_end.sidebar.miscellaneous')</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            @lang('messages.back_end.sidebar.settings')
                        <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="btn_logout">
                                <i class="far fa-circle nav-icon"></i>
                                <p>@lang('messages.logout')</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
