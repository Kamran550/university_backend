<button 
    wire:click.prevent="logout"
    class="w-full flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-600 hover:text-white transition text-left"
>
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
    </svg>
    <span>Logout</span>
</button>

