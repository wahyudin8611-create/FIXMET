{{-- Profile menu for a signed-in user: avatar button with a dropdown of their
     dashboard, profile and sign-out. Shared by the landing and app navbars. --}}
<div class="relative" x-data="{ userOpen: false }" @click.away="userOpen = false">
    <button @click="userOpen = !userOpen"
            class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-fm-light transition-colors group">
        <div class="relative">
            <img src="{{ auth()->user()->profile_photo_url }}"
                 class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-100 group-hover:ring-fm-primary/30 transition-all"
                 alt="{{ auth()->user()->name }}">
            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white
                 @if(auth()->user()->isAdmin()) bg-red-500
                 @elseif(auth()->user()->isTechnician()) bg-emerald-500
                 @else bg-fm-primary @endif">
            </div>
            <span data-badge="messages" class="hidden absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold leading-none items-center justify-center ring-2 ring-white" aria-label="Pesan belum dibaca">0</span>
        </div>
        <div class="hidden md:block text-left">
            <p class="text-xs font-bold text-fm-dark leading-none">{{ Str::words(auth()->user()->name, 1, '') }}</p>
            <p class="text-xs text-fm-muted capitalize">{{ auth()->user()->role }}</p>
        </div>
        <svg class="w-3.5 h-3.5 text-fm-muted transition-transform duration-200 hidden md:block"
             :class="userOpen ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="userOpen" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
         style="box-shadow: 0 10px 40px rgba(0,0,0,0.12);">

        <div class="px-4 py-3.5 border-b border-gray-50">
            <div class="flex items-center gap-2.5">
                <img src="{{ auth()->user()->profile_photo_url }}"
                     class="w-9 h-9 rounded-xl object-cover" alt="">
                <div>
                    <p class="text-sm font-bold text-fm-dark">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-fm-muted">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full capitalize
                     @if(auth()->user()->isAdmin()) bg-red-100 text-red-700
                     @elseif(auth()->user()->isTechnician()) bg-emerald-100 text-emerald-700
                     @else bg-fm-primary/10 text-fm-primary @endif">
                    {{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <div class="py-1.5">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                        <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                    </div>
                    Dashboard Admin
                </a>
            @elseif(auth()->user()->isTechnician())
                <a href="{{ route('technician.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                    </div>
                    Dashboard Teknisi
                </a>
                <a href="{{ route('technician.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-3.5 h-3.5 text-fm-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Edit Profil
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-fm-primary/10 flex items-center justify-center group-hover:bg-fm-primary/20 transition-colors">
                        <svg class="w-3.5 h-3.5 text-fm-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/></svg>
                    </div>
                    Dashboard
                </a>
                <a href="{{ route('diagnosis.create') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-fm-accent/10 flex items-center justify-center group-hover:bg-fm-accent/20 transition-colors">
                        <svg class="w-3.5 h-3.5 text-fm-accent-hover" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                    </div>
                    Mulai Diagnosa
                </a>
                <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-3.5 h-3.5 text-fm-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    Edit Profil
                </a>
            @endif
            @unless(auth()->user()->isAdmin())
                <a href="{{ route(auth()->user()->isTechnician() ? 'technician.messages.index' : 'user.messages.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fm-text hover:bg-fm-light transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-sky-50 flex items-center justify-center group-hover:bg-sky-100 transition-colors">
                        <x-icon name="chat" class="w-3.5 h-3.5 text-sky-600" />
                    </div>
                    Pesan
                    <span data-badge="messages" class="hidden ml-auto min-w-[20px] h-5 px-1.5 rounded-full bg-red-500 text-white text-[11px] font-bold leading-none items-center justify-center">0</span>
                </a>
            @endunless
        </div>

        <div class="border-t border-gray-50 py-1.5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </div>
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </div>
</div>
