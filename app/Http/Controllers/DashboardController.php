<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'registrations' => Registration::latest()->paginate(12),
            'locations' => config('registration.locations'),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'registrations-' . now()->format('Ymd-His') . '.csv';
        $registrations = Registration::orderBy('created_at')->get();

        ActivityLogger::log(
            action: 'registrations.exported',
            description: 'Admin mengekspor data pendaftar',
            properties: ['count' => $registrations->count()],
            request: $request
        );

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = static function () use ($registrations): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No',
                'Kode Unik',
                'Nama Lengkap',
                'Sekolah',
                'Nomor HP',
                'Lokasi Belajar',
                'Program',
                'Kelas',
                'Status',
                'Tanggal Daftar',
                'Tanggal Hadir',
            ]);

            foreach ($registrations as $index => $registration) {
                fputcsv($handle, [
                    $index + 1,
                    $registration->unique_code,
                    $registration->full_name,
                    $registration->school,
                    $registration->phone,
                    $registration->study_location,
                    $registration->program,
                    $registration->class_level,
                    $registration->status,
                    $registration->created_at->format('d-m-Y H:i'),
                    optional($registration->attended_at)?->format('d-m-Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }
}
