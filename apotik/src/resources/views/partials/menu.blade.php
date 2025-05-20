<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}{{ request()->is("admin/profiles*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('profile_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.profiles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/profiles") || request()->is("admin/profiles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.profile.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('management_obat_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/golongans*") ? "c-show" : "" }} {{ request()->is("admin/jenise*") ? "c-show" : "" }} {{ request()->is("admin/obats*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-medkit c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.managementobat.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('golongan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.golongans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/golongans") || request()->is("admin/golongans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-prescription-bottle c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.golongan.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('jenis_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.jenise.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/jenise") || request()->is("admin/jenise/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-pills c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.jenis.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('obat_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.obats.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/obats") || request()->is("admin/obats/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-capsules c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.obat.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('management_pesanan_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/pesanans*") ? "c-show" : "" }} {{ request()->is("admin/pesanan_items*") ? "c-show" : "" }} {{ request()->is("admin/pengajuans*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-clipboard-list c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.managementpesanan.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pesanan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pesanans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pesanans") || request()->is("admin/pesanans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shopping-cart c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pesanan.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pengajuan_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pengajuans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pengajuans") || request()->is("admin/pengajuans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-invoice c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pengajuan.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pesanan_item_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pesananitems.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pesananitems") || request()->is("admin/pesananitems/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-box c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pesananitem.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('management_pengiriman_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/pengirims*") ? "c-show" : "" }} {{ request()->is("admin/pengirimans*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-truck c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.managementpengiriman.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pengirim_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pengirims.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pengirims") || request()->is("admin/pengirims/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-id-badge c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pengirim.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('pengiriman_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.pengirimans.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/pengirimans") || request()->is("admin/pengirimans/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-shipping-fast c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.pengiriman.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>