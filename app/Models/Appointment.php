<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Appointment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
        {
            return $this->belongsTo(Service::class);
        }
    public function updateStatusIfCompleted()
    {
        $appointmentEnd = \Carbon\Carbon::parse(
            $this->appointment_date . ' ' . $this->appointment_time
        )->addMinutes($this->service->duration);

        if (now()->greaterThan($appointmentEnd) && $this->status === 'Booked') {
            $this->update(['status' => 'Completed']);
        }
    }
}
