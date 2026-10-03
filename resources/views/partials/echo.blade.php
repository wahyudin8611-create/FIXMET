{{-- =========================================================================
     Real-time bootstrap: Laravel Echo + Reverb (protokol Pusher) via CDN.
     Disertakan di <layouts.app> dan <layouts.technician> sebelum @stack('scripts')
     sehingga window.Echo sudah siap saat skrip halaman berjalan.
     Juga memasang listener notifikasi GLOBAL per-pengguna (toast + push).
     ========================================================================= --}}

<style>
    /* Toast / in-app banner */
    #fm-toast-wrap { position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: .5rem; max-width: 92vw; }
    .fm-toast {
        display: flex; align-items: flex-start; gap: .75rem;
        width: 340px; max-width: 92vw;
        background: #fff; border: 1px solid rgba(0,0,0,.06);
        border-left: 4px solid #3D8B7A;
        border-radius: 14px; padding: .75rem .9rem;
        box-shadow: 0 10px 30px rgba(26,35,50,.16);
        cursor: pointer;
        animation: fm-toast-in .28s cubic-bezier(.2,.8,.2,1);
    }
    .fm-toast.fm-leaving { animation: fm-toast-out .25s ease forwards; }
    @keyframes fm-toast-in  { from { opacity: 0; transform: translateX(24px) scale(.98); } to { opacity: 1; transform: none; } }
    @keyframes fm-toast-out { to   { opacity: 0; transform: translateX(24px) scale(.98); } }

    /* Typing indicator (tiga titik memantul) */
    .fm-typing { display: inline-flex; align-items: center; gap: 4px; padding: 8px 12px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; border-bottom-left-radius: 4px; }
    .fm-typing span { width: 6px; height: 6px; border-radius: 9999px; background: #9ca3af; display: inline-block; animation: fm-bounce 1.3s infinite ease-in-out both; }
    .fm-typing span:nth-child(1) { animation-delay: -.32s; }
    .fm-typing span:nth-child(2) { animation-delay: -.16s; }
    @keyframes fm-bounce { 0%, 80%, 100% { transform: scale(.6); opacity: .5; } 40% { transform: scale(1); opacity: 1; } }
</style>

<div id="fm-toast-wrap" aria-live="polite" aria-atomic="true"></div>

<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.17.1/dist/echo.iife.js"></script>
<script>
(function () {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    // --- Inisialisasi Echo (Reverb berbicara protokol Pusher) ---------------
    try {
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: @json(config('broadcasting.connections.reverb.key')),
            wsHost: @json(config('broadcasting.connections.reverb.options.host')),
            wsPort: {{ (int) config('broadcasting.connections.reverb.options.port', 8080) }},
            wssPort: {{ (int) config('broadcasting.connections.reverb.options.port', 8080) }},
            forceTLS: @json(config('broadcasting.connections.reverb.options.scheme') === 'https'),
            enabledTransports: ['ws', 'wss'],
            disableStats: true,
            cluster: 'mt1', // wajib diisi oleh pusher-js walau tak dipakai dengan host custom
            auth: { headers: { 'X-CSRF-TOKEN': token } },
        });
    } catch (e) {
        console.warn('Echo gagal diinisialisasi:', e);
    }

    // --- Helper: toast in-app ----------------------------------------------
    const wrap = document.getElementById('fm-toast-wrap');
    window.fmToast = function ({ title, body, avatar, url }) {
        if (!wrap) return;
        const el = document.createElement('div');
        el.className = 'fm-toast';
        el.innerHTML =
            (avatar ? '<img src="' + avatar + '" class="w-9 h-9 rounded-full object-cover shrink-0" alt="">' : '') +
            '<div class="min-w-0 flex-1">' +
                '<div class="text-sm font-semibold text-gray-900 truncate">' + title + '</div>' +
                '<div class="text-xs text-gray-500 truncate">' + body + '</div>' +
            '</div>';
        if (url) el.addEventListener('click', () => { window.location.href = url; });
        wrap.appendChild(el);
        const close = () => { el.classList.add('fm-leaving'); setTimeout(() => el.remove(), 260); };
        setTimeout(close, 5000);
    };

    // --- Helper: OS/browser push notification -------------------------------
    if ('Notification' in window && Notification.permission === 'default') {
        // Permintaan izin; sebagian browser butuh gesture, tak masalah bila ditolak.
        setTimeout(() => { try { Notification.requestPermission(); } catch (e) {} }, 1200);
    }
    window.fmNotify = function ({ title, body, icon, url }) {
        if (!('Notification' in window) || Notification.permission !== 'granted') return;
        try {
            const n = new Notification(title, { body, icon, tag: url });
            n.onclick = () => { window.focus(); if (url) window.location.href = url; n.close(); };
        } catch (e) {}
    };

    const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c]));

    // --- Listener notifikasi GLOBAL per-pengguna ----------------------------
    @auth
    if (window.Echo) {
        window.Echo.private('App.Models.User.{{ auth()->id() }}')
            .listen('.message.sent', (e) => {
                const onThisChat = window.__fmActiveBooking && String(window.__fmActiveBooking) === String(e.booking_id);
                const snippet = e.message.length > 60 ? e.message.slice(0, 60) + '…' : e.message;

                if (document.hidden) {
                    // Tab tidak aktif → push notification OS.
                    window.fmNotify({ title: e.sender_name, body: snippet, icon: e.sender_avatar, url: e.url });
                } else if (!onThisChat) {
                    // Sedang buka halaman lain → toast in-app.
                    window.fmToast({ title: esc(e.sender_name), body: esc(snippet), avatar: e.sender_avatar, url: e.url });
                }
                // Jika sedang membuka chat booking ini & tab aktif → biarkan
                // jendela chat yang menampilkannya (tanpa duplikasi notifikasi).
            });
    }
    @endauth
})();
</script>
