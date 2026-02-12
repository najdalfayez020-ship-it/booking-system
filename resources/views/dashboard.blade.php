<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Appointments - Luxe Beauty' }}</title>

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-500">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-flash-message />
<x-app-layout>
            <x-slot name="title">Dashboard – Luxe Beauty</x-slot>
            

@if(auth()->user()->role === 'admin')
<div class="max-w-3xl mx-auto px-2">
    <!-- Bell Icon -->
    <button id="notificationButton" class="relative focus:outline-none">
        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>

        <!-- Unread count badge -->
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <!-- Dropdown: appears directly below bell -->
    <div id="notificationDropdown" class="hidden absolute left-1/2 transform -translate-x-1/2 mt-2 w-80 bg-white rounded-xl shadow-lg z-50">
        <ul class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <li class="px-4 py-3 hover:bg-gray-50 cursor-pointer">
                    <p class="font-bold text-gray-800">Reminder</p>
                    <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </li>
            @empty
                <li class="px-4 py-3 text-gray-500">No new notifications.</li>
            @endforelse
        </ul>
    </div>
</div>
@endif


<script>
    const btn = document.getElementById('notificationButton');
    const dropdown = document.getElementById('notificationDropdown');

    btn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    window.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Mark notifications as read when opened
    btn.addEventListener('click', async () => {
        if (!dropdown.classList.contains('hidden')) {
            await fetch('{{ route('notifications.markRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            });
        }
    });
</script>


<div class="min-h-screen flex items-center justify-center pb-12">
    @if(auth()->user()->role === 'admin')
    {{-- ADMIN DASHBOARD --}}
    @include('dashboard.admin')

@else
    {{-- USER DASHBOARD --}}
    @include('dashboard.user')
@endif
</div>

<div class="bg-white p-6 rounded-xl shadow mt-8 flex justify-center">
    <div style="width: 400px;">
        <canvas id="appointmentsChart"></canvas>
    </div>
</div>


<script>
const ctx = document.getElementById('appointmentsChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Appointments Per Day',
            data: @json($chartData),
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});
</script>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-200 mt-12 w-full">
    <div class="w-full bg-gray-800">
<div class="max-w-7xl mx-auto px-6 py-10 grid gap-16 md:grid-cols-2">

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