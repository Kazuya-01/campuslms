<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\LMSClass;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = LMSClass::all();
        $dosen = User::role('dosen')->first();

        $materiPerKelas = [
            'Pemrograman Web Lanjutan' => [
                ['title' => 'Pengantar Laravel', 'description' => 'Pengenalan arsitektur MVC, routing, dan struktur direktori Laravel.', 'meeting_number' => 1, 'type' => 'link', 'link_url' => 'https://laravel.com/docs'],
                ['title' => 'Eloquent ORM & Migration', 'description' => 'Belajar database migration, model Eloquent, dan relationship.', 'meeting_number' => 2, 'type' => 'link', 'link_url' => 'https://laravel.com/docs/eloquent'],
                ['title' => 'Blade Templating & Component', 'description' => 'Membahas Blade template engine, component, dan layouting.', 'meeting_number' => 3, 'type' => 'video', 'video_url' => 'https://youtube.com/watch?v=example1'],
                ['title' => 'REST API dengan Laravel', 'description' => 'Pembuatan RESTful API menggunakan resource controller dan API resources.', 'meeting_number' => 4, 'type' => 'link', 'link_url' => 'https://laravel.com/docs/eloquent-resources'],
            ],
            'Basis Data Terdistribusi' => [
                ['title' => 'Konsep DBMS Terdistribusi', 'description' => 'Pengertian, arsitektur, dan keuntungan sistem basis data terdistribusi.', 'meeting_number' => 1, 'type' => 'link', 'link_url' => 'https://en.wikipedia.org/wiki/Distributed_database'],
                ['title' => 'Replikasi & Sharding', 'description' => 'Teknik replikasi data dan sharding untuk skalabilitas horizontal.', 'meeting_number' => 2, 'type' => 'video', 'video_url' => 'https://youtube.com/watch?v=example2'],
                ['title' => 'Query Optimization', 'description' => 'Optimasi query pada lingkungan DBMS terdistribusi.', 'meeting_number' => 3, 'type' => 'link', 'link_url' => 'https://use-the-index-luke.com/'],
            ],
            'Kecerdasan Buatan' => [
                ['title' => 'Pengantar AI & Sejarahnya', 'description' => 'Sejarah perkembangan AI, Turing test, dan aplikasi AI di era modern.', 'meeting_number' => 1, 'type' => 'video', 'video_url' => 'https://youtube.com/watch?v=example3'],
                ['title' => 'Machine Learning Dasar', 'description' => 'Konsep supervised, unsupervised, dan reinforcement learning.', 'meeting_number' => 2, 'type' => 'link', 'link_url' => 'https://scikit-learn.org/stable/tutorial/'],
                ['title' => 'Neural Network & Deep Learning', 'description' => 'Pengenalan arsitektur neural network, backpropagation, dan framework deep learning.', 'meeting_number' => 3, 'type' => 'video', 'video_url' => 'https://youtube.com/watch?v=example4'],
            ],
        ];

        $tugasPerKelas = [
            'Pemrograman Web Lanjutan' => [
                ['title' => 'Membuat CRUD Sederhana', 'description' => 'Buat fitur CRUD untuk data mahasiswa menggunakan Laravel lengkap dengan validasi dan pagination.', 'max_score' => 100, 'deadline_days' => 14],
                ['title' => 'REST API Blog', 'description' => 'Buat REST API untuk blog dengan autentikasi Sanctum, lengkap dengan dokumentasi Postman.', 'max_score' => 100, 'deadline_days' => 21],
            ],
            'Basis Data Terdistribusi' => [
                ['title' => 'Desain Database Terdistribusi', 'description' => 'Rancang arsitektur database terdistribusi untuk aplikasi e-commerce skala besar.', 'max_score' => 100, 'deadline_days' => 14],
            ],
            'Kecerdasan Buatan' => [
                ['title' => 'Klasifikasi Gambar Sederhana', 'description' => 'Buat model CNN untuk klasifikasi gambar menggunakan TensorFlow atau PyTorch.', 'max_score' => 100, 'deadline_days' => 21],
                ['title' => 'Chatbot Sederhana', 'description' => 'Implementasikan chatbot berbasis aturan atau NLP sederhana menggunakan Python.', 'max_score' => 100, 'deadline_days' => 14],
            ],
        ];

        $quizPerKelas = [
            'Pemrograman Web Lanjutan' => [
                [
                    'title' => 'Quiz 1: Dasar Laravel',
                    'description' => 'Evaluasi pemahaman dasar Laravel, routing, dan MVC.',
                    'time_limit' => 30,
                    'max_score' => 100,
                    'questions' => [
                        ['question' => 'Apa kepanjangan dari MVC?', 'type' => 'multiple_choice', 'options' => [['label' => 'Model View Controller', 'value' => 'a'], ['label' => 'Main View Control', 'value' => 'b'], ['label' => 'Model Visual Component', 'value' => 'c'], ['label' => 'Module View Class', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Perintah untuk membuat migration di Laravel adalah...', 'type' => 'multiple_choice', 'options' => [['label' => 'php artisan make:model', 'value' => 'a'], ['label' => 'php artisan make:migration', 'value' => 'b'], ['label' => 'php artisan create:migration', 'value' => 'c'], ['label' => 'php artisan generate:migration', 'value' => 'd']], 'correct_answer' => 'b', 'points' => 20],
                        ['question' => 'Apa fungsi dari Eloquent ORM?', 'type' => 'multiple_choice', 'options' => [['label' => 'Menangani routing', 'value' => 'a'], ['label' => 'Mengelola database dengan OOP', 'value' => 'b'], ['label' => 'Membuat tampilan blade', 'value' => 'c'], ['label' => 'Mengelola asset CSS/JS', 'value' => 'd']], 'correct_answer' => 'b', 'points' => 20],
                        ['question' => 'File route untuk web di Laravel berada di...', 'type' => 'multiple_choice', 'options' => [['label' => 'routes/web.php', 'value' => 'a'], ['label' => 'routes/api.php', 'value' => 'b'], ['label' => 'config/routes.php', 'value' => 'c'], ['label' => 'app/routes.php', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Apa perintah untuk menjalankan development server Laravel?', 'type' => 'multiple_choice', 'options' => [['label' => 'php artisan serve', 'value' => 'a'], ['label' => 'php artisan start', 'value' => 'b'], ['label' => 'php artisan dev', 'value' => 'c'], ['label' => 'php artisan run', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                    ],
                ],
            ],
            'Basis Data Terdistribusi' => [
                [
                    'title' => 'Quiz 1: Konsep Dasar',
                    'description' => 'Uji pemahaman tentang konsep dasar basis data terdistribusi.',
                    'time_limit' => 20,
                    'max_score' => 100,
                    'questions' => [
                        ['question' => 'Apa itu sharding dalam database terdistribusi?', 'type' => 'multiple_choice', 'options' => [['label' => 'Memecah data menjadi partisi kecil', 'value' => 'a'], ['label' => 'Menggandakan data ke server lain', 'value' => 'b'], ['label' => 'Mengenkripsi data', 'value' => 'c'], ['label' => 'Mengompresi data', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 25],
                        ['question' => 'Teorema CAP dalam distributed system terdiri dari...', 'type' => 'multiple_choice', 'options' => [['label' => 'Consistency, Availability, Partition Tolerance', 'value' => 'a'], ['label' => 'Control, Access, Protocol', 'value' => 'b'], ['label' => 'Cache, Aggregate, Process', 'value' => 'c'], ['label' => 'Create, Analyze, Process', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 25],
                        ['question' => 'Apa keuntungan utama replikasi database?', 'type' => 'multiple_choice', 'options' => [['label' => 'High availability dan disaster recovery', 'value' => 'a'], ['label' => 'Menghemat biaya storage', 'value' => 'b'], ['label' => 'Mempercepat koneksi internet', 'value' => 'c'], ['label' => 'Mengurangi jumlah tabel', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 25],
                        ['question' => 'Apa fungsi dari query optimizer?', 'type' => 'multiple_choice', 'options' => [['label' => 'Mencari execution plan terbaik', 'value' => 'a'], ['label' => 'Membuat tabel baru', 'value' => 'b'], ['label' => 'Menghapus data duplikat', 'value' => 'c'], ['label' => 'Mengubah tipe data kolom', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 25],
                    ],
                ],
            ],
            'Kecerdasan Buatan' => [
                [
                    'title' => 'Quiz 1: Pengantar AI',
                    'description' => 'Evaluasi pemahaman dasar tentang kecerdasan buatan.',
                    'time_limit' => 25,
                    'max_score' => 100,
                    'questions' => [
                        ['question' => 'Siapa yang mencetuskan Turing Test?', 'type' => 'multiple_choice', 'options' => [['label' => 'Alan Turing', 'value' => 'a'], ['label' => 'John McCarthy', 'value' => 'b'], ['label' => 'Marvin Minsky', 'value' => 'c'], ['label' => 'Geoffrey Hinton', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Apa perbedaan supervised dan unsupervised learning?', 'type' => 'multiple_choice', 'options' => [['label' => 'Supervised pakai label, unsupervised tanpa label', 'value' => 'a'], ['label' => 'Supervised tanpa label, unsupervised pakai label', 'value' => 'b'], ['label' => 'Keduanya sama saja', 'value' => 'c'], ['label' => 'Supervised hanya untuk angka', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Apa fungsi dari activation function pada neural network?', 'type' => 'multiple_choice', 'options' => [['label' => 'Menambahkan non-linearitas', 'value' => 'a'], ['label' => 'Menghapus neuron', 'value' => 'b'], ['label' => 'Mempercepat training', 'value' => 'c'], ['label' => 'Menyimpan data training', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Algoritma apa yang umum digunakan untuk klasifikasi teks?', 'type' => 'multiple_choice', 'options' => [['label' => 'Naive Bayes', 'value' => 'a'], ['label' => 'Binary Search', 'value' => 'b'], ['label' => 'Bubble Sort', 'value' => 'c'], ['label' => 'Linear Search', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                        ['question' => 'Apa itu overfitting dalam machine learning?', 'type' => 'multiple_choice', 'options' => [['label' => 'Model terlalu cocok dengan data training', 'value' => 'a'], ['label' => 'Model tidak cocok dengan data training', 'value' => 'b'], ['label' => 'Model tidak bisa di-deploy', 'value' => 'c'], ['label' => 'Model terlalu lambat', 'value' => 'd']], 'correct_answer' => 'a', 'points' => 20],
                    ],
                ],
            ],
        ];

        foreach ($kelas as $kelasItem) {
            $namaKelas = $kelasItem->name;

            // Materials
            if (isset($materiPerKelas[$namaKelas])) {
                foreach ($materiPerKelas[$namaKelas] as $order => $materi) {
                    Material::create(array_merge($materi, [
                        'class_id' => $kelasItem->id,
                        'order' => $order + 1,
                        'is_active' => true,
                    ]));
                }
            }

            // Assignments
            if (isset($tugasPerKelas[$namaKelas])) {
                foreach ($tugasPerKelas[$namaKelas] as $tugas) {
                    Assignment::create([
                        'class_id' => $kelasItem->id,
                        'title' => $tugas['title'],
                        'description' => $tugas['description'],
                        'max_score' => $tugas['max_score'],
                        'deadline' => Carbon::now()->addDays($tugas['deadline_days']),
                        'instructions' => "Kerjakan tugas berikut dengan baik:\n1. Baca materi yang sudah disediakan\n2. Kerjakan sesuai ketentuan\n3. Kumpulkan sebelum deadline\n4. Format file: PDF",
                        'is_active' => true,
                    ]);
                }
            }

            // Quizzes
            if (isset($quizPerKelas[$namaKelas])) {
                foreach ($quizPerKelas[$namaKelas] as $quizData) {
                    $questions = $quizData['questions'];
                    unset($quizData['questions']);

                    $quiz = Quiz::create(array_merge($quizData, [
                        'class_id' => $kelasItem->id,
                        'random_questions' => false,
                        'random_answers' => false,
                        'allow_review' => true,
                        'is_active' => true,
                    ]));

                    foreach ($questions as $order => $q) {
                        QuizQuestion::create(array_merge($q, [
                            'quiz_id' => $quiz->id,
                            'order' => $order + 1,
                        ]));
                    }
                }
            }
        }
    }
}
