<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Form Pendaftaran Art Camp' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 min-h-screen text-slate-900 antialiased">
    <header class="bg-white shadow-sm">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('registrations.create') }}" class="text-lg font-semibold text-slate-900">
                    Form Art Camp
                </a>
                <nav class="flex gap-4 text-sm font-medium text-slate-600">
                    <a href="{{ route('registrations.create') }}"
                        class="{{ request()->routeIs('registrations.*') ? 'text-indigo-600' : 'hover:text-indigo-600' }}">Formulir</a>
                    @can('view-dashboard')
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'hover:text-indigo-600' }}">Dashboard</a>
                    @endcan
                </nav>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-xs uppercase tracking-wide text-slate-500">
                        {{ Auth::user()->name }}
                        <span class="font-semibold text-slate-700">({{ Auth::user()->role }})</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:border-indigo-200 hover:text-indigo-600">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-lg border border-indigo-200 px-3 py-1.5 text-xs font-semibold text-indigo-600 hover:border-indigo-300">
                        Login Panitia
                    </a>
                @endauth
            </div>
        </div>
    </header>
    <main class="mx-auto w-full max-w-6xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>
</body>

</html>
