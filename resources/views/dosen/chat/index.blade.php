@extends('layouts.dosen')

@section('title', 'Chat Kelas - CampusLMS')
@section('page-title', 'Chat Kelas')

@section('content')
@if(isset($class))
    <div class="lg:hidden mb-3">
        <select onchange="window.location.href=this.value" class="w-full rounded-xl border-gray-200 text-sm focus:border-emerald-500 focus:ring-emerald-500">
            @foreach($classes as $c)
                <option value="{{ route('dosen.chat.class', $c) }}" {{ $class->id === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-6">
        <div class="hidden lg:block w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-4">
                <div class="p-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800">Kelas Saya</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @foreach($classes as $c)
                        <a href="{{ route('dosen.chat.class', $c) }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors {{ $class->id === $c->id ? 'bg-emerald-50 border-l-2 border-l-emerald-500' : '' }}">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($c->name, 0, 2) }}</div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $c->name }}</p>
                                <p class="text-xs text-gray-400">Klik untuk chat</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50 flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $class->name }}</h3>
                        <p class="text-xs text-gray-500">Diskusi kelas</p>
                    </div>
                </div>

                <div id="chat-messages" class="p-4 space-y-3 max-h-[60vh] lg:max-h-[65vh] overflow-y-auto">
                    @forelse($messages as $msg)
                        <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] lg:max-w-[70%] {{ $msg->user_id === auth()->id() ? 'bg-emerald-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md' }} px-4 py-2.5">
                                @if($msg->user_id !== auth()->id())
                                    <p class="text-xs font-medium text-blue-600 mb-0.5">{{ $msg->user->name }}</p>
                                @endif
                                <p class="text-sm leading-relaxed break-words">{{ $msg->message }}</p>
                                <p class="text-xs mt-1 {{ $msg->user_id === auth()->id() ? 'text-emerald-200' : 'text-gray-400' }}">{{ $msg->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 text-sm py-8">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <p>Belum ada pesan. Mulai diskusi!</p>
                        </div>
                    @endforelse
                </div>

                <form id="chat-form" class="px-4 py-3 border-t border-gray-100 bg-white">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="message" id="chat-input" autocomplete="off" required
                               class="flex-1 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                               placeholder="Ketik pesan...">
                        <button type="submit" class="px-4 lg:px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-medium rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span class="hidden lg:inline">Kirim</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="flex gap-6">
        <div class="hidden lg:block w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-4">
                <div class="p-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800">Daftar Kelas</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @foreach($classes as $c)
                        <a href="{{ route('dosen.chat.class', $c) }}" class="flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($c->name, 0, 2) }}</div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $c->name }}</p>
                                <p class="text-xs text-gray-400">Klik untuk chat</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex-1 flex items-center justify-center text-gray-400 bg-white rounded-xl shadow-sm border border-gray-200 min-h-[60vh]">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <p class="text-sm">Pilih kelas untuk mulai chat</p>
            </div>
        </div>
    </div>
@endif

@if(isset($class))
@push('scripts')
<script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    let lastId = {{ $messages->last()?->id ?? 0 }};

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;

        chatInput.value = '';
        chatInput.disabled = true;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        try {
            const res = await fetch('{{ route("dosen.chat.send", $class) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ message: msg }),
            });
            const data = await res.json();
            appendMessage(data.message, true);
            lastId = data.message.id;
        } catch (e) {
            chatInput.value = msg;
        }
        chatInput.disabled = false;
        chatInput.focus();
    });

    function appendMessage(msg, isSelf) {
        const div = document.createElement('div');
        div.className = 'flex ' + (isSelf ? 'justify-end' : 'justify-start');
        div.innerHTML = `
            <div class="max-w-[85%] lg:max-w-[70%] ${isSelf ? 'bg-emerald-500 text-white rounded-2xl rounded-br-md' : 'bg-gray-100 text-gray-800 rounded-2xl rounded-bl-md'} px-4 py-2.5">
                ${!isSelf ? `<p class="text-xs font-medium text-blue-600 mb-0.5">${msg.user?.name || 'Unknown'}</p>` : ''}
                <p class="text-sm leading-relaxed break-words">${escHtml(msg.message)}</p>
                <p class="text-xs mt-1 ${isSelf ? 'text-emerald-200' : 'text-gray-400'}">${new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'})}</p>
            </div>`;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    setInterval(async () => {
        try {
            const res = await fetch('{{ route("dosen.chat.messages", $class) }}?after=' + lastId);
            const data = await res.json();
            data.messages.forEach(msg => {
                appendMessage(msg, msg.user_id === {{ auth()->id() }});
                lastId = msg.id;
            });
        } catch (e) {}
    }, 3000);

    chatMessages.scrollTop = chatMessages.scrollHeight;
</script>
@endpush
@endif
@endsection
