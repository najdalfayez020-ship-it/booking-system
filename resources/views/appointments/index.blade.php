<x-flash-message />
<x-app-layout>
            <x-slot name="title">Appointments – Luxe Beauty</x-slot>
    <div class="min-h-screen flex flex-col"> 

<div class="flex-1 max-w-6xl mx-auto mt-10"> 

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Appointments
            </h2>

            <a href="{{ route('appointments.create') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                + Book Appointment
            </a>
        </div>

        
<form method="GET" action="{{ route('appointments.index') }}"
      class="flex flex-wrap gap-4 mb-6">

    {{-- Date --}}
    <input type="date" name="date"
           value="{{ request('date') }}"
           class="border rounded-lg px-4 py-2">

    {{-- Status --}}
    <select name="status"
            class="border rounded-lg px-4 py-2">
        <option value="">All Status</option>
        <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>Booked</option>
        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>

    <button
        class="bg-pink-600 text-white px-6 py-2 rounded-lg">
        Filter
    </button>
</form>
        {{-- Table --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-16">
    <table class="w-full text-left">
               <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
    <tr>
        <th class="px-6 py-3">Customer</th>
        <th class="px-6 py-3">Service</th>
        <th class="px-6 py-3">Date</th>
        <th class="px-6 py-3">Time</th>
        <th class="px-6 py-3">Duration</th>
        <th class="px-6 py-3 text-center">Status</th>
        <th class="px-6 py-3 text-center">Actions</th>
    </tr>
</thead>

                <tbody class="divide-y">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-800">
                                        {{ $appointment->user->name }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        {{ $appointment->user->phone }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium">
                                {{ $appointment->service->name }}
                                
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $appointment->service->duration }} min
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-sm
                                @if($appointment->status == 'Booked') bg-green-100 text-green-700
                                @elseif($appointment->status == 'Completed') bg-blue-100 text-blue-700
                                @else bg-gray-200 text-gray-600
                                @endif">
                                    {{ $appointment->status }}
                                </span>
                            </td>
<td class="px-6 py-4 text-center space-x-2">

    @if($appointment->status === 'Booked')

        <form action="{{ route('appointments.complete', $appointment) }}"
              method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button class="px-3 py-1 bg-blue-600 text-gray rounded text-sm hover:bg-blue-500">
                Complete
            </button>
        </form>

        <form action="{{ route('appointments.cancel', $appointment) }}"
              method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button class="text-red-500 hover:underline text-sm"
                    onclick="return confirm('Cancel this appointment?')">
                Cancel
            </button>
        </form>

    @elseif($appointment->status === 'Completed')

        <span class="text-gray-400 text-sm">✔ Done</span>

    @elseif($appointment->status === 'Cancelled')

        <span class="text-red-500 text-sm">❌ Cancelled</span>

    @endif

</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No appointments yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
    {{ $appointments->links() }}
</div>
        </div>
</div>
<!-- Footer -->
<footer class="bg-gray-900 text-gray-200 w-full mt-auto">
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

