@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Dashboard Pendaftar</h1>
            <p class="text-sm text-slate-500">Pantau peserta, bagikan QR ke Whatsapp, dan cek status kehadiran.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('registrations.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                + Tambah Pendaftar
            </a>
            <a href="{{ route('dashboard.export') }}"
                class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-indigo-300 hover:text-indigo-700">
                Export XLSX
            </a>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Peserta</th>
                        <th class="px-4 py-3">Detail Belajar</th>
                        <th class="px-4 py-3">Kode & QR</th>
                        <th class="px-4 py-3">Surat Ijin</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-4 py-4 align-top">
                                <p class="font-semibold text-slate-900">{{ $registration->full_name }}</p>
                                <p class="text-xs text-slate-500">{{ $registration->school }}</p>
                                <span
                                    class="mt-2 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $registration->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700' : 'bg-indigo-50 text-indigo-700' }}">
                                    {{ $registration->status }}
                                </span>
                                @if ($registration->attended_at)
                                    <p class="text-[11px] text-slate-500">Hadir: {{ $registration->attended_at->format('d M H:i') }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 align-top text-xs">
                                <p class="font-semibold text-slate-900">{{ $registration->study_location }}</p>
                                <p class="text-slate-500">Program: {{ $registration->program }}</p>
                                <p class="text-slate-500">Kelas: {{ $registration->class_level }}</p>
                                <p class="text-slate-500">HP: {{ $registration->phone }}</p>
                            </td>
                            <td class="px-4 py-4 align-top text-center">
                                <div class="text-sm font-semibold text-slate-900">{{ $registration->unique_code }}</div>
                                <canvas width="120" height="120" class="mx-auto mt-2 rounded-lg border border-slate-200 p-1"
                                    data-qr="{{ $registration->qr_payload }}" data-code="{{ $registration->unique_code }}"></canvas>
                                <p class="mt-1 text-[11px] text-slate-500">Scan =&gt; status hadir otomatis</p>
                            </td>
                            <td class="px-4 py-4 align-top text-xs">
                                @if ($registration->permission_letter_path)
                                    <a href="{{ asset('storage/' . $registration->permission_letter_path) }}" target="_blank"
                                        class="inline-flex items-center gap-1 rounded-md border border-slate-200 px-3 py-1 text-[11px] font-semibold text-slate-600 hover:text-indigo-600">
                                        Lihat Surat
                                    </a>
                                    <p class="mt-1 text-[11px] text-slate-500 truncate">{{ $registration->permission_letter_original_name }}</p>
                                @else
                                    <p class="text-slate-400">Belum diunggah</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 align-top text-xs">
                                <button type="button"
                                    class="wa-share inline-flex w-full items-center justify-center rounded-md bg-emerald-100 px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-200"
                                    data-phone="{{ $registration->phone }}" data-name="{{ $registration->full_name }}"
                                    data-code="{{ $registration->unique_code }}" data-link="{{ $registration->qr_payload }}">
                                    Kirim QR via WA
                                </button>
                                <a href="{{ $registration->qr_payload }}"
                                    class="mt-2 inline-flex w-full items-center justify-center rounded-md border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-slate-300"
                                    target="_blank">Link Absensi</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-500">
                                Belum ada pendaftar. Mulai dari <a href="{{ route('registrations.create') }}"
                                    class="text-indigo-600 underline">halaman formulir</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-4 py-3">
            {{ $registrations->links() }}
        </div>
    </div>
@endsection
