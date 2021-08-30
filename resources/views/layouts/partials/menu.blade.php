<li class="nav-item mT-30">
    <a class="sidebar-link {{(url()->current()==route('admin.index')or url()->current()==route('client.index'))?"active":null}}"
       href="{{route('redirDASH')}}">
        <span class=" icon-holder">
    <i class="c-blue-500 ti-home"></i>
    </span>
        <span class="title">Dashboard</span>
    </a>
</li>
<li class="nav-item">






    @can('edit_user')
        <a class="sidebar-link {{ (strpos(Route::currentRouteName(), 'admin.users') == 0) ? 'active' : '' }}"
           href="{{route('admin.users.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Usuários</span>
        </a>
    @endcan
    @can('view_analytic')
        <a class="sidebar-link {{(url()->current()==route('admin.analytic.index'))?"active":null}}"
           href="{{route('admin.analytic.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Estatisticas</span>
        </a>
    @endcan
    @role('admin')
    ADMMM
    @endrole
    @role('client')
    KKKKK
    @endrole


</li>
<li class="nav-item dropdown open"><a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><i
                class="c-teal-500 ti-view-list-alt"></i> </span><span class="title">Multiple Levels</span> <span
            class="arrow"><i class="ti-angle-right"></i></span></a>
    <ul class="dropdown-menu" style="display: block;">
        <li class="nav-item dropdown"><a href="javascript:void(0);"><span>Menu Item</span></a></li>
        <li class="nav-item dropdown"><a href="javascript:void(0);"><span>Menu Item</span> <span class="arrow"><i
                        class="ti-angle-right"></i></span></a>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0);">Menu Item</a></li>
                <li><a href="javascript:void(0);">Menu Item</a></li>
            </ul>
        </li>
    </ul>
</li>
