<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Notifications\AppointmentReminder;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Setting;



class AppointmentController extends Controller
{
       public function index(Request $request)
{
    $query = Appointment::with(['service', 'user']);

    // إذا المستخدم عادي → فقط مواعيده
    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    // فلترة حسب التاريخ
    if ($request->filled('date')) {
        $query->where('appointment_date', $request->date);
    }

    // فلترة حسب الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $appointments = $query
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->paginate(10);

    return view('appointments.index', compact('appointments'));
}
    
    public function complete(Appointment $appointment){
        $appointment->update(['status' => 'Completed']);
        return back()->with('success', 'Appointment marked as completed ✓');

        $appointments = Appointment::where('user_id', auth()->id())
    ->with('service')
    ->orderBy('appointment_date')
    ->orderBy('appointment_time')
    ->get();

    }
    public function cancel(Appointment $appointment)
    {
        // تأكيد أن المستخدم يملك هذا الحجز
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        // ما نلغي إلا المواعيد المحجوزة
        if ($appointment->status !== 'Booked') {
            return back();
        }

        $appointment->update([
            'status' => 'Cancelled'
        ]);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
    public function create()
    {
          $services = Service::all();

    $settings = Setting::first();

    $timeSlots = $this->generateTimeSlots(
        $settings->opening_time,
        $settings->closing_time,
        30
    );

    $bookedTimes = Appointment::pluck('appointment_time')->toArray();

    return view('appointments.create',
        compact('services', 'timeSlots', 'bookedTimes')
    );
    }

public function store(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required'
    ]);

    // Fetch service
    $service = Service::findOrFail($request->service_id);

    // Fetch opening and closing hours
    $settings = \App\Models\Setting::first(); // ✅ make sure this is defined
    $opening = Carbon::parse($settings->opening_time);
    $closing = Carbon::parse($settings->closing_time);

    // Parse start and end time of the appointment
    $startTime = Carbon::parse($request->appointment_time);
    $endTime = $startTime->copy()->addMinutes($service->duration);

    // Check if appointment fits within opening hours
    if ($startTime->lt($opening) || $endTime->gt($closing)) {
        return back()->withErrors([
            'appointment_time' => "Appointments are only available between {$opening->format('H:i')} and {$closing->format('H:i')}."
        ])->withInput();
    }

    // Check overlapping with other appointments
    $appointments = Appointment::where('appointment_date', $request->appointment_date)->get();
    foreach ($appointments as $appointment) {
        $existingService = Service::find($appointment->service_id);
        $existingStart = Carbon::parse($appointment->appointment_time);
        $existingEnd = $existingStart->copy()->addMinutes($existingService->duration);

        if ($startTime < $existingEnd && $endTime > $existingStart) {
            return back()->withErrors([
                'appointment_time' => 'This time overlaps with another appointment.'
            ])->withInput();
        }
    }

    // Create appointment
    $appointment = Appointment::create([
    'user_id' => auth()->id(),
    'service_id' => $service->id,
    'appointment_date' => $request->appointment_date,
    'appointment_time' => $request->appointment_time, 
    'status' => 'Booked',
]);

    // Send notification to admins
    $admins = User::where('role', 'admin')->get();
    Notification::send($admins, new AppointmentReminder($appointment));

    // Redirect based on role
    if (auth()->user()->role === 'admin') {
        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    return redirect()->route('dashboard')
        ->with('success', 'Appointment booked successfully 💅');
}
    
    private function generateTimeSlots($start, $end, $interval = 30)
    {
        $slots = [];

        $startTime = Carbon::parse($start);
$endTime = Carbon::parse($end);


        while ($startTime < $endTime) {
    $slots[] = $startTime->format('g:i A');
    $startTime->addMinutes($interval);
}


        return $slots;
    }
    public function myAppointments()
    {
        $appointments = Appointment::with('service')
            ->where('user_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('appointments.my_appointments', compact('appointments'));
    }
}




