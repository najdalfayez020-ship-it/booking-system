<!-- resources/views/layouts/app.blade.php (or your main layout) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Appointments - Luxe Beauty' }}</title>

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-200">
<x-flash-message />

<x-app-layout>
    <x-slot name="title">Appointments – Luxe Beauty</x-slot>
    <div class="max-w-3xl mx-auto px-2">
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-6xl w-full px-6">
                <h2 class="text-xl font-semibold text-white mb-8 text-center mt-20">
                    Book Appointment
                </h2>

                {{-- Services --}}
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    <label class="block text-sm text-gray-500 mb-4 text-center">
                        Choose Service
                    </label>

                    @foreach($services->chunk(6) as $chunk)
                        <div class="flex flex-wrap justify-center gap-x-6 gap-y-8 mb-6">
                            @foreach($chunk as $service)
                                <label class="cursor-pointer w-[220px] h-[250px]">
                                    <input type="radio" name="service_id" value="{{ $service->id }}" class="hidden peer">
                                    
                                    <div class="rounded-2xl overflow-hidden transition duration-300 transform
                                        flex flex-col items-center h-full
                                        hover:shadow-lg
                                        peer-checked:ring-4 peer-checked:ring-pink-500
                                        peer-checked:shadow-xl
                                        peer-checked:bg-pink-50
                                        peer-checked:scale-105">

                                        <div class="w-32 h-32 flex items-center justify-center bg-gray-50 p-2 rounded">
                                            <img src="{{ asset('images/' . $service->image) }}" 
                                                class="w-full h-full object-cover rounded"
                                                alt="{{ $service->name }}">
                                        </div>

                                        <!-- Content -->
                                        <div class="p-3 text-center flex-1 flex flex-col justify-between">
                                            <h3 class="text-sm font-semibold text-white">
                                                {{ $service->name }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $service->duration }} min
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endforeach

                    <!-- Show Selected Service -->
                    <p id="selectedService" class="text-center mt-4 text-pink-500 font-semibold"></p>

                    <!-- Date & Time -->
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-white mb-1">Date</label>
                            <input type="date" name="appointment_date" min="{{ now()->toDateString() }}" 
                                   class="w-full border-b border-gray-800 focus:border-pink-500 focus:ring-0 text-gray-800">
                        </div>
                        <div>
                            <label class="block text-sm text-white mb-1">Time</label>
                            <select name="appointment_time" class="w-full border-b border-gray-300 focus:border-pink-500 focus:ring-0 text-gray-800">
                                @foreach($timeSlots as $time)
                                    <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                            @error('appointment_time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-6 text-center mb-20">
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition ">
                            <span class="text-2xl font-bold mt-2">Book</span>
                        </button>
                    </div>
                </form>

                <script>
                    // Show the chosen service name dynamically
                    const radios = document.querySelectorAll('input[name="service_id"]');
                    const selectedService = document.getElementById('selectedService');

                    radios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            const serviceName = this.closest('label').querySelector('h3').textContent;
                            selectedService.textContent = `Selected Service: ${serviceName}`;
                        });
                    });
                </script>
            </div>  <!-- Close max-w-6xl div -->
        </div>  <!-- Close min-h-screen div -->
    </div>  <!-- Close max-w-3xl div -->

    <!-- Footer (Now Outside Constrained Divs for Full Width) -->
    <footer class="bg-gray-900 text-gray-200 mt-12 w-full">
        <div class="w-full bg-gray-800">
            <div class="px-6 py-10 grid gap-16 md:grid-cols-2">
                <!-- Left: Logo + Salon Info + Contact -->
                <div class="flex flex-col space-y-6 mt-4">
                    <!-- Logo & Salon Info -->
                    <div class="flex flex-col items-start">
                        <img src="{{ asset('images/logo.png') }}" alt="Luxe Beauty Logo" style="width: 100px;" class="mb-3">
                        <h3 class="text-xl font-bold">Luxe Beauty</h3>
                        <p class="text-sm mt-1">Luxe Beauty: Appointment booking & more</p>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Contact Us</h4>
                        <ul class="space-y-2 text-sm mb-4">
                            <li><span class="font-medium">Phone:</span> +962 7X XXX XXXX</li>
                            <li><span class="font-medium">Location:</span> Amman, Jordan</li>
                            <li><span class="font-medium">Email:</span> info@luxebeauty.com</li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Social Media + Quick Links -->
                <div class="flex flex-col md:flex-row justify-between gap-3">
                    <!-- Quick Links / Projects -->
                    <div>
                        <h4 class="text-lg font-semibold mb-3 mt-4">Quick Links</h4>
                        <ul class="space-y-2 text-sm mt-4">
                            <li><a href="{{ route('appointments.create') }}" class="hover:text-pink-500">Book Appointment</a></li>
                            <li><a href="{{ route('services.index') }}" class="hover:text-pink-500">Our Services</a></li>
                            <li><a href="{{ route('dashboard') }}" class="hover:text-pink-500">Dashboard</a></li>
                        </ul>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                        <div class="flex space-x-8 mb-4">
                            <a href="https://facebook.com" target="_blank" class="hover:text-pink-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12a10 10 0 10-11 9.95V14h-3v-2h3v-1.5C11 8.42 12.42 7 14.5 7H17v2h-2c-.55 0-1 .45-1 1V12h3l-1 2h-2v7.95A10 10 0 0022 12z"/>
                                </svg>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="hover:text-pink-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm0 2h10c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3zm5 2a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-2a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/>
                                </svg>
                            </a>
                            <a href="https://twitter.com" target="_blank" class="hover:text-pink-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 5.92a8.59 8.59 0 01-2.357.646 4.143 4.143 0 001.82-2.288 8.307 8.307 0 01-2.605.986 4.13 4.13 0 00-7.045 3.762A11.707 11.707 0 013 4.911a4.126 4.126 0 001.276 5.513 4.073 4.073 0 01-1.872-.518v.052a4.127 4.127 0 003.313 4.046 4.14 4.14 0 01-1.867.071 4.128 4.128 0 003.85 2.865 8.276 8.276 0 01-5.125 1.767A8.553 8.553 0 012 19.54a11.693 11.693 0 006.29 1.84c7.547 0 11.675-6.155 11.675-11.5 0-.175-.004-.35-.012-.524A8.18 8.18 0 0022 5.92z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-6 mb-4 pt-4 text-center text-sm text-gray-500">
    &copy; {{ date('Y') }} Luxe Beauty. Developed by Najd Alfayez.
</div>
    </footer>
</x-app-layout>

</body>
</html>