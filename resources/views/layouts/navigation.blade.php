{{-- <nav x-data="{ open: false }" class="bg-white shadow absolute md:static w-64 lg:min-w-64 transform md:translate-x-0 transition-transform">
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

</nav> --}}

<nav
  x-data
  id="navigation"
  class="bg-white shadow md:static lg:w-64 lg:min-w-64 transform transition-transform duration-300 ease-in-out hidden md:hidden lg:block fixed top-0 left-0 w-full h-[100%] lg:h-auto z-50"
  :class="{ 'translate-x-0': $store.menu.open, '-translate-x-full': !$store.menu.open, 'md:translate-x-0': true }"
>
  <div
    class="md:block px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-2xl font-bold text-blue-600">PT. Kidora Mandiri</h2>
      <button
        id="close-menu"
        @click="$store.menu.open = false"
        class="lg:hidden text-white active:bg-gray-500 hover:bg-gray-500 px-2 py-1 rounded-lg bg-gray-400"
      >
        <i class="ph-bold ph-x"></i>
      </button>
    </div>

    <!-- Navigation -->
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




