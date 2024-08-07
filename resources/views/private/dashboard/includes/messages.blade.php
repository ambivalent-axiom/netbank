<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
    <div class="p-6 text-gray-900">
        <div class="m-4 text-4xl">
            <h1>
                {{ Auth::user()->first_name }}'s Notifications
            </h1>
        </div>
        <div class="">
            @foreach($userMessages as $message)
                <div class="rounded-lg bg-yellow-400 mb-2">
                    <div class="flex justify-between">
                        <div class="flex font-semibold">
                            <div class="m-4">{{ $message->created_at }}</div>
                            <div class="m-4">From: {{ $message->from }}</div>
                        </div>

                        <div class="m-2">
                            <form id="message_id" method="POST" action="">
                                @csrf
                                @method('PATCH')
                                <x-text-input
                                    id="message_id"
                                    name="message_id"
                                    value="{{ $message->id }}"
                                    hidden
                                ></x-text-input>
                                <x-secondary-button class="button" type="submit">Confirm</x-secondary-button>
                                <x-input-error :messages="$errors->get('message_id')" class="mt-2" />
                            </form>
                        </div>
                    </div>
                    <div class="mb-2 p-3
                        @if($message->type == 'notification')
                            bg-yellow-200
                        @elseif($message->type == 'warning')
                            bg-red-200
                        @elseif($message->type == 'confirmation')
                            bg-green-200
                        @endif
                        rounded-b-lg">
                        {{ $message->message }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

