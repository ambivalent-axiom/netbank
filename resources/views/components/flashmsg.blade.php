@if(session('message'))
    <div class="text-sm text-yellow-600">
        {{ session('message') }}
    </div>
@endif
@if(session('error'))
    <div class="text-sm text-red-600">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="text-sm text-green-600">
        {{ session('success') }}
    </div>
@endif
