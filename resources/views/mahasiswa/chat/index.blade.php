@extends('layouts.mahasiswa')

@section('title', 'Chat Kelas - CampusLMS')
@section('page-title', 'Chat Kelas')

@section('content')
<div class="flex flex-col lg:flex-row gap-6 min-h-[calc(100vh-10rem)]">
    {{-- Sidebar / class list --}}
    <div class="w-full lg:w-64 flex-shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden lg:sticky lg:top-0">
            <div class="p-3 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Daftar Kelas</h3>
            </div>
            <div class="divide-y divide-gray-100 lg:max-h-[70vh] lg:overflow-y-auto">
                @foreach($classes as $c)
                    <a href="{{ route('mahasiswa.chat.class', $c) }}"
                       class="flex items-center gap-3 px-3 py-3 hover:bg-gray-50 transition-colors {{ isset($class) && $class->id === $c->id ? 'bg-blue-50 border-l-2 border-l-blue-500' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($c->name, 0, 2) }}</div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $c->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $c->dosen?->name ?? '' }}</p>
                        </div>
                        @if(isset($class) && $class->id === $c->id)
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Chat area --}}
    <div class="flex-1 min-w-0 flex flex-col">
        @if(isset($class))
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col flex-1">
                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                    <h3 class="font-semibold text-gray-800">{{ $class->name }}</h3>
                    <p class="text-xs text-gray-500">Diskusi kelas</p>
                </div>

                <div id="chat-messages" class="flex-1 p-4 space-y-3 overflow-y-auto min-h-[40vh] max-h-[55vh] lg:max-h-none">
                    @forelse($messages as $msg)
                        <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] lg:max-w-[70%] {{ $msg->user_id === auth()->id() ? 'bg-blue-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md' }} px-4 py-2.5">
                                @if($msg->user_id !== auth()->id())
                                    <p class="text-xs font-medium {{ $msg->user->role === 'dosen' ? 'text-emerald-600' : 'text-blue-600' }} mb-0.5">{{ $msg->user->name }}</p>
                                @endif
                                <p class="text-sm leading-relaxed break-words">{{ $msg->message }}</p>
                                <p class="text-xs mt-1 {{ $msg->user_id === auth()->id() ? 'text-blue-200' : 'text-gray-400' }}">{{ $msg->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 text-sm py-8">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <p>Belum ada pesan. Mulai diskusi!</p>
                        </div>
                    @endforelse
                </div>

                <form id="chat-form" class="px-4 py-3 border-t border-gray-100 bg-white flex-shrink-0">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="message" id="chat-input" autocomplete="off" required
                               class="flex-1 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ketik pesan...">
                        <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span class="hidden sm:inline">Kirim</span>
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="flex-1 flex items-center justify-center text-gray-400 bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="text-center p-8">
                    <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <p class="text-sm">Pilih kelas dari daftar di samping</p>
                </div>
            </div>
        @endif
    </div>
</div>

@if(isset($class))
@push('scripts')
<script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const userId = {{ auth()->id() }};
    const classId = {{ $class->id }};
    let lastId = {{ $messages->last()?->id ?? 0 }};

    function csrf() { return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'); }
    function jsonHeaders() { return { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() }; }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;
        chatInput.value = '';
        chatInput.disabled = true;
        try {
            const res = await fetch('{{ route("mahasiswa.chat.send", $class) }}', {
                method: 'POST', headers: jsonHeaders(),
                body: JSON.stringify({ message: msg }),
            });
            if (!res.ok) throw new Error();
            const data = await res.json();
            appendMessage(data.message, true);
            lastId = data.message.id;
        } catch (e) { chatInput.value = msg; }
        chatInput.disabled = false;
        chatInput.focus();
    });

    function appendMessage(msg, isSelf) {
        const d = document.createElement('div');
        d.id = 'msg-' + msg.id;
        d.className = 'flex ' + (isSelf ? 'justify-end' : 'justify-start');
        const time = new Date(msg.created_at || Date.now()).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
        const text = escHtml(msg.message);
        d.innerHTML = `<div class="max-w-[85%] lg:max-w-[70%] ${isSelf ? 'bg-blue-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md'} px-4 py-2.5">${!isSelf ? `<p class="text-xs font-medium ${msg.user?.role === 'dosen' ? 'text-emerald-600' : 'text-blue-600'} mb-0.5">${msg.user?.name || ''}</p>` : ''}<p class="text-sm leading-relaxed break-words msg-text">${text}</p><div class="flex items-center justify-between mt-1"><span class="text-xs ${isSelf ? 'text-blue-200' : 'text-gray-400'}">${time}</span>${isSelf ? `<div class="flex gap-2">` +
            `<button onclick="editMessage(${msg.id})" class="text-xs ${isSelf ? 'text-blue-200 hover:text-white' : 'text-gray-400 hover:text-gray-600'}">Edit</button>` +
            `<button onclick="deleteMessage(${msg.id})" class="text-xs ${isSelf ? 'text-blue-200 hover:text-white' : 'text-gray-400 hover:text-gray-600'}">Hapus</button>` +
        `</div>` : ''}</div></div>`;
        chatMessages.appendChild(d);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    window.editMessage = async (id) => {
        const el = document.getElementById('msg-' + id);
        const textEl = el.querySelector('.msg-text');
        const current = textEl.textContent;
        const newText = prompt('Edit pesan:', current);
        if (!newText || newText.trim() === current.trim()) return;
        try {
            const res = await fetch('/mahasiswa/chat/' + classId + '/message/' + id + '/edit', {
                method: 'POST', headers: jsonHeaders(),
                body: JSON.stringify({ message: newText.trim() }),
            });
            if (!res.ok) throw new Error();
            textEl.textContent = newText.trim();
        } catch (e) { alert('Gagal mengedit pesan'); }
    };

    window.deleteMessage = async (id) => {
        if (!confirm('Hapus pesan ini?')) return;
        try {
            const res = await fetch('/mahasiswa/chat/' + classId + '/message/' + id + '/delete', {
                method: 'POST', headers: jsonHeaders(),
            });
            if (!res.ok) throw new Error();
            const el = document.getElementById('msg-' + id);
            el.style.transition = 'opacity 0.3s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        } catch (e) { alert('Gagal menghapus pesan'); }
    };

    function escHtml(s) { const d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

    setInterval(async () => {
        try {
            const res = await fetch('{{ route("mahasiswa.chat.messages", $class) }}?after=' + lastId, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            data.messages.forEach(msg => { if (!document.getElementById('msg-' + msg.id)) { appendMessage(msg, msg.user_id === userId); } lastId = msg.id; });
        } catch (e) {}
    }, 3000);
    chatMessages.scrollTop = chatMessages.scrollHeight;
</script>
@endpush
@endif
@endsection
