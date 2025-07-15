<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title') PT. Kidora Mandiri </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.svg') }}">
  @vite('resources/css/app.css')
  {{-- @vite('resources/js/app.js') --}}
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>


</head>
<body class="bg-gray-50 flex">
  @include('layouts.helper')
  @include('layouts.navigation')

  <div class="flex-1 flex flex-col">

    @include('layouts.header')

    <main class="p-6 overflow-y-auto">
      @yield('content')
    </main>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const openMenuBtn = document.getElementById('open-menu');
            const navigation = document.getElementById('navigation');
            const closeMenuBtn = document.getElementById('close-menu');

            openMenuBtn.addEventListener('click', function () {
                navigation.classList.remove('hidden');
                setTimeout(() => {
                    navigation.classList.remove('-translate-x-full');
                    navigation.classList.add('translate-x-0');
                }, 10);
            });

            closeMenuBtn.addEventListener('click', function () {
                navigation.classList.remove('translate-x-0');
                navigation.classList.add('-translate-x-full');

                setTimeout(() => {
                    navigation.classList.add('hidden');
                }, 300);
            });
        });
    </script>
    <script>
  document.addEventListener('alpine:init', () => {
    Alpine.store('menu', {
      open: false
    });
  });
</script>





</body>
</html>
