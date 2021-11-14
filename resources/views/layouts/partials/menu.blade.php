<li class="nav-item mT-30">
    <a class="sidebar-link {{(url()->current()==route('admin.index'))?"active":null}}"
       href="{{route('redirDASH')}}">
        <span class=" icon-holder">
    <i class="c-blue-500 ti-home"></i>
    </span>
        <span class="title">Dashboard</span>
    </a>
</li>

@can('edit_user')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.users') }}"
           href="{{route('admin.users.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Usuários</span>
        </a>
    </li>
@endcan



@can('edit_company')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.company') }}"
           href="{{route('admin.company.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Empresas</span>
        </a>
    </li>
@endcan

@can('edit_employee')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.employee') }}"
           href="{{route('admin.employee.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Funcionários</span>
        </a>
    </li>
@endcan


@can('edit_employee')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.benefit') }}"
           href="{{route('admin.benefit.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Beneficios</span>
        </a>
    </li>
@endcan

@can('edit_client')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.clients') }}"
           href="{{route('admin.clients.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Clientes</span>
        </a>
    </li>
@endcan

@can('edit_scheduling')
    <li class="nav-item dropdown {{ routeActive('admin.calendar','open') }}">
        <a class="dropdown-toggle" href="javascript:void(0);">
            <span class="icon-holder">
                <i class="c-teal-500 ti-view-list-alt"></i>
            </span>
            <span class="title">Agendamentos</span>
            <span class="arrow"><i class="ti-angle-right"></i></span>
        </a>
        <ul class="dropdown-menu">
            <li class="nav-item "><a href="{{route('admin.calendar.index')}}"
                                     class="{{routeActive('admin.calendar.index')}}"><span>Listar Agendamento</span></a>
            </li>
            <li class="nav-item "><a href="{{route('admin.calendar.systemCalendar')}}"
                                     class="{{routeActive('admin.calendar.systemCalendar')}}"><span>Ver Agendamentos</span></a>
            </li>
        </ul>
    </li>
@endcan

@can('view_analytic')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.analytic.index')}}"
           href="{{route('admin.analytic.index')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title">Estatisticas</span>
        </a>
    </li>
@endcan


@can('view_analytic')
    <li class="nav-item">
        <a class="sidebar-link {{ routeActive('admin.log.activity')}}"
           href="{{route('admin.log.activity')}}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
            <span class="title" title="Registro de Atividades">Registro</span>
        </a>
    </li>
@endcan



{{--<li class="nav-item dropdown open"><a class="dropdown-toggle" href="javascript:void(0);"><span class="icon-holder"><i
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
</li> --}}
