@extends('layouts.dosen')

@section('title', 'Kalender Akademik - CampusLMS')
@section('page-title', 'Kalender Akademik')

@section('content')
<div class="space-y-6">
    <div x-data="calendarApp()" class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-6">
            <button @@click="prevMonth()" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <h3 class="text-lg font-semibold text-gray-800" x-text="monthYear"></h3>
            <button @@click="nextMonth()" class="p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

        <div class="grid grid-cols-7 gap-1 mb-2">
            <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="day">
                <div class="text-center text-xs font-semibold text-gray-500 py-2" x-text="day"></div>
            </template>
        </div>

        <div class="grid grid-cols-7 gap-1">
            <template x-for="(day, idx) in days" :key="idx">
                <div @@click="selectedDate = day.date"
                     :class="{
                         'bg-emerald-50 border-emerald-500': selectedDate === day.date,
                         'text-gray-400': !day.currentMonth,
                         'hover:bg-gray-50': day.currentMonth
                     }"
                     class="min-h-[80px] p-1.5 border border-gray-100 rounded-lg cursor-pointer transition-colors">
                    <span class="text-xs font-medium" :class="day.isToday ? 'bg-emerald-500 text-white w-5 h-5 rounded-full flex items-center justify-center' : ''" x-text="day.day"></span>
                    <template x-for="ev in day.events" :key="ev.title">
                        <a :href="ev.url" class="block text-xs px-1 py-0.5 mt-0.5 rounded truncate"
                           :class="{
                               'bg-emerald-100 text-emerald-700': ev.color === 'emerald',
                               'bg-purple-100 text-purple-700': ev.color === 'purple',
                           }">
                            <span x-text="ev.title"></span>
                        </a>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h3 class="font-semibold text-gray-800 mb-4">Semua Jadwal</h3>
        <div class="space-y-2">
            @forelse($events as $event)
                <a href="{{ $event['url'] }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                        {{ $event['color'] === 'emerald' ? 'bg-emerald-500' : 'bg-purple-500' }}">
                        {{ substr($event['type'], 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $event['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $event['class'] }} @isset($event['time']) &bull; {{ $event['time'] }} @endisset</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($event['date'])->format('d M') }}</span>
                </a>
            @empty
                <p class="text-gray-400 text-sm py-4 text-center">Belum ada jadwal.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
function calendarApp() {
    const events = @json($events);
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    return {
        selectedDate: null,
        days: [],
        monthYear: '',
        init() { this.render(); },
        prevMonth() { currentMonth--; if (currentMonth < 0) { currentMonth = 11; currentYear--; } this.render(); },
        nextMonth() { currentMonth++; if (currentMonth > 11) { currentMonth = 0; currentYear++; } this.render(); },
        render() {
            const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            this.monthYear = monthNames[currentMonth] + ' ' + currentYear;
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const prevMonthDays = new Date(currentYear, currentMonth, 0).getDate();
            this.days = [];
            for (let i = firstDay - 1; i >= 0; i--) {
                const d = prevMonthDays - i;
                const dateStr = (currentMonth === 0 ? currentYear - 1 : currentYear) + '-' + String(currentMonth === 0 ? 12 : currentMonth).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                this.days.push({ day: d, date: dateStr, currentMonth: false, isToday: false, events: events.filter(e => e.date === dateStr) });
            }
            for (let d = 1; d <= daysInMonth; d++) {
                const dateStr = currentYear + '-' + String(currentMonth + 1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                const isToday = d === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear();
                this.days.push({ day: d, date: dateStr, currentMonth: true, isToday, events: events.filter(e => e.date === dateStr) });
            }
            const remaining = 42 - this.days.length;
            for (let d = 1; d <= remaining; d++) {
                const dateStr = (currentMonth === 11 ? currentYear + 1 : currentYear) + '-' + String(currentMonth === 11 ? 1 : currentMonth + 2).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                this.days.push({ day: d, date: dateStr, currentMonth: false, isToday: false, events: events.filter(e => e.date === dateStr) });
            }
        }
    };
}
</script>
@endpush
@endsection
