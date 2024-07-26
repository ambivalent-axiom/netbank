<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between">
        <div class="m-6 text-gray-900">
            {{ __("Contacts") }}
        </div>
        <div class="m-5">
            <a href="/contacts">
                <x-primary-button>Edit</x-primary-button>
            </a>
        </div>
    </div>
    <div class="flex flex-col ml-3 mr-3 mb-3">
        @foreach($contacts as $contact)
            <div class="flex flex-row w-full bg-transparent border-collapse mb-2 text-xs">
                <div class="rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                    {{ $contact->first_name }}
                </div>
                <div class="rounded-r-lg bg-yellow-200 px-3 py-2 w-full">
                    {{ $contact->email }}
                </div>
            </div>
        @endforeach
    </div>
</div>
