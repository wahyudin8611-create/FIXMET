{{-- Always-visible link to the signed-in user's own dashboard (by role), shared by
     the landing and app navbars. Pass $class to control when it shows. --}}
<a href="{{ auth()->user()->dashboardUrl() }}"
   class="{{ $class ?? 'inline-flex' }} items-center gap-1.5 text-sm font-semibold text-fm-primary bg-fm-primary/5 border border-fm-primary/25 hover:bg-fm-primary/10 px-3.5 py-2 rounded-xl transition-colors">
    <x-icon name="home" class="w-4 h-4" />
    Dashboard
</a>
