<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>App</title>
    <!-- tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            scrollbar-width: none;
        }

        .content-transition {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Fix untuk chart container */
        .chart-container {
            width: 100%;
            min-width: 0;
            overflow-x: auto;
        }

        canvas {
            max-width: 100%;
            height: auto !important;
        }

        /* Scroll yang lebih baik di mobile */
        .overflow-y-auto {
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>

<body class="bg-[#f9fafb] font-[Poppins] h-screen overflow-hidden scrollbar-none">
    <div class="flex h-full relative">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-white border-r z-50 transition-all duration-300 
        overflow-y-auto -translate-x-full md:translate-x-0 shadow-lg md:shadow-none border border-gray-400">
            @include('components.sidebar-admin')
        </aside>

        <!-- OVERLAY (mobile only) -->
        <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300">
        </div>

        <!-- CONTENT WRAPPER -->
        <div id="mainContent" class="flex-1 flex flex-col w-full min-w-0 content-transition md:ml-72">
            @include('components.navbar')

            <main class="flex-1 overflow-y-auto p-4 md:p-6">
                <div class="max-w-full">
                    @yield('content')
                </div>
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/modals.js') }}"></script>
</body>

</html>