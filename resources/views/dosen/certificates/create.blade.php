@extends('layouts.dosen')

@section('title', 'Terbitkan Sertifikat - CampusLMS')
@section('page-title', 'Terbitkan Sertifikat')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <form action="{{ route('dosen.certificates.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Kelas</label>
                    <select name="class_id" id="class-select" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" data-students='@json($class->students->map(fn($s) => $s->only(['id', 'name', 'nim'])))'>
                                {{ $class->name }} ({{ $class->students->count() }} mahasiswa)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Mahasiswa</label>
                    <div id="students-list" class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pilih kelas terlebih dahulu.</p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hanya mahasiswa yang belum memiliki sertifikat yang akan ditampilkan.</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('dosen.certificates.index') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg">Terbitkan Sertifikat</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('class-select').addEventListener('change', function() {
        const container = document.getElementById('students-list');
        const selected = this.options[this.selectedIndex];
        if (!selected || !selected.dataset.students) {
            container.innerHTML = '<p class="text-sm text-gray-500">Pilih kelas terlebih dahulu.</p>';
            return;
        }
        const students = JSON.parse(selected.dataset.students);
        if (students.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500">Tidak ada mahasiswa di kelas ini.</p>';
            return;
        }
        container.innerHTML = students.map(s => `
            <label class="flex items-center space-x-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700/30">
                <input type="checkbox" name="user_ids[]" value="${s.id}" class="rounded border-gray-300 dark:border-gray-600 text-emerald-600 dark:bg-gray-700">
                <span class="text-sm text-gray-800 dark:text-white">${s.name} ${s.nim ? '(' + s.nim + ')' : ''}</span>
            </label>
        `).join('');
    });
</script>
@endpush
@endsection
