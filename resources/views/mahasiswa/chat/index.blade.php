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
                        <div id="msg-{{ $msg->id }}" class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] lg:max-w-[70%] {{ $msg->user_id === auth()->id() ? 'bg-blue-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md' }} px-4 py-2.5">
                                @if($msg->user_id !== auth()->id())
                                    <p class="text-xs font-medium {{ $msg->user->role === 'dosen' ? 'text-emerald-600' : 'text-blue-600' }} mb-0.5">{{ $msg->user->name }}</p>
                                @endif
                                <div class="msg-view">
                                    <p class="text-sm leading-relaxed break-words msg-text">{{ $msg->message }}</p>
                                    <div class="flex items-center justify-between mt-1">
                                        <span class="text-xs {{ $msg->user_id === auth()->id() ? 'text-blue-200' : 'text-gray-400' }}">{{ $msg->created_at->format('H:i') }}</span>
                                        @if($msg->user_id === auth()->id())
                                            <div class="flex gap-2">
                                                <button onclick="editMessage({{ $msg->id }})" class="text-xs {{ $msg->user_id === auth()->id() ? 'text-blue-200 hover:text-white' : 'text-gray-400 hover:text-gray-600' }}">Edit</button>
                                                <button onclick="showDeleteModal({{ $msg->id }})" class="text-xs {{ $msg->user_id === auth()->id() ? 'text-blue-200 hover:text-white' : 'text-gray-400 hover:text-gray-600' }}">Hapus</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="msg-edit hidden">
                                    <textarea class="edit-input w-full text-sm bg-white/20 rounded-lg p-2 text-white resize-none" rows="2">{{ $msg->message }}</textarea>
                                    <div class="flex gap-2 mt-2">
                                        <button onclick="saveEdit({{ $msg->id }})" class="text-xs px-2 py-1 bg-white text-blue-600 rounded-lg font-medium">Simpan</button>
                                        <button onclick="cancelEdit({{ $msg->id }})" class="text-xs px-2 py-1 bg-white/20 text-white rounded-lg">Batal</button>
                                    </div>
                                </div>
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

@push('styles')
<style>
    .animate-slide-in { animation: slideIn 0.3s ease-out; }
    @@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>
@endpush

