<div class="mb-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between">
        <div class="m-6 text-gray-900">
            {{ __("Balance Total") }}
        </div>
    </div>
    <div class="flex font-bold flex-col ml-3 mr-3 mb-3">
        <div class="flex flex-row bg-transparent w-full border-collapse mb-2 text-xs">
            <div class="flex items-center rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                <p class="text-xl">
                    {{ __('EUR') }}
                </p>
            </div>
            <div class="flex rounded-r-lg bg-yellow-200 px-3 py-2 w-full justify-end">
                <p class="text-3xl">
                    {{ number_format($eurAccounts->sum('balance')/100, 2) }}
                </p>
            </div>
        </div>
        <div class="flex flex-row bg-transparent w-full border-collapse mb-2 text-xs">
            <div class="flex items-center rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                <p class="text-xl">
                    {{ __('USD') }}
                </p>
            </div>
            <div class="flex rounded-r-lg bg-yellow-200 px-3 py-2 w-full justify-end">
                <p class="text-3xl">
                    {{ number_format($usdAccounts->sum('balance')/100, 2) }}
                </p>
            </div>
        </div>
    </div>
</div>
