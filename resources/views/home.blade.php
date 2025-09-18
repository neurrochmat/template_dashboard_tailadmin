@extends('layouts.master')

@section('content')
    @if (Auth::user()->hasRole('admin'))
        <div class="grid grid-cols-12 gap-4 md:gap-6">
            <div class="col-span-12">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-theme-sm dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white/90">Dashboard Admin</h2>
                            <p class="text-gray-500 dark:text-gray-400">Ringkasan data dan tindakan cepat</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('manage-user.index') }}" class="inline-flex items-center rounded-lg bg-primary px-4 py-2 text-white hover:bg-opacity-90">Kelola Pengguna</a>
                            <a href="{{ route('manage-role.index') }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">Kelola Role</a>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Users</span>
                                <svg class="fill-gray-800 dark:fill-white/90" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6.5 5.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0ZM10 11c-3.333 0-5 1.667-5 3.333V16h10v-1.667C15 12.667 13.333 11 10 11Z"/></svg>
                            </div>
                            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['users'] ?? 0 }}</h4>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Roles</span>
                                <svg class="fill-gray-800 dark:fill-white/90" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M3 3h14v3l-7 4l-7-4V3Zm0 6.5l7 4l7-4V17H3V9.5Z"/></svg>
                            </div>
                            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['roles'] ?? 0 }}</h4>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Menus</span>
                                <svg class="fill-gray-800 dark:fill-white/90" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M3 5h14v2H3V5Zm0 4h14v2H3V9Zm0 4h14v2H3v-2Z"/></svg>
                            </div>
                            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['menus'] ?? 0 }}</h4>
                        </div>
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Permissions</span>
                                <svg class="fill-gray-800 dark:fill-white/90" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2l7 4v4c0 4.418-3.582 8-8 8S1 14.418 1 10V6l9-4Zm0 2.236L3 7v3c0 3.314 2.686 6 6 6s6-2.686 6-6V7l-5-2.764V10l-2 1V4.236Z"/></svg>
                            </div>
                            <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['permissions'] ?? 0 }}</h4>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
                        <div class="xl:col-span-2 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]"
                             x-data="userTable(@js($recentUsers->map(fn($u)=>['name'=>$u->name,'email'=>$u->email,'role'=>$u->getRoleNames()->implode(', ') ?: '-'])))" x-cloak>
                            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Pengguna Terbaru</h3>
                                <div class="flex w-full items-center gap-2 sm:w-auto">
                                    <div class="relative flex-1 sm:w-64">
                                        <input type="text" x-model.debounce.200ms="q" placeholder="Cari nama/email/role..."
                                               class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 placeholder:text-gray-400 focus:border-primary focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300" />
                                        <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.9 14.32a8 8 0 1 1 1.414-1.414l3.387 3.387-1.414 1.414-3.387-3.387ZM14 8a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <select x-model.number="perPage" class="rounded-lg border border-gray-200 bg-white px-2 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                    </select>
                                    <a href="{{ route('manage-user.index') }}" class="hidden text-primary text-sm sm:inline">Lihat semua</a>
                                </div>
                            </div>

                            <div class="w-full overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="border-y border-gray-100 dark:border-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <th class="py-3 cursor-pointer select-none" @click="setSort('name')">
                                                <div class="inline-flex items-center gap-1">Nama
                                                    <svg x-show="sortKey==='name' && sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6l-5 6h10l-5-6z"/></svg>
                                                    <svg x-show="sortKey==='name' && !sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 14l5-6H5l5 6z"/></svg>
                                                </div>
                                            </th>
                                            <th class="py-3 cursor-pointer select-none" @click="setSort('email')">
                                                <div class="inline-flex items-center gap-1">Email
                                                    <svg x-show="sortKey==='email' && sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6l-5 6h10l-5-6z"/></svg>
                                                    <svg x-show="sortKey==='email' && !sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 14l5-6H5l5 6z"/></svg>
                                                </div>
                                            </th>
                                            <th class="py-3 cursor-pointer select-none" @click="setSort('role')">
                                                <div class="inline-flex items-center gap-1">Role
                                                    <svg x-show="sortKey==='role' && sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 6l-5 6h10l-5-6z"/></svg>
                                                    <svg x-show="sortKey==='role' && !sortAsc" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10 14l5-6H5l5 6z"/></svg>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                        <template x-for="u in paged" :key="u.email">
                                            <tr>
                                                <td class="py-3 text-sm text-gray-700 dark:text-gray-300" x-text="u.name"></td>
                                                <td class="py-3 text-sm text-gray-700 dark:text-gray-300" x-text="u.email"></td>
                                                <td class="py-3 text-sm text-gray-700 dark:text-gray-300" x-text="u.role || '-' "></td>
                                            </tr>
                                        </template>
                                        <tr x-show="paged.length === 0">
                                            <td colspan="3" class="py-6 text-center text-sm text-gray-500">Tidak ada data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex flex-col items-center justify-between gap-3 sm:flex-row">
                                <div class="text-xs text-gray-500">Menampilkan <span x-text="start + 1"></span>–<span x-text="end"></span> dari <span x-text="total"></span> pengguna</div>
                                <div class="flex items-center gap-2">
                                    <button class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-700 disabled:opacity-50 dark:border-gray-700 dark:text-gray-300" @click="prev()" :disabled="page===1">Sebelumnya</button>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Hal. <span x-text="page"></span>/<span x-text="totalPages"></span></span>
                                    <button class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-700 disabled:opacity-50 dark:border-gray-700 dark:text-gray-300" @click="next()" :disabled="page===totalPages">Berikutnya</button>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Role Terbaru</h3>
                                    <a href="{{ route('manage-role.index') }}" class="text-primary text-sm">Kelola</a>
                                </div>
                                <ul class="space-y-2">
                                    @forelse($recentRoles as $r)
                                    <li class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300">
                                        <span>{{ $r->name }}</span>
                                    </li>
                                    @empty
                                    <li class="text-sm text-gray-500">Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
                                <div class="mb-3 flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Menu Terbaru</h3>
                                    <a href="{{ route('manage-menu.index') }}" class="text-primary text-sm">Kelola</a>
                                </div>
                                <ul class="space-y-2">
                                    @forelse($recentMenus as $m)
                                    <li class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300">
                                        <span>{{ $m->name ?? ('Menu #' . $m->id) }}</span>
                                        <span class="text-xs text-gray-500">{{ $m->parent?->name ? 'Submenu' : 'Menu' }}</span>
                                    </li>
                                    @empty
                                    <li class="text-sm text-gray-500">Tidak ada data</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('body:end')
