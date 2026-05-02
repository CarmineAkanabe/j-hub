@extends('layouts.auth')

@section('sidebar')
    @include('components.sidebar.admin-sidebar')
@endsection

@section('content')
    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Users</h1>
                    <p class="mt-2 text-sm text-slate-600">View and manage registered accounts.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mt-6">
                    <x-ui.alert type="success">{{ session('success') }}</x-ui.alert>
                </div>
            @endif
            @if (session('error'))
                <div class="mt-6">
                    <x-ui.alert type="error">{{ session('error') }}</x-ui.alert>
                </div>
            @endif

            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold">Created</th>
                            <th class="px-6 py-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-slate-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ ucfirst($user->role->value) }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-slate-500">
                                    <div class="flex flex-wrap gap-2">
                                        <x-ui.button href="{{ route('admin.users.show', $user) }}" variant="secondary"
                                            size="sm">View</x-ui.button>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.button type="submit" variant="danger"
                                                    size="sm">Delete</x-ui.button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
