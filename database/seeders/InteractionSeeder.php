<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use App\Models\ForumReply;
use App\Models\ForumReplyLike;
use App\Models\ForumThread;
use App\Models\LMSClass;
use App\Models\User;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = LMSClass::all();
        $dosen = User::role('dosen')->first();
        $mahasiswa = User::role('mahasiswa')->get();

        $threadData = [
            'Pemrograman Web Lanjutan' => [
                [
                    'title' => 'Pengalaman pertama pakai Laravel',
                    'content' => 'Teman-teman, ada yang baru pertama kali pakai Laravel? Sharing pengalaman kalian dong! Saya pribadi agak bingung dengan konsep Service Container.',
                    'user_id' => $mahasiswa[0]->id,
                ],
                [
                    'title' => 'Tips debugging di Laravel',
                    'content' => 'Buat yang masih baru, kalian bisa pakai dd() atau dump() untuk debugging. Juga recommend install Laravel Debugbar!',
                    'user_id' => $dosen->id,
                    'is_pinned' => true,
                ],
            ],
            'Basis Data Terdistribusi' => [
                [
                    'title' => 'Materi sharding masih kurang jelas',
                    'content' => 'Pak, untuk konsep sharding apakah ada studi kasus nyata? Saya masih bingung penerapannya di production.',
                    'user_id' => $mahasiswa[1]->id,
                ],
            ],
            'Kecerdasan Buatan' => [
                [
                    'title' => 'Rekomendasi dataset untuk tugas klasifikasi',
                    'content' => 'Teman-teman, ada rekomendasi dataset untuk tugas klasifikasi gambar? Saya cari yang ukurannya tidak terlalu besar.',
                    'user_id' => $mahasiswa[0]->id,
                ],
                [
                    'title' => 'Diskusi: Masa depan AI di Indonesia',
                    'content' => 'Menurut kalian bagaimana prospek AI di Indonesia dalam 5 tahun ke depan? Apakah akan banyak lapangan kerja baru?',
                    'user_id' => $mahasiswa[1]->id,
                ],
            ],
        ];

        $replyData = [
            'Pengalaman pertama pakai Laravel' => [
                ['content' => 'Saya juga baru pertama kali! Tapi setelah nonton video tutorial jadi lebih paham. Coba lihat playlist Laravel dari Laracasts.', 'user_id' => $mahasiswa[1]->id],
                ['content' => 'Sama, Service Container cukup membingungkan. Tapi setelah praktek bikin beberapa project, lama-lama paham sendiri.', 'user_id' => $dosen->id],
            ],
            'Tips debugging di Laravel' => [
                ['content' => 'Makasih tipsnya Pak! Saya baru tahu ada dd(). Selama ini pakai echo terus.', 'user_id' => $mahasiswa[0]->id],
                ['content' => 'Jangan lupa juga install Laravel IDE Helper biar autocomplete-nya jalan.', 'user_id' => $mahasiswa[1]->id],
            ],
            'Materi sharding masih kurang jelas' => [
                ['content' => 'Coba baca case study dari MongoDB Sharding, lumayan membantu pemahaman.', 'user_id' => $mahasiswa[0]->id],
                ['content' => 'Nanti pertemuan depan akan saya bahas lebih detail dengan contoh kasus e-commerce.', 'user_id' => $dosen->id],
            ],
        ];

        $replyLikes = [
            'Saya juga baru pertama kali! Tapi setelah nonton video tutorial jadi lebih paham. Coba lihat playlist Laravel dari Laracasts.' => [1, 2],  // liked by reply index? no, liked by user
        ];

        foreach ($kelas as $kelasItem) {
            $namaKelas = $kelasItem->name;

            // Global announcements
            Announcement::create([
                'user_id' => $dosen->id,
                'class_id' => $kelasItem->id,
                'title' => 'Selamat Datang di Mata Kuliah '.$namaKelas,
                'content' => 'Selamat datang mahasiswa! Silakan pelajari materi pertemuan pertama yang sudah diupload. Jangan lupa untuk bergabung di forum diskusi kelas.',
                'is_pinned' => true,
                'is_global' => false,
            ]);

            Announcement::create([
                'user_id' => $dosen->id,
                'class_id' => $kelasItem->id,
                'title' => 'Pengumuman: Jadwal UTS',
                'content' => 'Ujian Tengah Semester akan dilaksanakan pada minggu ke-8. Materi ujian mencakup pertemuan 1-7. Persiapan matang ya!',
                'is_pinned' => false,
                'is_global' => false,
            ]);

            // Attendance sessions
            for ($meeting = 1; $meeting <= 3; $meeting++) {
                $attendance = Attendance::create([
                    'class_id' => $kelasItem->id,
                    'meeting_number' => $meeting,
                    'date' => now()->subWeeks(4 - $meeting),
                    'dosen_id' => $dosen->id,
                    'is_active' => true,
                ]);

                foreach ($mahasiswa as $mhs) {
                    $statuses = ['present', 'present', 'present', 'present', 'late', 'absent'];
                    AttendanceRecord::create([
                        'attendance_id' => $attendance->id,
                        'user_id' => $mhs->id,
                        'status' => $statuses[array_rand($statuses)],
                        'timestamp' => $attendance->date->copy()->setHour(8)->addMinutes(rand(0, 120)),
                    ]);
                }
            }

            // Forum threads
            if (isset($threadData[$namaKelas])) {
                foreach ($threadData[$namaKelas] as $thread) {
                    $createdThread = ForumThread::create(array_merge($thread, [
                        'class_id' => $kelasItem->id,
                    ]));

                    // Replies for this thread
                    if (isset($replyData[$thread['title']])) {
                        foreach ($replyData[$thread['title']] as $reply) {
                            $createdReply = ForumReply::create(array_merge($reply, [
                                'forum_thread_id' => $createdThread->id,
                            ]));

                            // Random likes on replies
                            foreach ($mahasiswa as $mhs) {
                                if (rand(0, 1)) {
                                    ForumReplyLike::create([
                                        'forum_reply_id' => $createdReply->id,
                                        'user_id' => $mhs->id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
