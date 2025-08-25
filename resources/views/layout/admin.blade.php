<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link href="{{ asset('assets/img/motekar-bg.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/994f229ca1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0; }
                100% { opacity: 1; }
            }

            .dot1 {
                animation: pulse 1s infinite;
            }

            .dot2 {
                animation: pulse 1s infinite;
                animation-delay: 0.2s;
            }

            .dot3 {
                animation: pulse 1s infinite;
                animation-delay: 0.4s;
            }
            </style>
</head>

<body>
    <header class="w-full h-16 bg-slate-900 text-white z-50 fixed top-0 flex items-center justify-between px-5">
        <i class="fa-solid fa-bars cursor-pointer" id="toggleButton"></i>
        <p class="sm:mr-20">{{ Auth::user()->name }}</p>
    </header>
    <div class="flex max-sm:mt-10 mt-16">
        <aside
            class="w-72 bg-[#1c212c] min-h-full h-screen flex flex-col items-center pt-5 pb-2 space-y-7 sticky top-0 transition-all max-sm:hidden max-sm:fixed z-40 max-sm:pt-20"
            id="sidebar">

            <!-- menu items -->
            <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm">

                <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Menu</div>

                <div
                    class="w-full flex items-center gap-x-1.5 group select-none {{ Request::route()->getName() == 'dashboard' ? 'group-active' : '' }}">
                    <div
                        class="w-1 rounded-xl h-8 bg-transparent transition-colors duration-200 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-[102%] group-hover:translate-y-0 {{ Request::route()->getName() == 'dashboard' ? 'translate-y-0' : 'translate-y-full' }}  bg-red-600 transition-all duration-300">
                        </div>
                    </div>
                    <a class=" {{ Request::route()->getName() == 'dashboard' ? 'text-white bg-white/10' : '' }}  group-hover:bg-white/10 w-full group-active:scale-95 self-stretch pl-2 rounded flex items-center space-x-2 transition-all duration-200 dark:group-hover:text-white dark:hover:text-white text-sm"
                        href="{{ route('dashboard') }}">
                        <svg class="h-5 w-5  group-hover:fill-red-600 dark:fill-gray-600  transition-colors duration-200 {{ Request::route()->getName() == 'dashboard' ? '!fill-red-500' : '' }}"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M5 22h14a2 2 0 0 0 2-2v-9a1 1 0 0 0-.29-.71l-8-8a1 1 0 0 0-1.41 0l-8 8A1 1 0 0 0 3 11v9a2 2 0 0 0 2 2zm5-2v-5h4v5zm-5-8.59 7-7 7 7V20h-3v-5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v5H5z">
                            </path>
                        </svg>


                        <span class="font-QuicksandMedium">Manage Content</span>
                    </a>
                </div>
                <div
                    class="w-full flex items-center gap-x-1.5 select-none group {{ Request::route()->getName() == 'gallery.index' ? 'group-active' : '' }}">
                    <div
                        class="w-1 rounded-xl h-8 bg-transparent transition-colors duration-200 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-[102%] group-hover:translate-y-0 {{ Request::route()->getName() == 'gallery.index' ? 'translate-y-0' : 'translate-y-full' }}  group-active:scale-50 group-hover:translate-y-0 bg-red-600 transition-all duration-300">
                        </div>
                    </div>
                    <a class="group-hover:bg-white/10 {{ Request::route()->getName() == 'gallery.index' ? 'bg-white/10 text-white' : '' }} w-full group-active:scale-95 self-stretch pl-2 rounded flex items-center space-x-2 transition-all duration-200 dark:group-hover:text-white dark:hover:text-white text-sm"
                        href="{{ route('gallery.index') }}">
                        <div
                            class="h-5 w-5 group-hover:text-red-600 dark:text-gray-600  transition-colors duration-200 {{ Request::route()->getName() == 'gallery.index' ? '!text-red-500' : '' }}">
                            <i class="fa-regular fa-image"></i>
                        </div>

                        <span class="font-QuicksandMedium">Gallery</span>
                    </a>
                </div>
                @if (Auth::user()->role == 0)
                    <div
                        class="w-full flex items-center gap-x-1.5 select-none group {{ Request::route()->getName() == 'rtrw' ? 'group-active' : '' }}">
                        <div
                            class="w-1 rounded-xl h-8 bg-transparent transition-colors duration-200 relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-[102%] group-hover:translate-y-0 {{ Request::route()->getName() == 'rtrw' ? 'translate-y-0' : 'translate-y-full' }}  group-active:scale-50 group-hover:translate-y-0 bg-red-600 transition-all duration-300">
                            </div>
                        </div>
                        <a class="group-hover:bg-white/10 {{ Request::route()->getName() == 'rtrw' ? 'bg-white/10 text-white' : '' }} w-full group-active:scale-95 self-stretch pl-2 rounded flex items-center space-x-2 transition-all duration-200 dark:group-hover:text-white dark:hover:text-white text-sm"
                            href="{{ route('rtrw') }}">
                            <div
                                class="h-5 w-5 group-hover:text-red-600 dark:text-gray-600  transition-colors duration-200 {{ Request::route()->getName() == 'rtrw' ? '!text-red-500' : '' }}">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>

                            <span class="font-QuicksandMedium">RT RW</span>
                        </a>
                    </div>
                @endif




            </div>

            <!-- menu items -->
            <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm">

                <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Akun</div>
                @if (Auth::user()->role == 0)
                    <div class="w-full flex items-center gap-x-1.5 group select-none">
                        <div
                            class="w-1 rounded-xl h-8 bg-transparent transition-colors duration-200 relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 w-full h-[102%] translate-y-full group-hover:translate-y-0 bg-red-600 transition-all duration-300">
                            </div>
                        </div>
                        <a class="group-hover:bg-white/10 w-full group-active:scale-95 self-stretch pl-2 rounded flex items-center space-x-2 transition-all duration-200 dark:group-hover:text-white dark:hover:text-white text-sm"
                            href="{{ route('akun.manage') }}">
                            <div
                                class="h-5 w-5 group-hover:text-red-600 dark:text-gray-600  transition-colors duration-200">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <span class="font-QuicksandMedium">Manage Akun</span>
                        </a>
                    </div>
                @endif



                <div class="w-full flex items-center gap-x-1.5 group select-none">
                    <div
                        class="w-1 rounded-xl h-8 bg-transparent transition-colors duration-200 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-full h-[102%] translate-y-full group-hover:translate-y-0 bg-red-600 transition-all duration-300">
                        </div>
                    </div>
                    <a class="group-hover:bg-white/10 w-full group-active:scale-95 self-stretch pl-2 rounded flex items-center space-x-2 transition-all duration-200 dark:group-hover:text-white dark:hover:text-white text-sm"
                        href="{{ route('logout') }}">
                        <svg class="h-5 w-5 group-hover:fill-red-600 dark:fill-gray-600  transition-colors duration-200"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M19 21H5C3.89543 21 3 20.1046 3 19V15H5V19H19V5H5V9H3V5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21ZM11 16V13H3V11H11V8L16 12L11 16Z">
                            </path>
                            <span class="font-QuicksandMedium">log out</span>
                        </svg>
                    </a>
                </div>
            </div>
        </aside>
        @yield('content')
    </div>
    <div id="loading" class="w-full h-full bg-black/40 flex flex-col justify-center items-center fixed z-[999] top-0 hidden">
        <svg aria-hidden="true" class="w-20 h-20 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
        <h1 class="text-white flex items-baseline gap-2 text-2xl font-semibold">
            Loading
            <div class="w-3 h-3 bg-white rounded-full dot1"></div>
            <div class="w-3 h-3 bg-white rounded-full dot2"></div>
            <div class="w-3 h-3 bg-white rounded-full dot3"></div>
        </h1>    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        toastr.options = {
            'progressBar': true,
            'closeButton': true,
            'timeOut': 10000
        }
        @if (Session::has('pesan'))
            toastr.success("{{ Session::get('pesan') }}");
        @elseif (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    @yield('script')
</body>

</html>
