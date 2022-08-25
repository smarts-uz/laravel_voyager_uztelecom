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
        <?php echo $__env->make('site.dashboard.language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <?php if($notifications->count() !== 0): ?>
                <span class="badge badge-warning navbar-badge red-notification bg-danger" id="notification_count"><?php echo e($notifications->count()); ?></span>
            <?php endif; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifications">
            <span class="dropdown-header" id="notification_count_text"><?php echo e($notifications->count()); ?> Notifications</span>
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo e(route('site.applications.show', ['application' => $notification->application->id, 'view' => 1])); ?>" class="dropdown-item" target="new">
                    <i class="fas fa-envelope mr-2"></i><?php echo e($notification->message); ?>

                    <span class="float-right text-muted text-sm">
                        <?php echo e(now()->diffInMinutes($notification->created_at)); ?> mins
                    </span>
                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>












        </div>
    </li>
    <li class="nav-item">
        <div class="relative inline-block ">
            <button onclick="toggleDD('myDropdown')" class="drop-button text-gray-600 py-1 px-2 focus:outline-none hover:text-blue-500">
                <?php echo e(auth()->user()->name); ?>

                <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path>
                </svg>
            </button>
            <div id="myDropdown" class="dropdownlist absolute bg-gray-800 text-black right-0 mt-3 p-3 overflow-auto z-30 invisible">

                <input type="text" class="drop-search focus:outline-none rounded p-2 text-gray-600" placeholder="Search.." id="myInput" onkeyup="filterDD('myDropdown','myInput')">
                <a href="<?php echo e(route('site.profile.index')); ?>" class="p-2 hover:bg-gray-800 text-white text-sm no-underline hover:no-underline block"><i class="fa fa-user fa-fw"></i> Profile</a>
                <div class="border border-gray-800"></div>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div>
                        <i class="fas fa-sign-out-alt fa-fw text-white float-left mt-1 ml-2 mr-1"></i><input type="submit" class="bg-gray-800 text-white text-sm no-underline hover:no-underline block text-white cursor-pointer" value="Выйти">
                    </div>
                </form>
            </div>
        </div>
    </li>
</ul>
<!-- /.navbar -->


<?php $__env->startPush('scripts'); ?>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script>
        // Pusher.logToConsole = true;
        let pusher = new Pusher('<?php echo e(env("MIX_PUSHER_APP_KEY")); ?>', {
            cluster: '<?php echo e(env("PUSHER_APP_CLUSTER")); ?>',
            // encrypted: true,

            wsHost:  '<?php echo e(env('LARAVEL_WEBSOCKETS_HOST')); ?>',
            wsPort: '<?php echo e(env('LARAVEL_WEBSOCKETS_PORT')); ?>',
            forceTLS: false,
            disableStats: true,
        });
        console.log(window.location.hostname)
        let channel = pusher.subscribe('uztelecom-notification-send-' + <?php echo e(auth()->id()); ?>);
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
<?php $__env->stopPush(); ?>
<?php /**PATH E:\OpenServer\domains\laravel_voyager_uztelecom\resources\views/site/dashboard/navbar.blade.php ENDPATH**/ ?>