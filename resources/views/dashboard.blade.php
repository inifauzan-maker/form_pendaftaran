<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <p>{{ __("You're logged in!") }}</p>

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
            </div>
        </div>
    </div>
</x-app-layout>
