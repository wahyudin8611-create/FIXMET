{{-- Live chat window (per-booking).
     Riwayat pesan dimuat sekali via REST (data-list-url); pesan baru + indikator
     mengetik dikirim real-time lewat WebSocket (Laravel Echo + Reverb).
     Bila WebSocket tidak tersambung (mis. hosting tanpa server Reverb), pesan baru
     diambil berkala dari data-list-url sebagai cadangan.
     Butuh elemen #chat dengan data-booking-id, data-list-url, data-me-avatar,
     data-partner-avatar, serta #chatBox, #chatForm, #chatInput, #chatSend. --}}
<script>
(function () {
    const root = document.getElementById('chat');
    if (!root) return;

    const box     = document.getElementById('chatBox');
    const form    = document.getElementById('chatForm');
    const input   = document.getElementById('chatInput');
    const sendBtn = document.getElementById('chatSend');
    const loading = document.getElementById('chatLoading');

    const bookingId     = root.dataset.bookingId;
    const meId          = root.dataset.meId;
    const listUrl       = root.dataset.listUrl;
    const meAvatar      = root.dataset.meAvatar;
    const partnerAvatar = root.dataset.partnerAvatar;
    const csrf          = document.querySelector('meta[name="csrf-token"]')?.content;

    // Tandai booking yang sedang dibuka agar notifikasi global tak menduplikasi.
    window.__fmActiveBooking = bookingId;

    const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    const nearBottom   = () => box.scrollHeight - box.scrollTop - box.clientHeight < 140;
    const scrollBottom = () => { box.scrollTop = box.scrollHeight; };

    function bubble(m) {
        // m: { message, mine, time }
        const avatar  = m.mine ? meAvatar : partnerAvatar;
        const rowCls  = m.mine ? 'justify-end' : 'justify-start';
        const img     = '<img src="' + avatar + '" class="w-7 h-7 rounded-full object-cover shrink-0" alt="">';
        const bubCls  = m.mine ? 'bg-primary-600 text-white rounded-br-md'
                               : 'bg-white border border-gray-200 text-gray-800 rounded-bl-md';
        const timeCls = m.mine ? 'text-white/70' : 'text-gray-400';
        const content =
            '<div class="max-w-[75%] px-3.5 py-2 rounded-2xl text-sm leading-relaxed shadow-sm ' + bubCls + '">' +
                '<div class="whitespace-pre-wrap break-words">' + esc(m.message) + '</div>' +
                '<div class="text-[10px] mt-1 ' + timeCls + ' text-right tabular-nums">' + esc(m.time) + '</div>' +
            '</div>';
        const el = document.createElement('div');
        el.className = 'flex items-end gap-2 ' + rowCls;
        el.innerHTML = m.mine ? content + img : img + content;
        return el;
    }

    // ID pesan yang sudah tampil, agar WebSocket dan polling tak menggandakan pesan.
    const shown = new Set();

    function appendMessage(m) {
        if (m.id !== undefined) {
            if (shown.has(String(m.id))) return;
            shown.add(String(m.id));
        }
        document.getElementById('chatEmpty')?.remove();
        const stick = nearBottom();
        hideTyping();
        box.appendChild(bubble(m));
        if (m.mine || stick) scrollBottom();
    }

    async function fetchMessages() {
        const res = await fetch(listUrl, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) return null;
        const data = await res.json();
        return data.messages || [];
    }

    // ---- Riwayat awal (REST) ----------------------------------------------
    async function loadHistory() {
        try {
            const messages = await fetchMessages();
            if (messages === null) return;
            if (loading) loading.remove();
            if (!messages.length) {
                box.innerHTML = '<div id="chatEmpty" class="text-center text-xs text-gray-400 py-10">Belum ada pesan. Mulai percakapan 👋</div>';
                return;
            }
            box.innerHTML = '';
            messages.forEach((m) => {
                shown.add(String(m.id));
                box.appendChild(bubble(m));
            });
            scrollBottom();
        } catch (e) { /* diam */ }
    }

    // ---- Cadangan: polling saat WebSocket tidak tersambung -----------------
    const realtimeConnected = () =>
        window.Echo?.connector?.pusher?.connection?.state === 'connected';

    setInterval(async () => {
        if (document.hidden || realtimeConnected()) return;
        try {
            const messages = await fetchMessages();
            (messages || []).forEach((m) => appendMessage(m));
        } catch (e) { /* coba lagi pada putaran berikutnya */ }
    }, 4000);

    // ---- Indikator mengetik -----------------------------------------------
    let typingEl = null, typingHideTimer = null;
    function showTyping() {
        if (!typingEl) {
            typingEl = document.createElement('div');
            typingEl.className = 'flex items-end gap-2 justify-start';
            typingEl.innerHTML =
                '<img src="' + partnerAvatar + '" class="w-7 h-7 rounded-full object-cover shrink-0" alt="">' +
                '<div class="fm-typing"><span></span><span></span><span></span></div>';
        }
        const stick = nearBottom();
        box.appendChild(typingEl);
        if (stick) scrollBottom();
        clearTimeout(typingHideTimer);
        typingHideTimer = setTimeout(hideTyping, 2000); // sembunyikan setelah 2 dtk hening
    }
    function hideTyping() {
        clearTimeout(typingHideTimer);
        if (typingEl && typingEl.parentNode) typingEl.parentNode.removeChild(typingEl);
    }

    // ---- WebSocket (Echo + Reverb) ----------------------------------------
    if (window.Echo && bookingId) {
        const channel = window.Echo.private('booking.' + bookingId);

        channel.listen('.message.sent', (e) => {
            // Lewati bila ini pesan kita sendiri (jaga-jaga bila X-Socket-ID tak terkirim).
            if (String(e.sender_id) === String(meId)) return;
            appendMessage({ id: e.id, message: e.message, mine: false, time: e.time });
        });

        // Lawan bicara mengetik → tampilkan animasi.
        channel.listenForWhisper('typing', () => showTyping());
    }

    // ---- Kirim typing whisper (throttle ~1 dtk) ---------------------------
    let lastWhisper = 0;
    input.addEventListener('input', () => {
        const now = Date.now();
        if (window.Echo && bookingId && now - lastWhisper > 900) {
            lastWhisper = now;
            window.Echo.private('booking.' + bookingId).whisper('typing', {});
        }
    });

    // ---- Kirim pesan (AJAX, tanpa reload) ---------------------------------
    async function sendMessage(ev) {
        ev.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        sendBtn.disabled = true;
        try {
            const body = new FormData();
            body.append('message', text);
            if (csrf) body.append('_token', csrf);

            const headers = {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };
            // Agar broadcast ->toOthers() tidak mengirim balik ke diri sendiri.
            if (window.Echo && window.Echo.socketId()) headers['X-Socket-ID'] = window.Echo.socketId();

            const res = await fetch(form.action, { method: 'POST', headers, body });
            if (res.ok) {
                let payload = null;
                try { payload = await res.json(); } catch (e) {}
                input.value = '';
                appendMessage(payload && payload.message
                    ? payload
                    : { message: text, mine: true, time: '' });
            }
        } catch (e) { /* biarkan teks tetap ada untuk kirim ulang */ }
        finally {
            sendBtn.disabled = false;
            input.focus();
        }
    }

    form.addEventListener('submit', sendMessage);
    loadHistory();
})();
</script>
