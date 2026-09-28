<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'CRM') - Mini ERP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900" x-data="{ sidebarOuverte: true }">
    <div class="flex min-h-screen">
        {{-- Barre laterale --}}
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0" x-show="sidebarOuverte">
            <div class="p-4 text-xl font-bold border-b border-gray-700">Module CRM</div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">Tableau de bord</a>
                <a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('clients.*') ? 'bg-gray-700' : '' }}">Clients &amp; Prospects</a>
                <a href="{{ route('opportunites.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('opportunites.*') ? 'bg-gray-700' : '' }}">Opportunites</a>
                <a href="{{ route('reclamations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('reclamations.*') ? 'bg-gray-700' : '' }}">Reclamations</a>

                @if(auth()->user()?->hasRole('admin'))
                    <a href="{{ route('utilisateurs.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('utilisateurs.*') ? 'bg-gray-700' : '' }}">Utilisateurs &amp; Roles</a>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            {{-- Barre superieure --}}
            <header class="bg-white border-b px-6 py-3 flex items-center justify-between">
                <button @click="sidebarOuverte = !sidebarOuverte" class="text-gray-500">&#9776;</button>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Connecte en tant que <strong>{{ auth()->user()->name ?? '' }}</strong>
                        @if(auth()->user()?->role)
                            <span class="ml-1 text-xs px-2 py-0.5 bg-gray-200 rounded-full">{{ auth()->user()->role->nom }}</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm px-3 py-1 rounded bg-gray-900 text-white hover:bg-gray-700">
                            Deconnexion
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (session('succes'))
                    <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">
                        {{ session('succes') }}
                    </div>
                @endif

                @yield('contenu')
            </main>
        </div>
    </div>
</body>
</html>