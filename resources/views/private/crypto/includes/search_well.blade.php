<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex flex-col m-4">
        <form method="POST" action="">
            @csrf
            <x-input-label for="search"></x-input-label>
            <div class="flex bg-transparent justify-between text-xs">
                <x-text-input class="w-24" id="search" name="search" placeholder="Search..."></x-text-input>
                <x-primary-button class="button mr-2" type="submit">Search</x-primary-button>
            </div>
        </form>
    </div>
</div>
