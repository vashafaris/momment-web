<?php

$type = 'filter';

if(Request::route()->named('compare')) {
    $type = 'compare';
}

$account = Auth::user();

?>

<aside id="leftsidebar" class="sidebar">
    <div class="user-info">
        <div class="info-container">
            <div class="role"><span class="badge bg-light-blue">{{ $account->name }}</span></div>
            {{-- <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $account->fullname }}</div>
            <div class="email">Department of {{ (!is_null($account->dept_id)) ? $account->department->name : '-' }}</div>
            <div class="email">{{ $account->account->company_name }}</div> --}}
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    {{-- <li><a href="{{ route('setting.profile') }}" class=" waves-effect waves-block"><i class="material-icons">settings</i>Settings</a></li> --}}
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{ url('logout') }}" class="waves-effect waves-block" onclick="event.preventDefault();$('#logout-form').submit();">
                            <i class="material-icons">input</i>Log Out
                        </a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if(Request::route()->named('dashboard') || Request::route()->named('compare'))
    @include('page.leftbar.dashboard-menu')
    @endif

    {{-- @if(strpos(Request::route()->getName(), 'setting') !== false)
    @include('page.leftbar.auth-menu')
    @endif --}}
    <!-- Footer -->
    <div class="legal" style="padding: 0px;">

    </div>
    <!-- #Footer -->
</aside>