@if(isset($class))
{{-- Delete Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50" onclick="closeDeleteModal(event)">
    <div class="bg-white rounded-xl shadow-lg max-w-xs w-full mx-3 p-5 text-center" onclick="event.stopPropagation()">
        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-red-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <h3 class="text-base font-bold text-gray-800 mb-1">Hapus Pesan?</h3>
        <p class="text-xs text-gray-500 mb-4">Pesan akan dihapus permanen.</p>
        <input type="hidden" id="deleteId" value="">
        <div class="flex gap-2">
            <button onclick="closeDeleteModal()" class="flex-1 px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all">Batal</button>
            <button onclick="confirmDelete()" class="flex-1 px-3 py-2 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white text-sm font-medium rounded-lg transition-all shadow-sm">Hapus</button>
        </div>
    </div>
</div>

{{-- Toast Container --}}
<div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

@push('scripts')
<script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const userId = {{ auth()->id() }};
    const classId = {{ $class->id }};
    const editRoute = '{{ route("mahasiswa.chat.update", ["class" => $class, "message" => "MSGID"]) }}';
    const deleteRoute = '{{ route("mahasiswa.chat.delete", ["class" => $class, "message" => "MSGID"]) }}';
    let lastId = {{ $messages->last()?->id ?? 0 }};

    function csrf() { return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'); }
    function jsonHeaders() { return { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf() }; }

    function toast(msg, type = 'success') {
        const c = document.getElementById('toast-container');
        const t = document.createElement('div');
        const colors = { success: 'bg-emerald-500', error: 'bg-red-500', info: 'bg-blue-500' };
        t.className = `${colors[type] || colors.info} text-white text-xs font-medium px-3 py-2 rounded-lg shadow-lg flex items-center gap-1.5 animate-slide-in`;
        t.innerHTML = `<span>${msg}</span>`;
        c.appendChild(t);
        setTimeout(() => { t.style.transition = 'all 0.3s'; t.style.opacity = '0'; t.style.transform = 'translateX(100%)'; setTimeout(() => t.remove(), 300); }, 2000);
    }

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
        } catch (e) { chatInput.value = msg; toast('Gagal mengirim pesan', 'error'); }
        chatInput.disabled = false;
        chatInput.focus();
    });

    function appendMessage(msg, isSelf) {
        if (document.getElementById('msg-' + msg.id)) return;
        const d = document.createElement('div');
        d.id = 'msg-' + msg.id;
        d.className = 'flex ' + (isSelf ? 'justify-end' : 'justify-start');
        const time = new Date(msg.created_at || Date.now()).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
        const text = escHtml(msg.message);
        d.innerHTML = `<div class="max-w-[85%] lg:max-w-[70%] ${isSelf ? 'bg-blue-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md'} px-4 py-2.5">${!isSelf ? `<p class="text-xs font-medium ${msg.user?.role === 'dosen' ? 'text-emerald-600' : 'text-blue-600'} mb-0.5">${msg.user?.name || ''}</p>` : ''}<div class="msg-view"><p class="text-sm leading-relaxed break-words msg-text">${text}</p><div class="flex items-center justify-between mt-1"><span class="text-xs ${isSelf ? 'text-blue-200' : 'text-gray-400'}">${time}</span>${isSelf ? `<div class="flex gap-2"><button onclick="editMessage(${msg.id})" class="text-xs text-blue-200 hover:text-white">Edit</button><button onclick="showDeleteModal(${msg.id})" class="text-xs text-blue-200 hover:text-white">Hapus</button></div>` : ''}</div></div><div class="msg-edit hidden"><textarea class="edit-input w-full text-sm bg-white/20 rounded-lg p-2 text-white resize-none" rows="2">${text}</textarea><div class="flex gap-2 mt-2"><button onclick="saveEdit(${msg.id})" class="text-xs px-2 py-1 bg-white text-blue-600 rounded-lg font-medium">Simpan</button><button onclick="cancelEdit(${msg.id})" class="text-xs px-2 py-1 bg-white/20 text-white rounded-lg">Batal</button></div></div></div>`;
        chatMessages.appendChild(d);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    window.editMessage = (id) => {
        const el = document.getElementById('msg-' + id);
        el.querySelector('.msg-view').classList.add('hidden');
        el.querySelector('.msg-edit').classList.remove('hidden');
        el.querySelector('.edit-input').focus();
    };

    window.saveEdit = async (id) => {
        const el = document.getElementById('msg-' + id);
        const input = el.querySelector('.edit-input');
        const newText = input.value.trim();
        if (!newText) return;
        try {
            const res = await fetch(editRoute.replace('MSGID', id), {
                method: 'POST', headers: jsonHeaders(),
                body: JSON.stringify({ message: newText }),
            });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            toast('Pesan diedit');
            location.reload();
        } catch (e) { toast(e.message || 'Gagal!', 'error'); }
    };

    window.cancelEdit = (id) => {
        const el = document.getElementById('msg-' + id);
        el.querySelector('.edit-input').value = el.querySelector('.msg-text').textContent;
        el.querySelector('.msg-view').classList.remove('hidden');
        el.querySelector('.msg-edit').classList.add('hidden');
    };

    window.showDeleteModal = (id) => {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    };

    window.closeDeleteModal = (e) => {
        if (e && e.target !== e.currentTarget) return;
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    };

    window.confirmDelete = async () => {
        const id = document.getElementById('deleteId').value;
        closeDeleteModal();
        try {
            const res = await fetch(deleteRoute.replace('MSGID', id), {
                method: 'POST', headers: jsonHeaders(),
            });
            if (!res.ok) throw new Error();
            toast('Pesan dihapus');
            location.reload();
        } catch (e) { toast('Gagal hapus!', 'error'); }
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
