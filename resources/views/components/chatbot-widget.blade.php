{{-- ============================================================
     CHATBOT WIDGET — LaptopExpert AI
     Komponen floating chatbot berbasis basis pengetahuan laptop
     ============================================================ --}}

<div id="chatbot-wrapper" class="chatbot-wrapper" aria-live="polite">

    {{-- Floating Toggle Button --}}
    <button id="chatbot-toggle"
            class="chatbot-toggle-btn"
            aria-label="Buka Chatbot"
            title="Chat dengan LaptopBot">
        {{-- Icon chat (default) --}}
        <span id="chatbot-icon-open">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
        </span>
        {{-- Icon close --}}
        <span id="chatbot-icon-close" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </span>
        {{-- Notification dot (jika belum dibuka) --}}
        <span id="chatbot-notif-dot" class="chatbot-notif-dot"></span>
    </button>

    {{-- Chat Window --}}
    <div id="chatbot-window" class="chatbot-window" style="display:none;" role="dialog" aria-label="LaptopBot Chat">

        {{-- Header --}}
        <div class="chatbot-header">
            <div class="flex items-center gap-3">
                <div class="chatbot-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="12" x="3" y="4" rx="2"/><line x1="2" x2="22" y1="20" y2="20"/>
                    </svg>
                </div>
                <div>
                    <div class="chatbot-header-name">LaptopBot</div>
                    <div class="chatbot-header-status">
                        <span class="chatbot-status-dot"></span> Online · Basis Pengetahuan Aktif
                    </div>
                </div>
            </div>
            <button id="chatbot-close-btn" class="chatbot-close-btn" aria-label="Tutup chatbot">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Messages Area --}}
        <div id="chatbot-messages" class="chatbot-messages">
            {{-- Welcome message (pre-rendered) --}}
            <div class="chatbot-msg bot-msg" data-id="welcome">
                <div class="chatbot-bubble bot-bubble">
                    <p>Halo! 👋 Saya <strong>LaptopBot</strong>, asisten virtual untuk kerusakan laptop.</p>
                    <p style="margin-top:6px;">Ceritakan gejala laptop kamu, atau pilih topik di bawah!</p>
                </div>
                <div class="chatbot-quick-btns" id="welcome-quick-btns">
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah layar lcd')">🖥️ Layar / LCD</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah keyboard')">⌨️ Keyboard</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah ram memory')">🧠 RAM</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah charger')">🔌 Charger</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah harddisk ssd')">💾 Harddisk</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah touchpad mouse')">🖱️ Touchpad</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('laptop panas overheat kipas')">🌀 Kipas / Panas</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah webcam kamera')">📷 Webcam</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah baterai')">🔋 Baterai</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah motherboard')">🔧 Motherboard</button>
                    <button class="chatbot-quick-btn" onclick="chatbotSendText('masalah suara speaker audio')">🔊 Speaker</button>
                    <button class="chatbot-quick-btn chatbot-quick-btn--admin" onclick="chatbotOpenAdmin()">💬 Hubungi Admin</button>
                </div>
            </div>
        </div>

        {{-- Typing indicator (hidden by default) --}}
        <div id="chatbot-typing" class="chatbot-typing-wrap" style="display:none;">
            <div class="chatbot-typing-indicator">
                <span></span><span></span><span></span>
            </div>
            <span class="chatbot-typing-text">LaptopBot sedang mengetik…</span>
        </div>

        {{-- Input Area --}}
        <div class="chatbot-input-area">
            <input id="chatbot-input"
                   type="text"
                   class="chatbot-input"
                   placeholder="Ketik keluhan laptop kamu…"
                   maxlength="500"
                   autocomplete="off"
                   aria-label="Pesan ke chatbot" />
            <button id="chatbot-send-btn" class="chatbot-send-btn" aria-label="Kirim pesan">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                </svg>
            </button>
        </div>

        {{-- Footer --}}
        <div class="chatbot-footer">
            <span>Powered by <strong>Basis Pengetahuan Sistem Pakar</strong></span>
            <a href="{{ route('diagnosa.form') }}" class="chatbot-footer-link">🔍 Diagnosa Lengkap</a>
        </div>
    </div>
</div>

{{-- ===== STYLES ===== --}}
<style>
/* ---- Wrapper ---- */
.chatbot-wrapper {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    font-family: 'Inter', 'Outfit', system-ui, sans-serif;
}

