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
<x-flash-message />
<x-app-layout>
            <x-slot name="title">Service – Luxe Beauty</x-slot>
<div class="max-w-5xl mx-auto mt-10">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Services
        </h2>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('services.create') }}"
               class="bg-pink-600 text-white px-4 py-2 rounded-lg">
                + Create Service
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                <tr>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Duration</th>
                    <th class="px-6 py-3">Price</th>
                    @if(auth()->user()->role === 'admin')
                        <th class="px-6 py-3 text-center">Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($services as $service)

                    {{-- VIEW MODE --}}
                    <tr id="view-row-{{ $service->id }}" class="hover:bg-gray-50">
<td class="px-6 py-4">
    @if($service->image)
        <img src="{{ asset('images/' . $service->image) }}"
             class="w-20 h-20 object-contain bg-gray-50 p-2 rounded">
    @else
        <span class="text-gray-400 text-sm">No image</span>
    @endif
</td>


                        <td class="px-6 py-4 font-medium">
                            {{ $service->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $service->description ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $service->duration }} min
                        </td>

                        <td class="px-6 py-4">
                            {{ $service->price }} JOD
                        </td>

                        @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4 text-center space-x-3">
                                <button onclick="toggleEdit({{ $service->id }})"
                                        class="text-blue-600 hover:underline">
                                    Edit
                                </button>

                                <form action="{{ route('services.destroy', $service->id) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Delete this service?')"
                                            class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>

                    {{-- EDIT MODE --}}
                    <tr id="edit-row-{{ $service->id }}" class="hidden bg-gray-50">
    <form action="{{ route('services.update', $service->id) }}"
          method="POST"
          enctype="multipart/form-data"> {{-- important --}}
        @csrf
        @method('PUT')

        <td class="px-6 py-4">
            @if($service->image)
                <img src="{{ asset('images/' . $service->image) }}"
                     class="w-20 h-20 object-contain bg-gray-50 p-2 rounded mb-2">
            @else
                <span class="text-gray-400 text-sm">No image</span>
            @endif

            <input type="file"
                   name="image"
                   class="w-full border-gray-300 rounded p-1 mt-1">
</td>

                            <td class="px-6 py-2">
                                <input type="text"
                                       name="name"
                                       value="{{ $service->name }}"
                                       class="w-full border-gray-300 rounded">
                            </td>

                            <td class="px-6 py-2">
                                <input type="text"
                                       name="description"
                                       value="{{ $service->description }}"
                                       class="w-full border-gray-300 rounded">
                            </td>

                            <td class="px-6 py-2">
                                <input type="number"
                                       name="duration"
                                       value="{{ $service->duration }}"
                                       class="w-20 border-gray-300 rounded">
                            </td>

                            <td class="px-6 py-2">
                                <input type="number"
                                       step="0.01"
                                       name="price"
                                       value="{{ $service->price }}"
                                       class="w-20 border-gray-300 rounded">
                            </td>

                            <td class="px-6 py-2 text-center space-x-2">
                                <button type="submit"
                                        class="text-green-600 hover:underline">
                                    Save
                                </button>

                                <button type="button"
                                        onclick="toggleEdit({{ $service->id }})"
                                        class="text-gray-600 hover:underline">
                                    Cancel
                                </button>
                            </td>
                        </form>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-6 text-center text-gray-500">
                            No services added yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



    <script>
        function toggleEdit(id) {
            document.getElementById('view-row-' + id).classList.toggle('hidden');
            document.getElementById('edit-row-' + id).classList.toggle('hidden');
        }
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

