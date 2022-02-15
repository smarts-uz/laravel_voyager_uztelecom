{{--<div class="w-2/12 h-screen float-left bg-blue-500 fixed">--}}
{{--    <div class="w-10/12 mx-auto my-10">--}}
{{--        <img src="{{ asset('images/logo.png') }}" alt="">--}}
{{--    </div>--}}
{{--    <div class="border-t border-white">--}}
{{--        <div class="mt-4 w-10/12 mx-auto">--}}
{{--            <ul>--}}
{{--                {{menu('site', 'site.dashboard.menu')}}--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<nav aria-label="alternative nav">
    <div class="bg-blue-500 shadow-xl rounded-r-xl fixed bottom-0 relative h-screen z-10 w-full content-center">

        <a href="/" class="flex items-start py-5 w-10/12 mx-auto">
            <img src="{{ asset('/images/Uztelecom_Logo.png') }}" alt="">
        </a>
        <div class="content-center md:content-start text-left justify-between">
            <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                {{menu('site', 'site.dashboard.menu')}}
            </ul>
        </div>
    </div>

</nav>

<!-- component -->
{{--<nav class=" rounded-md w-72 h-screen flex-col justify-between">--}}
{{--    <div class=" bg-white h-full">--}}
{{--        <div class="flex  justify-center py-10 shadow-sm pr-4">--}}
{{--            <img src="{{ asset('/images/Uztelecom_Logo.png') }}" alt=""--}}
{{--            class="w-48">--}}
{{--        </div>--}}
{{--        <div class="pl-10">--}}
{{--            <ul class="space-y-8 pt-10">--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Dashboard</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M13 10V3L4 14h7v7l9-11h-7z" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Activity</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Library</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Security</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Schedules</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Payouts</a>--}}
{{--                </li>--}}
{{--                <li class="flex space-x-4 items-center hover:text-indigo-600 cursor-pointer">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"--}}
{{--                         stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                              d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />--}}
{{--                    </svg>--}}
{{--                    <a href="">Settings</a>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="bg-white flex items-center space-x-4 pl-10 pb-10 hover:text-indigo-600 cursor-pointer">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />--}}
{{--        </svg>--}}
{{--        <a href="/loguot">Logout</a>--}}
{{--    </div>--}}
{{--</nav>--}}
