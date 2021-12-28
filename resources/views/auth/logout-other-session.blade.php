@php
    $sessions=(new App\Http\Controllers\Auth\LogoutOtherBrowserSessionsController())->getSessionsProperty();
@endphp
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{__('global.browser.header')}}
                </div>
                <div class="card-body">

                    <div class="max-w-xl text-sm text-gray-600">
                        {{__('global.browser.text')}}
                    </div>

                    <!-- Other Browser Sessions -->
                    @foreach($sessions as $session)
                        <div class="mt-5 space-y-6">
                            <div class="flex items-center">
                                <div class="row">
                                    <div class="col-sm" style="max-width: 10%">
                                        @if($session->agent->isDesktop())
                                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                 stroke-width="2"
                                                 viewBox="0 0 24 24" stroke="currentColor"
                                                 class="w-20 h-20 text-gray-500"
                                            >
                                                <path
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2"
                                                 stroke="currentColor" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 class="w-20 h-20 text-gray-500">
                                                <path d="M0 0h24v24H0z" stroke="none"></path>
                                                <rect x="7" y="4" width="10" height="16" rx="1"></rect>
                                                <path d="M11 5h2M12 17v.01"></path>
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="col-sm">
                                        <div class="text-sm text-gray-600">
                                            {{ $session->agent->platform() }}
                                            - {{ $session->agent->browser() }} @if($session->is_current_device)<i
                                                class="fas fa-badge-check"></i> @endif
                                        </div>

                                        <div>
                                            <div class="text-xs text-gray-500">
                                                {{ $session->ip_address }},

                                                <span class="text-green-500 font-semibold"
                                                      v-if="session.is_current_device">{{__('global.browser.message')}} {{ $session->last_active }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex items-center mt-5">
                        <button onclick="$('#myModal').modal('show')">
                            {{__('global.browser.button')}}
                        </button>
                    </div>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {!! Form::open(['route'=>'user.setting.logoutBrowser']) !!}
                                <div class="modal-header">
                                    <h5 class="modal-title">{{__('global.browser.button')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('global.browser.text')}}</p>
                                    <input type="password" name="password" id="password">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">{{__('global.browser.button')}}
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">{{__('global.close')}}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <!-- Log Out Other Devices Confirmation Modal -->

                </div>
            </div>
        </div>
    </div>
</div>