/* ---- Toggle Button ---- */
.chatbot-toggle-btn {
    position: relative;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 32px rgba(79, 70, 229, 0.5), 0 2px 8px rgba(0,0,0,0.3);
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    animation: chatbot-bounce 2s ease-in-out 2s 3;
}
.chatbot-toggle-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 12px 40px rgba(79, 70, 229, 0.65), 0 4px 12px rgba(0,0,0,0.4);
}
@keyframes chatbot-bounce {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-8px); }
}

/* ---- Notification Dot ---- */
.chatbot-notif-dot {
    position: absolute;
    top: 4px; right: 4px;
    width: 12px; height: 12px;
    border-radius: 50%;
    background: #22c55e;
    border: 2px solid #0f172a;
    animation: chatbot-pulse 1.5s infinite;
}
@keyframes chatbot-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.7; transform: scale(1.25); }
}

/* ---- Chat Window ---- */
.chatbot-window {
    position: absolute;
    bottom: 72px;
    right: 0;
    width: 370px;
    max-height: 600px;
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 24px 64px rgba(0,0,0,0.5), 0 0 0 1px rgba(99,102,241,0.25);
    background: #0f172a;
    border: 1px solid rgba(99,102,241,0.2);
    animation: chatbot-slide-up 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    transform-origin: bottom right;
}
@keyframes chatbot-slide-up {
    from { opacity: 0; transform: scale(0.85) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* ---- Header ---- */
.chatbot-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    background: linear-gradient(135deg, rgba(79,70,229,0.3), rgba(124,58,237,0.3));
    border-bottom: 1px solid rgba(99,102,241,0.2);
    flex-shrink: 0;
}
.chatbot-avatar {
    width: 38px; height: 38px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    flex-shrink: 0;
}
.chatbot-header-name {
    font-weight: 700;
    font-size: 14px;
    color: #fff;
    line-height: 1.2;
}
.chatbot-header-status {
    font-size: 11px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 1px;
}
.chatbot-status-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #22c55e;
    display: inline-block;
    animation: chatbot-pulse 1.5s infinite;
}
.chatbot-close-btn {
    background: rgba(255,255,255,0.07);
    border: none;
    border-radius: 8px;
    padding: 5px;
    cursor: pointer;
    color: #94a3b8;
    transition: background 0.2s, color 0.2s;
    display: flex; align-items: center; justify-content: center;
}
.chatbot-close-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }

/* ---- Messages ---- */
.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px 14px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    scroll-behavior: smooth;
}
.chatbot-messages::-webkit-scrollbar { width: 4px; }
.chatbot-messages::-webkit-scrollbar-track { background: transparent; }
.chatbot-messages::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 99px; }

.chatbot-msg { display: flex; flex-direction: column; }
.bot-msg { align-items: flex-start; }
.user-msg { align-items: flex-end; }

