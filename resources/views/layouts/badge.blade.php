<div 
  x-data="{ show: true }" 
  x-init="setTimeout(() => show = false, 3000)" 
  x-show="show"
  x-transition
  class="fixed top-4 right-4 z-50 space-y-4 w-80">
  
  @if(session('success'))
      <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg shadow p-4">
          <strong class="block text-sm font-medium">Success</strong>
          <p class="text-sm">{{ session('success') }}</p>
      </div>
  @end
  @if(session('error'))
      <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg shadow p-4">
          <strong class="block text-sm font-medium">Error</strong>
          <p class="text-sm">{{ session('failed') }}</p>
      </div>
  @endif
</div>