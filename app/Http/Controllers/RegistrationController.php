<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Registration;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function create(): View
    {
        return view('registrations.create', [
            'studyLocations' => array_keys(config('registration.locations')),
            'programs' => config('registration.programs'),
        ]);
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $paths = $this->storePermissionLetter($request);

        $sequence = $this->nextSequenceNumber($data['study_location']);
        $locationCode = config('registration.locations')[$data['study_location']];
        $uniqueCode = sprintf('%s-%s-%03d', config('registration.event_code'), $locationCode, $sequence);
        $qrPayload = route('attendance.confirm', ['registration' => $uniqueCode]);

        $registration = Registration::create([
            'full_name' => $data['full_name'],
            'school' => $data['school'],
            'phone' => $data['phone'],
            'study_location' => $data['study_location'],
            'program' => $data['program'],
            'class_level' => $data['class_level'],
            'permission_letter_path' => $paths['path'] ?? null,
            'permission_letter_original_name' => $paths['original'] ?? null,
            'sequence_number' => $sequence,
            'unique_code' => $uniqueCode,
            'qr_payload' => $qrPayload,
            'status' => Registration::STATUS_REGISTERED,
        ]);

        $this->notifyAdmins($registration);

        ActivityLogger::log(
            action: 'registration.created',
            description: "Pendaftaran {$registration->unique_code}",
            properties: [
                'full_name' => $registration->full_name,
                'study_location' => $registration->study_location,
                'program' => $registration->program,
            ],
            user: null,
            request: $request
        );

        return redirect()
            ->route('registrations.create')
            ->with('status', "Pendaftaran {$registration->unique_code} berhasil.");
    }

    private function notifyAdmins(Registration $registration): void
    {
        $admins = User::where('role', 'admin')->get();

        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, new NewRegistrationNotification($registration));
    }

    private function nextSequenceNumber(string $studyLocation): int
    {
        $lastSequence = Registration::where('study_location', $studyLocation)->max('sequence_number');

        return (int) $lastSequence + 1;
    }

    private function storePermissionLetter(StoreRegistrationRequest $request): array
    {
        if (! $request->hasFile('permission_letter')) {
            return [];
        }

        $file = $request->file('permission_letter');

        $path = $file->store('letters', 'public');

        return [
            'path' => $path,
            'original' => $file->getClientOriginalName(),
        ];
    }
}
