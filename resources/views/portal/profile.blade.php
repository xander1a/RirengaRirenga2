@extends('layouts.app')

@section('content')
<div class="py-12 px-4">
    <div class="max-w-xl mx-auto">
        <a href="{{ route('portal.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-6 inline-block">← My Account</a>
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <h1 class="font-display text-2xl font-bold mb-6" style="color:#2E4636;">Edit Profile</h1>
            <form action="{{ route('portal.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @if(session('success'))
                <div class="rounded-xl p-3 text-sm text-green-700 bg-green-50">{{ session('success') }}</div>
                @endif
                <div>
                    <label class="block text-sm font-medium mb-1">Full Name</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 bg-gray-50 text-gray-400">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:outline-none focus:ring-2">
                </div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold transition hover:opacity-90" style="background-color:#BF6B47;">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
