@extends('layouts.master')

@section('title','Create User')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
        <div class="rounded-sm border border-stroke bg-white p-7.5 shadow-default dark:border-strokedark dark:bg-boxdark">
            <h2 class="text-2xl font-bold text-black dark:text-white mb-6">Create User</h2>

            @if($errors->any())
                <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-200">
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('manage-user.store') }}" method="POST" class="space-y-5">
                @csrf
                <x-form.input name="name" label="Name" required />
                <x-form.input name="email" type="email" label="Email" required />
                <x-form.input name="password" type="password" label="Password" required />
                <x-form.select name="role" label="Role" :options="$roles->map(fn($r)=>['value'=>$r->name,'label'=>$r->name])->toArray()" placeholder="Select Role" />
                <x-form.checkbox name="verified" :checked="old('verified')" label="Email Verified" />
                <div class="flex justify-end gap-3 pt-2">
                    <x-button as="a" href="{{ route('manage-user.index') }}" variant="secondary">Cancel</x-button>
                    <x-button type="submit" variant="primary">Create User</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
