<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>@yield('title') PT. Kidora Mandiri </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('assets/img/favicon.svg') }}">
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')

</head>
<body class="min-h-screen bg-gray-50 flex">
  @include('layouts.helper')
  @include('layouts.navigation')

  <div class="flex-1 flex flex-col">

    @include('layouts.header')

    <main class="p-6 h-screen overflow-y-auto">
      @yield('content')
    </main>
</div>
@yield('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script> --}}


</body>
</html>
