@extends('layouts.app')

@section('titre', 'Gestion des roles')

@section('contenu')
    <h1 class="text-2xl font-bold mb-4">Gestion des roles</h1>

    @if (session('erreur'))
        <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">
            {{ session('erreur') }}
        </div>
    @endif

    @error('role_id')
        <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">
            {{ $message }}
        </div>
    @enderror

    <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if ($user->id === auth()->id())
                                <span class="text-sm text-gray-500">
                                    {{ $roles->firstWhere('id', $user->role_id)?->nom ?? '-' }} (vous)
                                </span>
                            @else
                                <form method="POST" action="{{ route('utilisateurs.role.update', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role_id" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>
                                                {{ ucfirst($role->nom) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-1 text-sm rounded bg-gray-900 text-white hover:bg-gray-700">
                                        Enregistrer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection