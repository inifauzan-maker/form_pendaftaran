@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-2xl font-semibold text-slate-900">Form Pendaftaran Peserta</h1>
            <p class="mt-1 text-sm text-slate-500">Isi semua field wajib untuk mendapatkan kode unik dan QR kehadiran.</p>

            <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-5">
                @csrf

                <div>
                    <label for="full_name" class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                        class="mt-1 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-100 @error('full_name') border-rose-400 @enderror"
                        required>
                    @error('full_name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div data-school-endpoint="{{ route('schools.index') }}">
                    <label for="school" class="text-sm font-medium text-slate-700">Asal Sekolah</label>
                    <select id="school" name="school"
                        class="mt-1 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm @error('school') border-rose-400 @enderror"
                        data-placeholder="Ketik nama sekolah...">
                        @if (old('school'))
                            <option value="{{ old('school') }}" selected>{{ old('school') }}</option>
                        @endif
                    </select>
                    <p class="mt-1 text-xs text-slate-500">Gunakan kata kunci untuk mencari atau tambahkan nama baru.</p>
                    @error('school')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="text-sm font-medium text-slate-700">Nomor HP / Whatsapp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="mt-1 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-100 @error('phone') border-rose-400 @enderror"
                        placeholder="08xxxxxxxxxx" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Lokasi Belajar</label>
                    <div class="mt-2 grid gap-2 md:grid-cols-3">
                        @foreach ($studyLocations as $location)
                            <label class="flex cursor-pointer items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm shadow-sm @error('study_location') border-rose-400 @enderror">
                                <input type="radio" name="study_location" value="{{ $location }}" class="text-indigo-600 focus:ring-indigo-500"
                                    {{ old('study_location') === $location ? 'checked' : '' }} required>
                                <span>{{ $location }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('study_location')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="program" class="text-sm font-medium text-slate-700">Program</label>
                        <select name="program" id="program"
                            class="mt-1 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-100 @error('program') border-rose-400 @enderror"
                            required>
                            <option value="" disabled {{ old('program') ? '' : 'selected' }}>Pilih program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program }}" @selected(old('program') === $program)>{{ $program }}</option>
                            @endforeach
                        </select>
                        @error('program')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="class_level" class="text-sm font-medium text-slate-700">Kelas</label>
                        <input type="text" name="class_level" id="class_level" value="{{ old('class_level') }}"
                            class="mt-1 w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-100 @error('class_level') border-rose-400 @enderror"
                            placeholder="Contoh: Kelas Gold" required>
                        @error('class_level')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="permission_letter" class="text-sm font-medium text-slate-700">Surat Keterangan Ijin (PDF/JPG/PNG)</label>
                    <input type="file" name="permission_letter" id="permission_letter"
                        class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('permission_letter')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="mt-2 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-200">
                    Kirim Pendaftaran
                </button>
            </form>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">Alur singkat</h2>
            <ol class="mt-4 list-decimal space-y-3 pl-6 text-sm text-slate-600">
                <li>Isi formulir dan unggah surat ijin bila sudah tersedia.</li>
                <li>Setiap peserta akan otomatis dibuatkan kode unik serta QR attendance.</li>
                <li>Kode dapat dikirim ke Whatsapp peserta lewat dashboard panitia.</li>
                <li>Panitia melakukan validasi kedatangan cukup dengan menscan QR peserta.</li>
            </ol>
            @can('view-dashboard')
                <a href="{{ route('dashboard') }}"
                    class="mt-6 inline-flex items-center justify-center rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-600 hover:border-indigo-300">
                    Buka Dashboard
                </a>
            @endcan
        </section>
    </div>
@endsection
