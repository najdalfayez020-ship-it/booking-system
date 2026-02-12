{{-- My Appointments Section --}}
<div class="w-full flex flex-col gap-4">

    {{-- Section Title --}}
  <div class="text-center mb-6">
     <h2 class="text-6xl font-bold text-white">
        My Appointments
    </h2>
    <p class="text-lg text-gray-300 mt-2">
        Your latest scheduled visits
    </p>
</div>

  <div class="w-full flex justify-center mb-4">
    <a href="{{ route('appointments.create') }}"
       class="bg-white text-pink-600 px-6 py-3 rounded-lg shadow-md hover:bg-gray-100 transition">
       Book Appointment
    </a>
</div>


    {{-- Appointments Table --}}
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">Service</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Time</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition">
                        {{-- Service --}}
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $appointment->service->name }}
                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                        </td>

                        {{-- Time --}}
                        <td class="px-6 py-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($appointment->status === 'Booked')
                                    bg-green-100 text-green-700
                                @elseif($appointment->status === 'Completed')
                                    bg-blue-100 text-blue-700
                                @elseif($appointment->status === 'Cancelled')
                                    bg-red-100 text-red-700
                                @else
                                    bg-gray-100 text-gray-600
                                @endif">
                                {{ $appointment->status }}
                            </span>
                        </td>

                        {{-- Actions (User only: Cancel) --}}
                        <td class="px-6 py-4 text-center">
                            @if(
                                $appointment->status === 'Booked' &&
                                \Carbon\Carbon::parse(
                                    $appointment->appointment_date . ' ' . $appointment->appointment_time
                                )->isFuture()
                            )
                                <form action="{{ route('appointments.cancel', $appointment) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Cancel
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            No appointments yet 🌸
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</div>

