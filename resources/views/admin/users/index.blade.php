@extends('layouts.master')

@section('title','Users')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-black dark:text-white">Users Management</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola akun & role pengguna.</p>
                </div>
                <div class="flex items-center gap-3">
                    <x-button as="a" href="{{ route('manage-user.create') }}" variant="primary" size="md">Add User</x-button>
                </div>
            </div>
            <x-table :headers="[
                ['label' => 'Name','class'=>'min-w-[150px]'],
                ['label' => 'Email','class'=>'min-w-[150px]'],
                ['label' => 'Roles','class'=>'min-w-[120px]'],
                ['label' => 'Actions']
            ]" empty="No users found.">
                @foreach($users as $user)
                    <x-table.row>
                        <x-table.cell>{{ $user->name }}</x-table.cell>
                        <x-table.cell muted>{{ $user->email }}</x-table.cell>
                        <x-table.cell muted>{{ $user->getRoleNames()->implode(', ') }}</x-table.cell>
                        <x-table.cell>
                            <div class="flex flex-wrap items-center gap-2">
                                <x-button as="a" href="{{ route('manage-user.edit', $user->id) }}" variant="secondary" size="sm" class="dark:border-gray-600 dark:hover:border-gray-500">Edit</x-button>
                                <form action="{{ route('manage-user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="sm" class="dark:bg-red-600 dark:hover:bg-red-500">Delete</x-button>
                                </form>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-table>
        </div>
    </div>
</div>
@endsection
