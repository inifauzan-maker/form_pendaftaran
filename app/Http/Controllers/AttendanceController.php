<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __invoke(Registration $registration): View
    {
        $wasUpdated = false;

        if ($registration->status !== Registration::STATUS_PRESENT) {
            $registration->markAsPresent();
            $registration->refresh();
            $wasUpdated = true;
        }

        return view('attendance.confirmation', [
            'registration' => $registration,
            'wasUpdated' => $wasUpdated,
        ]);
    }
}
