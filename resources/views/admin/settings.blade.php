<x-app-layout>
    <x-slot name="title">Hours setting – Luxe Beauty</x-slot>

    <div class="min-h-screen flex items-center justify-center">

        <div class="max-w-xl w-full p-8">

            <h2 class="text-2xl font-bold mb-6 text-center text-white">
                Business Hours Settings
            </h2>

            @if(session('success'))
                <div class="bg-green-100 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm text-white font-medium mb-2">
                        Opening Time
                    </label>

                    <input type="time"
                           name="opening_time"
                           value="{{ $setting->opening_time }}"
                           class="w-full border rounded-lg p-3">
                </div>

                <div class="mb-6">
                    <label class="block text-sm text-white font-medium mb-2">
                        Closing Time
                    </label>

                    <input type="time"
                           name="closing_time"
                           value="{{ $setting->closing_time }}"
                           class="w-full border rounded-lg p-3">
                </div>
<button type="submit"
        class="w-full bg-gray-800 text-white px-6 py-3 rounded-lg hover:bg-black transition mb-3">
    Update Hours
</button>
<a href="{{ route('dashboard') }}"
   class="w-full block text-center bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
    Go to Dashboard
</a>



            </form>

        </div>

    </div>

</x-app-layout>  