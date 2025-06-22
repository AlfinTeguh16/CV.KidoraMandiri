<nav x-data="{ open: false }" class="bg-white shadow absolute md:static w-64 lg:min-w-64 transform md:translate-x-0 transition-transform">
  <div class="p-6 flex items-center justify-between md:hidden">
    <h1 class="text-xl font-bold text-blue-600">PT. Kidora Mandiri</h1>
    <button @click="open = !open" class="p-2 rounded-md focus:outline-none">
      <ph-icon name="list" size="24" />
    </button>
  </div>

  <div :class="open ? 'block' : 'hidden'" class="md:block px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">PT. Kidora Mandiri</h2>
    <ul class="space-y-2">
        <x-nav-link href="{{ route('dashboard.index') }}" :active="request()->routeIs('dashboard.index')">
        <ph-icon name="house" class="mr-2" /> Dashboard
        </x-nav-link>
        <x-nav-link href="{{ route('turnover.index') }}" :active="request()->routeIs('turnover.index')">
        <ph-icon name="chart-bar-horizontal" class="mr-2" /> Turnover
        </x-nav-link>
        <x-nav-link href="{{ route('insiden.index') }}" :active="request()->routeIs('insiden.index')">
        <ph-icon name="warning" class="mr-2" /> Insiden
        </x-nav-link>
        <x-nav-link href="{{ route('promosi.index') }}" :active="request()->routeIs('promosi.index')">
        <ph-icon name="trending-up" class="mr-2" /> Promosi
        </x-nav-link>
        <x-nav-link href="{{ route('pelatihan.index') }}" :active="request()->routeIs('pelatihan.index')">
        <ph-icon name="book" class="mr-2" /> Pelatihan
        </x-nav-link>
    </ul>
   </div>

</nav>
