<?php
use App\Models\Notification;
$notifications = Notification::with('application:id,created_at')->has('application')
    ->where('user_id', auth()->id())
    ->where('is_read', 0)
    ->get();
?>
<!-- Navbar -->
<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
</ul>

<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
            <form class="form-inline">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>
    <li class="nav-item">
        @include('site.dashboard.language')
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            @if($notifications->count() !== 0)
                <span class="badge badge-warning navbar-badge" id="notification_count">{{$notifications->count()}}</span>
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifications">
            <span class="dropdown-header" id="notification_count_text">{{$notifications->count()}} Notifications</span>
            @foreach($notifications as $notification)
                <div class="dropdown-divider"></div>
                <a href="{{route('site.applications.show', ['application' => $notification->application->id, 'view' => 1])}}" class="dropdown-item" target="new">
                    <i class="fas fa-envelope mr-2"></i>{{$notification->message}}
                    <span class="float-right text-muted text-sm">
                        {{now()->diffInMinutes($notification->created_at)}} mins
                    </span>
                </a>
{{--                @if($loop->index == 10) @break @endif--}}
            @endforeach
{{--            <div class="dropdown-divider"></div>--}}
{{--            <a href="#" class="dropdown-item">--}}
{{--                <i class="fas fa-users mr-2"></i> 8 friend requests--}}
{{--                <span class="float-right text-muted text-sm">12 hours</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-divider"></div>--}}
{{--            <a href="#" class="dropdown-item">--}}
{{--                <i class="fas fa-file mr-2"></i> 3 new reports--}}
{{--                <span class="float-right text-muted text-sm">2 days</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-divider"></div>--}}
{{--            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
        </div>
    </li>
    <li class="nav-item">
        <div class="relative inline-block ">
            <button onclick="toggleDD('myDropdown')" class="drop-button text-gray-600 py-1 px-2 focus:outline-none hover:text-blue-500">
                {{auth()->user()->name}}
                <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>
            <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-black right-0 mt-3 p-3 overflow-auto z-30 invisible">

                <input type="text" class="drop-search focus:outline-none rounded p-2 text-gray-600" placeholder="Search.." id="myInput" onkeyup="filterDD('myDropdown','myInput')">
                <a href="{{route('site.profile.index')}}" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i> Profile</a>
                <div class="border border-gray-800"></div>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <div>
                        <i class="fas fa-sign-out-alt fa-fw text-white float-left mt-1 ml-2 mr-1"></i><input type="submit" class="bg-gray-800 text-white text-sm no-underline hover:no-underline block text-white cursor-pointer" value="Выйти">
                    </div>
                </form>
            </div>
        </div>
    </li>
</ul>
<!-- /.navbar -->


@push('scripts')
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script>
        // Pusher.logToConsole = true;
        let pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
            cluster: '{{env("PUSHER_APP_CLUSTER")}}',
            // encrypted: true,

            wsHost:  '{{env('LARAVEL_WEBSOCKETS_HOST')}}',
            wsPort: '{{env('LARAVEL_WEBSOCKETS_PORT')}}',
            forceTLS: false,
            disableStats: true,
        });
        console.log(window.location.hostname)
        let channel = pusher.subscribe('uztelecom-notification-send-' + {{auth()->id()}});
        let count = parseInt($('#notification_count').text());
        channel.bind('server-user', function(data) {
            data = JSON.parse(data.data)
            console.log(data)
            count += 1;
            $('#notification_count').text(count);
            $('#notification_count_text').text(count + ' Notifications');
            $('#notifications').append(`
                <div class="dropdown-divider"></div>
                <a href="http://uztelecom.loc/ru/site/applications/${data['id']}/show/1" class="dropdown-item" target="new">
                    <i class="fas fa-envelope mr-2"></i> New message
                    <span class="float-right text-muted text-sm">${data['time']} minutes</span>
                </a>`)
        });
    </script>
@endpush
