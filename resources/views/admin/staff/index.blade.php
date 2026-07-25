@extends('layouts.admin')
@section('title', 'Staff Management')

@section('content')
{{-- Add Staff --}}
<div class="bg-white rounded-2xl p-6 shadow-sm mb-6" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold min-h-[44px]" style="color:#D07A54;">
        <x-admin-icon name="plus" class="w-4 h-4" /> Add Staff Member
    </button>
    <div x-show="open" x-transition class="mt-4">
        <form action="{{ route('admin.staff.store') }}" method="POST" class="grid sm:grid-cols-3 gap-4">
            @csrf
            <div><label class="block text-xs mb-1">Name</label><input type="text" name="name" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Email</label><input type="email" name="email" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Phone</label><input type="tel" name="phone" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div><label class="block text-xs mb-1">Role</label>
                <select name="role" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                    <option value="manager">Manager</option>
                    <option value="director">Director</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div><label class="block text-xs mb-1">Password</label><input type="password" name="password" required minlength="8" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"></div>
            <div class="flex items-end"><button type="submit" class="w-full py-2 rounded-xl text-white text-sm font-semibold" style="background-color:#D07A54;">Create</button></div>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto admin-scroll">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Name</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Email</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Role</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Joined</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($staff as $member)
            <tr>
                <td class="px-5 py-3 font-medium">{{ $member->name }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $member->email }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold capitalize
                        {{ $member->hasRole('director')?'bg-purple-100 text-purple-700':($member->hasRole('manager')?'bg-blue-100 text-blue-700':'bg-gray-100 text-gray-700') }}">
                        {{ $member->getRoleNames()->first() }}
                    </span>
                </td>
                <td class="px-5 py-3 text-gray-400">{{ $member->created_at->format('d M Y') }}</td>
                <td class="px-5 py-3">
                    @if(!$member->hasRole('director'))
                    <div class="relative flex items-center gap-1 justify-end" x-data="{ editing: false }">
                        <button @click="editing = !editing"
                                class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition"
                                aria-label="Edit {{ $member->name }}">
                            <x-admin-icon name="pencil" class="w-4 h-4" />
                        </button>
                        <form action="{{ route('admin.staff.destroy', $member) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Remove staff member?', message: '\'{{ addslashes($member->name) }}\' will lose access immediately.' })"
                                    class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition"
                                    aria-label="Remove {{ $member->name }}">
                                <x-admin-icon name="trash" class="w-4 h-4" />
                            </button>
                        </form>

                        {{-- Edit panel --}}
                        <div x-show="editing" x-cloak x-transition @click.outside="editing = false"
                             class="absolute right-8 z-20 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 p-4 text-left">
                            <h4 class="text-sm font-semibold mb-3" style="color:#1E3A4A;">Edit {{ $member->name }}</h4>
                            <form action="{{ route('admin.staff.update', $member) }}" method="POST" class="space-y-3">
                                @csrf @method('PUT')
                                <div><label class="block text-xs mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $member->name }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $member->email }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Phone</label>
                                    <input type="tel" name="phone" value="{{ $member->phone }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Role</label>
                                    <select name="role" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                                        <option value="manager" {{ $member->hasRole('manager')?'selected':'' }}>Manager</option>
                                        <option value="director">Director — full access</option>
                                        <option value="staff" {{ $member->hasRole('staff')?'selected':'' }}>Staff</option>
                                        <option value="customer">Customer — remove from team</option>
                                    </select></div>
                                <div><label class="block text-xs mb-1">New Password <span class="text-gray-400">(leave blank to keep)</span></label>
                                    <input type="password" name="password" minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <button type="submit" class="w-full py-2 rounded-lg text-white text-sm font-semibold" style="background-color:#1E3A4A;">Save Changes</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

{{-- Registered Users (customers) --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden mt-8">
    <div class="px-5 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="font-semibold text-sm" style="color:#1E3A4A;">Registered Users</h2>
            <p class="text-xs text-gray-400 mt-0.5">Customers who signed up on the website. Promote them to staff, edit, or remove them.</p>
        </div>
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email"
                   class="rounded-xl border border-gray-200 px-3 py-2 min-h-[40px] text-sm">
            <button type="submit" class="px-4 py-2 min-h-[40px] rounded-xl text-white text-sm font-semibold" style="background-color:#1E3A4A;">Search</button>
        </form>
    </div>
    <div class="overflow-x-auto admin-scroll">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Name</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Email</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Phone</th>
                <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Registered</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $member)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium">{{ $member->name }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $member->email }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $member->phone ?? '—' }}</td>
                <td class="px-5 py-3 text-gray-400">{{ $member->created_at->format('d M Y') }}</td>
                <td class="px-5 py-3">
                    <div class="relative flex items-center gap-1 justify-end" x-data="{ editing: false }">
                        <button @click="editing = !editing"
                                class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition"
                                aria-label="Edit {{ $member->name }}">
                            <x-admin-icon name="pencil" class="w-4 h-4" />
                        </button>
                        <form action="{{ route('admin.staff.destroy', $member) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button"
                                    @click="$dispatch('confirm-action', { form: $el.closest('form'), title: 'Delete this user?', message: '\'{{ addslashes($member->name) }}\' will lose their account. Their bookings are kept as guest records.' })"
                                    class="w-9 h-9 min-h-[44px] min-w-[44px] flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition"
                                    aria-label="Delete {{ $member->name }}">
                                <x-admin-icon name="trash" class="w-4 h-4" />
                            </button>
                        </form>

                        {{-- Edit panel --}}
                        <div x-show="editing" x-cloak x-transition @click.outside="editing = false"
                             class="absolute right-8 z-20 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 p-4 text-left">
                            <h4 class="text-sm font-semibold mb-3" style="color:#1E3A4A;">Edit {{ $member->name }}</h4>
                            <form action="{{ route('admin.staff.update', $member) }}" method="POST" class="space-y-3">
                                @csrf @method('PUT')
                                <div><label class="block text-xs mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $member->name }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $member->email }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Phone</label>
                                    <input type="tel" name="phone" value="{{ $member->phone }}" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <div><label class="block text-xs mb-1">Role</label>
                                    <select name="role" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
                                        <option value="customer" selected>Customer</option>
                                        <option value="staff">Staff — promote to team</option>
                                        <option value="manager">Manager — promote to team</option>
                                        <option value="director">Director — promote to team (full access)</option>
                                    </select></div>
                                <div><label class="block text-xs mb-1">New Password <span class="text-gray-400">(leave blank to keep)</span></label>
                                    <input type="password" name="password" minlength="8" autocomplete="new-password" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm"></div>
                                <button type="submit" class="w-full py-2 rounded-lg text-white text-sm font-semibold" style="background-color:#1E3A4A;">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">No registered users {{ request('search') ? 'matching your search' : 'yet' }}.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100">{{ $customers->links() }}</div>
</div>
@endsection
