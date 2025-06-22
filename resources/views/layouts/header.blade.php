<header class="bg-white shadow p-4 flex justify-between items-center">
  <div>
    <h1 class="text-xl font-semibold">@yield('title-section')</h1>
  </div>

    <div>
        <form method="POST" action="{{ route('auth.logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 bg-gray-300 rounded-lg text-gray-700">Logout</button>
        </form>
    </div>
</header>
