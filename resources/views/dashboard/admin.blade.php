<x-flash-message />


<div class="min-h-screen flex flex-col items-center justify-center pb-12">
    <div class="max-w-6xl w-full mx-auto mt-10 space-y-10">
        <div class="text-center"> 
            <a href="{{ route('admin.settings.edit') }}"
               class="inline-block w-auto bg-white text-pink-600 rounded-lg hover:bg-gray-100 transition
                      px-6 py-3 mx-4 mb-12">
                Manage Business Hours
            </a>
        </div>



        {{-- Welcome --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center ">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Welcome to Luxe Beauty Appointment
            </h1>
            <p class="text-gray-600">
                Manage services & appointments with ease
            </p>
        </div>

        {{-- Action Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('appointments.create') }}"
               class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="text-4xl mb-3">💅</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                    Book Appointment
                </h3>
                <p class="text-gray-500 text-sm">
                    Schedule a new client visit
                </p>
            </a>

            <a href="{{ route('appointments.index') }}"
               class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="text-4xl mb-3">📅</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                    Appointments
                </h3>
                <p class="text-gray-500 text-sm">
                    View all booked appointments
                </p>
            </a>

            <a href="{{ route('services.index') }}"
               class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center">
                <div class="text-4xl mb-3">✨</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                    Services
                </h3>
                <p class="text-gray-500 text-sm">
                    Manage salon services
                </p>
            </a>

        </div>

        {{-- SPACE BETWEEN SECTIONS --}}
        <div class="h-8"></div>

        {{-- Stats Cards --}}
<div class="flex flex-wrap justify-between gap-4">

    {{-- Total --}}
    <div class="w-48 h-48 bg-white shadow-md rounded-lg flex flex-col items-center justify-center">
        <p class="text-sm text-gray-500">Total Appointments</p>
        <p class="text-4xl font-bold text-gray-800 mt-2">
            {{ $totalAppointments }}
        </p>
    </div>

    {{-- Booked --}}
    <div class="w-48 h-48 bg-white shadow-md rounded-lg flex flex-col items-center justify-center">
        <p class="text-sm text-gray-500">Booked</p>
        <p class="text-4xl font-bold text-green-600 mt-2">
            {{ $bookedAppointments }}
        </p>
    </div>

    {{-- Completed --}}
    <div class="w-48 h-48 bg-white shadow-md rounded-lg flex flex-col items-center justify-center">
        <p class="text-sm text-gray-500">Completed</p>
        <p class="text-4xl font-bold text-blue-600 mt-2">
            {{ $completedAppointments }}
        </p>
    </div>

    {{-- Cancelled --}}
    <div class="w-48 h-48 bg-white shadow-md rounded-lg flex flex-col items-center justify-center">
        <p class="text-sm text-gray-500">Cancelled</p>
        <p class="text-4xl font-bold text-red-600 mt-2">
            {{ $cancelledAppointments }}
        </p>
    </div>

    {{-- Services --}}
    <div class="w-48 h-48 bg-white shadow-md rounded-lg flex flex-col items-center justify-center">
        <p class="text-sm text-gray-500">Services</p>
        <p class="text-4xl font-bold text-pink-600 mt-2">
            {{ $servicesCount }}
        </p>
    </div>

</div>


    </div>
    
</div>

