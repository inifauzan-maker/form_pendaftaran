@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-xl rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
        <p class="text-sm uppercase tracking-wide text-slate-500">Validasi Kehadiran</p>
        <h1 class="mt-2 text-3xl font-semibold text-slate-900">{{ $registration->unique_code }}</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $registration->full_name }}</p>
        <p class="text-sm text-slate-500">{{ $registration->study_location }} • {{ $registration->program }}</p>

        @if ($wasUpdated)
            <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                Status peserta berhasil diperbarui menjadi <strong>Hadir</strong>.
            </div>
        @else
            <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                Peserta ini sudah tercatat hadir pada {{ optional($registration->attended_at)->format('d M Y H:i') }}.
            </div>
        @endif

        <a href="{{ route('dashboard') }}"
            class="mt-8 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
