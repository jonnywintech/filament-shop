<form wire:submit.prevent="logout">
    @csrf
    <button type="submit"
        class="flex d-inline w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
        Logout
    </button>
</form>
