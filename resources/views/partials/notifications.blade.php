{{-- =========================================================================
     Notifikasi pesan: badge sidebar (#navUnread), toast + suara + Web Push.
     Bekerja lewat polling endpoint unread-count (andal tanpa WebSocket), dan
     juga menerima dorongan instan dari Echo bila tersambung (dedup per id).
     Disertakan di layout teknisi & pengguna setelah partials.echo.
     ========================================================================= --}}
@auth
@php
    $unreadUrl = auth()->user()->isTechnician()
        ? route('technician.messages.unread')
        : (auth()->user()->isUser() ? route('user.messages.unread') : null);
@endphp
@if($unreadUrl)
<script>
(function () {
    const UNREAD_URL = @json($unreadUrl);
    const POLL_MS = 5000;

    const notified = new Set();   // id pesan yang sudah dinotifikasi (dedup)
    let lastMaxId = 0;
    let primed = false;           // cegah toast untuk histori saat pertama load

    // --- Badge (data-badge="messages" = pesan, "requests" = booking baru) ----
    // Bisa ada di beberapa tempat sekaligus: sidebar, foto profil, menu, ikon
    // menu HP. Elemen ber-data-badge-dot hanya berupa titik tanpa angka.
    function setBadge(n, key = 'messages') {
        document.querySelectorAll('[data-badge="' + key + '"]').forEach((b) => {
            const show = n > 0;
            b.classList.toggle('hidden', !show);
            if (b.hasAttribute('data-badge-dot')) return;
            b.textContent = n > 99 ? '99+' : String(n);
            b.classList.toggle('inline-flex', show);
        });
    }

    // --- Suara notifikasi (WebAudio, tanpa file aset) -----------------------
    let actx = null;
    window.fmSound = function () {
        try {
            actx = actx || new (window.AudioContext || window.webkitAudioContext)();
            const o = actx.createOscillator();
            const g = actx.createGain();
            o.connect(g); g.connect(actx.destination);
            o.type = 'sine';
            o.frequency.setValueAtTime(880, actx.currentTime);
            o.frequency.setValueAtTime(1175, actx.currentTime + 0.12);
            g.gain.setValueAtTime(0.0001, actx.currentTime);
            g.gain.exponentialRampToValueAtTime(0.18, actx.currentTime + 0.01);
            g.gain.exponentialRampToValueAtTime(0.0001, actx.currentTime + 0.3);
            o.start();
            o.stop(actx.currentTime + 0.31);
        } catch (e) { /* audio diblokir sampai ada interaksi; abaikan */ }
    };

    // --- Tangani satu pesan masuk (dipakai polling & Echo) ------------------
    window.fmIncoming = function (m) {
        if (!m || m.id == null || notified.has(String(m.id))) return;
        notified.add(String(m.id));

        const onThisChat = window.__fmActiveBooking
            && String(window.__fmActiveBooking) === String(m.booking_id);

        // Sedang membaca chat ini & tab aktif → jendela chat yang menampilkan.
        if (onThisChat && !document.hidden) return;

        window.fmSound && window.fmSound();

        if (document.hidden) {
            window.fmNotify && window.fmNotify({
                title: m.sender_name, body: m.snippet, icon: m.sender_avatar, url: m.url,
            });
        } else {
            window.fmToast && window.fmToast({
                title: m.sender_name, body: m.snippet, avatar: m.sender_avatar,
                url: m.url, actionLabel: 'Buka Chat',
            });
        }
    };

    // --- Polling unread-count → badge + deteksi pesan baru ------------------
    async function poll() {
        try {
            const res = await fetch(UNREAD_URL, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            setBadge(data.count || 0, 'messages');
            if (data.pending_bookings !== undefined) setBadge(data.pending_bookings, 'requests');

            const latest = data.latest;
            if (latest) {
                if (!primed) { lastMaxId = latest.id; primed = true; }
                else if (latest.id > lastMaxId) { lastMaxId = latest.id; window.fmIncoming(latest); }
            } else {
                primed = true;
            }
        } catch (e) { /* coba lagi pada putaran berikutnya */ }
    }

    // Dipanggil halaman chat agar badge langsung turun setelah pesan dibaca.
    window.fmRefreshUnread = poll;

    poll();
    setInterval(poll, POLL_MS);
    document.addEventListener('visibilitychange', () => { if (!document.hidden) poll(); });

    // --- Dorongan instan dari Echo (bila tersambung) -----------------------
    if (window.Echo) {
        window.Echo.private('App.Models.User.{{ auth()->id() }}')
            .listen('.message.sent', (e) => {
                const snippet = e.message.length > 60 ? e.message.slice(0, 60) + '…' : e.message;
                window.fmIncoming({
                    id: e.id, booking_id: e.booking_id, sender_name: e.sender_name,
                    sender_avatar: e.sender_avatar, snippet, url: e.url,
                });
                poll(); // perbarui badge segera
            });
    }
})();
</script>
@endif
@endauth