.chatbot-bubble {
    max-width: 96%;
    padding: 11px 14px;
    border-radius: 16px;
    font-size: 13px;
    line-height: 1.65;
    word-break: break-word;
}
.bot-bubble {
    background: rgba(20,30,50,0.97);
    color: #e2e8f0;
    border: 1px solid rgba(99,102,241,0.2);
    border-bottom-left-radius: 4px;
}
.bot-bubble strong { color: #a5b4fc; font-weight: 700; }
.bot-bubble em { color: #94a3b8; font-style: italic; }
.user-bubble {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    border-bottom-right-radius: 4px;
}
/* Markdown formatted content */
.cb-p { margin: 0 0 3px; }
.cb-p:last-child { margin-bottom: 0; }
.cb-spacer { height: 6px; }
.cb-ol, .cb-ul {
    margin: 3px 0 3px 16px;
    padding: 0;
}
.cb-ol { list-style: decimal; }
.cb-ul { list-style: disc; }
.cb-ol li, .cb-ul li {
    margin-bottom: 3px;
    line-height: 1.55;
    color: #cbd5e1;
}
.cb-ol li strong, .cb-ul li strong { color: #a5b4fc; }

/* ---- Quick Buttons ---- */
.chatbot-quick-btns {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 8px;
    max-width: 300px;
}
.chatbot-quick-btn {
    background: rgba(79,70,229,0.15);
    border: 1px solid rgba(99,102,241,0.3);
    color: #a5b4fc;
    font-size: 11.5px;
    padding: 5px 10px;
    border-radius: 20px;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
    white-space: nowrap;
}
.chatbot-quick-btn:hover {
    background: rgba(79,70,229,0.35);
    color: #fff;
    border-color: rgba(99,102,241,0.6);
}
.chatbot-quick-btn--admin {
    background: rgba(34,197,94,0.12);
    border-color: rgba(34,197,94,0.3);
    color: #4ade80;
}
.chatbot-quick-btn--admin:hover {
    background: rgba(34,197,94,0.28);
    color: #fff;
}
.chatbot-quick-btn--link {
    background: rgba(236,72,153,0.12);
    border-color: rgba(236,72,153,0.3);
    color: #f9a8d4;
}
.chatbot-quick-btn--link:hover {
    background: rgba(236,72,153,0.28);
    color: #fff;
}

/* ---- Typing Indicator ---- */
.chatbot-typing-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    flex-shrink: 0;
}
.chatbot-typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    background: rgba(30,41,59,0.9);
    border: 1px solid rgba(99,102,241,0.15);
    border-radius: 12px;
    padding: 7px 12px;
}
.chatbot-typing-indicator span {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #6366f1;
    animation: chatbot-typing-dot 1.2s infinite;
}
.chatbot-typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.chatbot-typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
@keyframes chatbot-typing-dot {
    0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
    40%            { transform: scale(1); opacity: 1; }
}
.chatbot-typing-text { font-size: 11px; color: #64748b; }

/* ---- Input Area ---- */
.chatbot-input-area {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 12px 10px;
    border-top: 1px solid rgba(99,102,241,0.15);
    background: rgba(15,23,42,0.95);
    flex-shrink: 0;
}
.chatbot-input {
    flex: 1;
    background: rgba(30,41,59,0.8);
    border: 1px solid rgba(99,102,241,0.25);
    border-radius: 12px;
    padding: 9px 13px;
    font-size: 13px;
    color: #e2e8f0;
    outline: none;
    transition: border-color 0.2s;
}
.chatbot-input::placeholder { color: #475569; }
.chatbot-input:focus { border-color: rgba(99,102,241,0.6); }
.chatbot-send-btn {
    width: 38px; height: 38px;
    border-radius: 11px;
    border: none;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: white;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    transition: opacity 0.2s, transform 0.15s;
    flex-shrink: 0;
}
.chatbot-send-btn:hover { opacity: 0.88; transform: scale(1.05); }
.chatbot-send-btn:disabled { opacity: 0.4; cursor: not-allowed; transform: none; }

/* ---- Footer ---- */
.chatbot-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 14px 8px;
    font-size: 10.5px;
    color: #475569;
    background: rgba(15,23,42,0.95);
    flex-shrink: 0;
}
.chatbot-footer-link {
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.chatbot-footer-link:hover { color: #a5b4fc; }

/* ---- Admin Modal Overlay ---- */
.chatbot-admin-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 10000;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 20px;
    animation: chatbot-fade-in 0.2s ease;
}
@keyframes chatbot-fade-in { from { opacity: 0; } to { opacity: 1; } }
.chatbot-admin-card {
    width: 100%;
    max-width: 400px;
    background: #0f172a;
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 20px;
    padding: 24px;
    animation: chatbot-slide-up 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.chatbot-admin-card h3 {
    font-size: 17px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
}
.chatbot-admin-card p { font-size: 13px; color: #94a3b8; margin-bottom: 18px; }
.chatbot-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 13px;
    border-radius: 12px;
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: white;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.15s;
    border: none;
    cursor: pointer;
}
.chatbot-wa-btn:hover { opacity: 0.9; transform: translateY(-1px); }
.chatbot-admin-cancel {
    display: block;
    text-align: center;
    margin-top: 12px;
    font-size: 13px;
    color: #64748b;
    cursor: pointer;
    transition: color 0.2s;
    background: none;
    border: none;
    width: 100%;
}
.chatbot-admin-cancel:hover { color: #94a3b8; }

/* ---- Responsive ---- */
@media (max-width: 480px) {
    .chatbot-wrapper { bottom: 16px; right: 16px; }
    .chatbot-window { width: calc(100vw - 32px); right: -16px; bottom: 68px; }
}
</style>

{{-- ===== SCRIPTS ===== --}}
<script>
(function () {
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const REPLY_URL   = '{{ route("chatbot.reply") }}';
    const ADMIN_URL   = '{{ route("chatbot.admin") }}';

    const $toggle  = document.getElementById('chatbot-toggle');
    const $window  = document.getElementById('chatbot-window');
    const $closeBtn= document.getElementById('chatbot-close-btn');
    const $msgs    = document.getElementById('chatbot-messages');
    const $input   = document.getElementById('chatbot-input');
    const $sendBtn = document.getElementById('chatbot-send-btn');
    const $typing  = document.getElementById('chatbot-typing');
    const $iconOpen= document.getElementById('chatbot-icon-open');
    const $iconClose=document.getElementById('chatbot-icon-close');
    const $notifDot= document.getElementById('chatbot-notif-dot');

    let isOpen = false;

    /* ---- Toggle Window ---- */
    function openChat() {
        isOpen = true;
        $window.style.display = 'flex';
        $window.style.flexDirection = 'column';
        $iconOpen.style.display = 'none';
        $iconClose.style.display = 'block';
        $notifDot.style.display = 'none';
        $input.focus();
        scrollToBottom();
    }
    function closeChat() {
        isOpen = false;
        $window.style.display = 'none';
        $iconOpen.style.display = 'block';
        $iconClose.style.display = 'none';
    }

    $toggle.addEventListener('click', () => isOpen ? closeChat() : openChat());
    $closeBtn.addEventListener('click', closeChat);

    /* ---- Keyboard Send ---- */
    $input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });
    $sendBtn.addEventListener('click', sendMessage);

    /* ---- Send Message ---- */
    async function sendMessage() {
        const text = $input.value.trim();
        if (!text) return;

        $input.value = '';
        $sendBtn.disabled = true;

        appendUserBubble(text);
        showTyping();

        try {
            const res  = await fetch(REPLY_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await res.json();

            // Simulated typing delay (300-700ms)
            await delay(350 + Math.random() * 350);
            hideTyping();

            if (data.success) {
                appendBotBubble(data.message, data.buttons || []);
            } else {
                appendBotBubble('Terjadi kesalahan. Silakan coba lagi.', []);
            }
        } catch (err) {
            hideTyping();
            appendBotBubble('Koneksi bermasalah. Pastikan internet kamu aktif.', []);
        }

        $sendBtn.disabled = false;
        $input.focus();
    }

    /* ---- Append Bubbles ---- */
    function appendUserBubble(text) {
        const wrap = document.createElement('div');
        wrap.className = 'chatbot-msg user-msg';
        const bubble = document.createElement('div');
        bubble.className = 'chatbot-bubble user-bubble';
        bubble.textContent = text;
        wrap.appendChild(bubble);
        $msgs.appendChild(wrap);
        scrollToBottom();
    }

    function appendBotBubble(markdown, buttons) {
        const wrap = document.createElement('div');
        wrap.className = 'chatbot-msg bot-msg';

        const bubble = document.createElement('div');
        bubble.className = 'chatbot-bubble bot-bubble';
        bubble.innerHTML = renderMarkdown(markdown);
        wrap.appendChild(bubble);

        if (buttons && buttons.length > 0) {
            const btnWrap = document.createElement('div');
            btnWrap.className = 'chatbot-quick-btns';
            buttons.forEach(btn => {
                const b = document.createElement('button');
                b.className = 'chatbot-quick-btn' + (
                    btn.action === 'admin' ? ' chatbot-quick-btn--admin' :
                    btn.action === 'link'  ? ' chatbot-quick-btn--link'  : ''
                );
                b.textContent = btn.label;
                if (btn.action === 'send') {
                    b.onclick = () => chatbotSendText(btn.text);
                } else if (btn.action === 'link') {
                    b.onclick = () => window.location.href = btn.url;
                } else if (btn.action === 'admin') {
                    b.onclick = () => chatbotOpenAdmin();
                }
                btnWrap.appendChild(b);
            });
            wrap.appendChild(btnWrap);
        }

        $msgs.appendChild(wrap);
        scrollToBottom();
    }

    /* ---- Enhanced Markdown Renderer ---- */
    function renderMarkdown(text) {
        // Escape HTML dulu
        let html = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // Bold & italic
        html = html
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/(?<!\*)_(.+?)_(?!\*)/g, '<em>$1</em>');

        // Proses baris per baris
        const lines = html.split('\n');
        const result = [];
        let inNumberedList = false;
        let inBulletList   = false;

        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            const trimmed = line.trim();

            // Numbered list: "1. ", "2. ", dst
            const numMatch = trimmed.match(/^(\d+)\. (.+)$/);
            if (numMatch) {
                if (!inNumberedList) {
                    result.push('<ol class="cb-ol">');
                    inNumberedList = true;
                }
                if (inBulletList) { result.push('</ul>'); inBulletList = false; }
                result.push(`<li>${numMatch[2]}</li>`);
                continue;
            }

            // Bullet list: "• " atau "- "
            const bulletMatch = trimmed.match(/^[•\-\*] (.+)$/);
            if (bulletMatch) {
                if (!inBulletList) {
                    result.push('<ul class="cb-ul">');
                    inBulletList = true;
                }
                if (inNumberedList) { result.push('</ol>'); inNumberedList = false; }
                result.push(`<li>${bulletMatch[1]}</li>`);
                continue;
            }

            // Tutup list jika baris kosong
            if (trimmed === '') {
                if (inNumberedList) { result.push('</ol>'); inNumberedList = false; }
                if (inBulletList)   { result.push('</ul>'); inBulletList   = false; }
                result.push('<div class="cb-spacer"></div>');
                continue;
            }

            // Tutup list sebelum baris biasa
            if (inNumberedList) { result.push('</ol>'); inNumberedList = false; }
            if (inBulletList)   { result.push('</ul>'); inBulletList   = false; }

            result.push(`<p class="cb-p">${trimmed}</p>`);
        }

        // Tutup list yang masih terbuka
        if (inNumberedList) result.push('</ol>');
        if (inBulletList)   result.push('</ul>');

        return result.join('');
    }

    /* ---- Typing Indicator ---- */
    function showTyping() { $typing.style.display = 'flex'; scrollToBottom(); }
    function hideTyping()  { $typing.style.display = 'none'; }

    /* ---- Scroll Bottom ---- */
    function scrollToBottom() {
        setTimeout(() => { $msgs.scrollTop = $msgs.scrollHeight; }, 50);
    }

    /* ---- Delay helper ---- */
    function delay(ms) { return new Promise(r => setTimeout(r, ms)); }

    /* ============================================================
       PUBLIC FUNCTIONS (dipakai di HTML onclick)
       ============================================================ */
    window.chatbotSendText = function (text) {
        if (!isOpen) openChat();
        $input.value = text;
        sendMessage();
    };

    window.chatbotOpenAdmin = async function () {
        // Ambil info kontak admin dari server
        let waUrl = '#';
        let adminName = 'Admin LaptopExpert';
        try {
            const res  = await fetch(ADMIN_URL);
            const data = await res.json();
            if (data.success) {
                waUrl     = data.wa_url;
                adminName = data.admin_name;
            }
        } catch (_) {}

        // Hapus overlay lama jika ada
        document.getElementById('chatbot-admin-overlay')?.remove();

        const overlay = document.createElement('div');
        overlay.id        = 'chatbot-admin-overlay';
        overlay.className = 'chatbot-admin-overlay';
        overlay.innerHTML = `
            <div class="chatbot-admin-card" role="dialog" aria-modal="true" aria-label="Hubungi Admin">
                <h3>💬 Chat dengan Admin</h3>
                <p>
                    Kamu akan diarahkan ke WhatsApp untuk berkonsultasi langsung dengan
                    <strong style="color:#a5b4fc">${adminName}</strong> mengenai kerusakan laptop kamu.
                </p>
                <a href="${waUrl}" target="_blank" rel="noopener noreferrer" class="chatbot-wa-btn"
                   onclick="document.getElementById('chatbot-admin-overlay').remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.115.549 4.099 1.51 5.826L.057 23.571 6 22.105A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.846 0-3.575-.493-5.072-1.355l-.359-.214-3.749.984.999-3.648-.235-.374A9.934 9.934 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                    </svg>
                    Buka WhatsApp
                </a>
                <button class="chatbot-admin-cancel" onclick="document.getElementById('chatbot-admin-overlay').remove()">
                    Tutup
                </button>
            </div>`;

        // Tutup jika klik backdrop
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.remove();
        });
        document.body.appendChild(overlay);
    };

})();
</script>
