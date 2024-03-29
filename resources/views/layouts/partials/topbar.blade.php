<div class="header navbar noPrint">
    <div class="header-container">
        <ul class="nav-left">
            <li>
                <a id='sidebar-toggle' class="sidebar-toggle" href="javascript:void(0);">
                    <i class="ti-menu"></i>
                </a>
            </li>
{{--            <li class="search-box">--}}
{{--                <a class="search-toggle no-pdd-right" href="javascript:void(0);">--}}
{{--                    <i class="search-icon ti-search pdd-right-10"></i>--}}
{{--                    <i class="search-icon-close ti-close pdd-right-10"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="search-input">--}}
{{--                <input class="form-control" type="text" placeholder="Search...">--}}
{{--            </li>--}}
        </ul>

        <ul class="nav-right">

            <!-- Avisos -->
            @can('view_notification')
            <li class="notifications dropdown">
                <span class="counter bgc-red">{{$user->unreadNotifications()->count()}}</span>
                <a href="" class="dropdown-toggle no-after" data-toggle="dropdown">
                    <i class="ti-bell"></i>
                </a>

                <ul class="dropdown-menu">
                    <li class="pX-20 pY-15 bdB">
                        <i class="ti-bell pR-10"></i>
                        <span class="fsz-sm fw-600 c-grey-900">Avisos</span>
                    </li>
                    <li>
                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">


                            @foreach($user->unreadNotifications()->take(5)->get() as $notice)
                                <li>
                                    <a href="{{route('admin.notifications.index')}}"
                                       class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'
                                       >
                                        <input type="hidden" name="notification" id="notification_id" value="{{$notice->id}}" onclick="">
                                        <div class="peer mR-15">
                                            <i class="fal fa-envelope w-3r bdrs-50p"></i>

                                        </div>
                                        <div class="peer peer-greed">
                                        <span>
                                            <span class="fw-500">{{$notice->data['title']}}</span>
                                            <span class="c-grey-600">{{resumo(cleanText($notice->data['body']),50)}}
                                            </span>
                                        </span>
                                            <p class="m-0">
                                                <small class="fsz-xs">{{$notice['created_at']}}</small>
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="pX-20 pY-15 ta-c bdT">
                        <span>
                            <a href="{{route('admin.notifications.all')}}" class="c-grey-600 cH-blue fsz-sm td-n">Ver todos os Avisos
                                <i class="ti-angle-right fsz-xs mL-10"></i>
                            </a>
                        </span>
                    </li>
                </ul>
            </li>
            @endcan
            <!-- /Avisos -->
            <!-- Mensagens -->
{{--            <li class="notifications dropdown">--}}
{{--                <span class="counter bgc-blue">{{\App\Actions\Message\GetAlert::getMessage()->count()}}</span>--}}
{{--                <a href="" class="dropdown-toggle no-after" data-toggle="dropdown">--}}
{{--                    <i class="ti-email"></i>--}}
{{--                </a>--}}

{{--                <ul class="dropdown-menu">--}}
{{--                    <li class="pX-20 pY-15 bdB">--}}
{{--                        <i class="ti-email pR-10"></i>--}}
{{--                        <span class="fsz-sm fw-600 c-grey-900">Mensagens</span>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">--}}
{{--                            @foreach(\App\Actions\Message\GetAlert::getMessage() as $message)--}}
{{--                                <li>--}}
{{--                                    <a href="" class='peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100'>--}}
{{--                                        <div class="peer mR-15">--}}
{{--                                            <img class="w-3r bdrs-50p" src="/images/1.jpg" alt="">--}}
{{--                                        </div>--}}
{{--                                        <div class="peer peer-greed">--}}
{{--                                            <div>--}}
{{--                                                <div class="peers jc-sb fxw-nw mB-5">--}}
{{--                                                    <div class="peer">--}}
{{--                                                        <p class="fw-500 mB-0">John Doe</p>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="peer">--}}
{{--                                                        <small class="fsz-xs">5 mins ago</small>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <span class="c-grey-600 fsz-sm">--}}
{{--                                                Want to create your own customized data generator for your app...--}}
{{--                                            </span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="pX-20 pY-15 ta-c bdT">--}}
{{--                        <span>--}}
{{--                            <a href="" class="c-grey-600 cH-blue fsz-sm td-n">Ver todas as Mensagens <i--}}
{{--                                    class="fs-xs ti-angle-right mL-10"></i>--}}
{{--                            </a>--}}
{{--                        </span>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <!-- /Mensagens -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                    <div class="peer mR-10">
                        <img class="w-2r bdrs-50p" src="{{ $user->avatar ??asset('/images/photos/gravatar.svg')}}" style="max-width: 100px;max-height: 100px" alt="">
                    </div>
                    <div class="peer">
                        <span class="fsz-sm c-grey-900">{{ $user->name }}</span>
                    </div>
                </a>
                <ul class="dropdown-menu fsz-sm">
                    <li>
                        <a href="{{route('user.setting')}}" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-settings mR-10"></i>
                            <span>{{__('view.setting')}}</span>
                        </a>
                    </li>
                    {{--<li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-user mR-10"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-email mR-10"></i>
                            <span>Messages</span>
                        </a>
                    </li> --}}
                    <li role="separator" class="divider"></li>
                    <li>
                        <form action="/logout" method="post" id="logout">@csrf</form>
                        <a onclick="document.getElementById('logout').submit();"
                           class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                            <i class="ti-power-off mR-10"></i>
                            <span>{{__('view.logout')}}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

