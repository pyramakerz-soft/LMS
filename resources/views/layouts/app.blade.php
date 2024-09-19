<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-thin-rounded/css/uicons-thin-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-straight/css/uicons-bold-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-straight/css/uicons-regular-straight.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="grid grid-cols-12">
        <div id="sidebar" class="lg:col-span-3 bg-[#17253E] min-h-[100vh] h-full border-r-[1.33px] border-[#2E3545] lg:block absolute lg:static lg:z-auto z-20 transform translate-y-16 lg:translate-y-0">
            @yield('sidebar')
        </div>

        <div class="col-span-12 lg:col-span-9">
            <button id="burger" class="lg:hidden p-4 text-white z-30">
                <div class="cursor-pointer pt-5 pr-7"  (click)="OpenMenu()">
                    <div class="h-1 w-7 md:h-[6px] md:w-10 mb-1 bg-[#454950] rounded"></div>
                    <div class="h-1 w-7 md:h-[6px] md:w-10 mb-1 bg-[#454950] rounded"></div>
                    <div class="h-1 w-7 md:h-[6px] md:w-10 bg-[#454950] rounded"></div>
                </div>
            </button>

            @yield('content')
        </div>
    </div>

    @yield("login")

    <script>
        document.getElementById('burger').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>

</html>