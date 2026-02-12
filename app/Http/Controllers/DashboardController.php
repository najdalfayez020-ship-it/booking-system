<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Carbon\Carbon;



class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {

        $appointments = Appointment::with('service')
            ->latest('appointment_date')
            ->take(5)
            ->get();

        $totalAppointments     = Appointment::count();
        $bookedAppointments    = Appointment::where('status', 'Booked')->count();
        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count();
        $servicesCount         = Service::count();

        // Chart data (admin only)
        $appointmentsPerDay = Appointment::selectRaw('appointment_date, count(*) as total')
            ->groupBy('appointment_date')
            ->orderBy('appointment_date')
            ->get();

        $chartLabels = $appointmentsPerDay->pluck('appointment_date');
        $chartData   = $appointmentsPerDay->pluck('total');

    } else {

        $appointments = Appointment::with('service')
            ->where('user_id', $user->id)
            ->latest('appointment_date')
            ->take(5)
            ->get();

        $totalAppointments = Appointment::where('user_id', $user->id)->count();

        $bookedAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'Booked')
            ->count();

        $completedAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->count();

        $cancelledAppointments = Appointment::where('user_id', $user->id)
            ->where('status', 'Cancelled')
            ->count();

        $servicesCount = Service::count();

        // Important: define empty chart variables for users
        $chartLabels = [];
        $chartData = [];
    }

    return view('dashboard', compact(
        'appointments',
        'totalAppointments',
        'bookedAppointments',
        'completedAppointments',
        'cancelledAppointments',
        'servicesCount',
        'chartLabels',
        'chartData'
    ));
}


}