<script>
    window.userTable = function(rows = []) {
        return {
            rows,
            q: '',
            sortKey: 'name',
            sortAsc: true,
            page: 1,
            perPage: 5,
            get filtered() {
                const q = this.q.toLowerCase().trim();
                if (!q) return this.rows;
                return this.rows.filter(u => [u.name, u.email, u.role].some(v => (v || '').toLowerCase().includes(q)));
            },
            get sorted() {
                return [...this.filtered].sort((a, b) => {
                    const ka = (a[this.sortKey] || '').toString().toLowerCase();
                    const kb = (b[this.sortKey] || '').toString().toLowerCase();
                    if (ka < kb) return this.sortAsc ? -1 : 1;
                    if (ka > kb) return this.sortAsc ? 1 : -1;
                    return 0;
                });
            },
            get total() { return this.sorted.length; },
            get totalPages() { return Math.max(1, Math.ceil(this.total / this.perPage)); },
            get start() { return (this.page - 1) * this.perPage; },
            get end() { return Math.min(this.start + this.perPage, this.total); },
            get paged() { return this.sorted.slice(this.start, this.start + this.perPage); },
            setSort(key) {
                if (this.sortKey === key) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortKey = key; this.sortAsc = true;
                }
                this.page = 1;
            },
            prev() { if (this.page > 1) this.page--; },
            next() { if (this.page < this.totalPages) this.page++; },
            reset() { this.q = ''; this.perPage = 5; this.page = 1; this.sortKey = 'name'; this.sortAsc = true; }
        }
    }
</script>
@endpush
