<?php

namespace Database\Seeders;

use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Grade;
use App\Models\LMSClass;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = LMSClass::all();
        $mahasiswa = User::role('mahasiswa')->get();

        foreach ($kelas as $kelasItem) {

            // Grades for each student in each class
            foreach ($mahasiswa as $mhs) {
                // Quiz grades
                $kelasItem->quizzes->each(function ($quiz) use ($mhs, $kelasItem) {
                    Grade::create([
                        'user_id' => $mhs->id,
                        'class_id' => $kelasItem->id,
                        'quiz_id' => $quiz->id,
                        'type' => 'quiz',
                        'score' => rand(60, 100),
                        'max_score' => $quiz->max_score,
                        'weight' => 25,
                    ]);
                });

                // Assignment grades
                $kelasItem->assignments->each(function ($assignment) use ($mhs, $kelasItem) {
                    Grade::create([
                        'user_id' => $mhs->id,
                        'class_id' => $kelasItem->id,
                        'assignment_id' => $assignment->id,
                        'type' => 'assignment',
                        'score' => rand(65, 100),
                        'max_score' => $assignment->max_score,
                        'weight' => 35,
                    ]);
                });

                // Final score
                $totalScore = Grade::where('user_id', $mhs->id)
                    ->where('class_id', $kelasItem->id)
                    ->where('type', '!=', 'final')
                    ->get()
                    ->sum(fn ($g) => ($g->score / $g->max_score) * $g->weight);

                Grade::create([
                    'user_id' => $mhs->id,
                    'class_id' => $kelasItem->id,
                    'type' => 'final',
                    'score' => round($totalScore, 2),
                    'max_score' => 100,
                    'weight' => 0,
                ]);
            }

            // Assignment submissions
            $kelasItem->assignments->each(function ($assignment) use ($kelasItem, $mahasiswa) {
                foreach ($mahasiswa as $mhs) {
                    $statuses = ['submitted', 'graded', 'graded', 'submitted'];
                    $status = $statuses[array_rand($statuses)];
                    $score = $status === 'graded' ? rand(60, 100) : null;

                    AssignmentSubmission::create([
                        'assignment_id' => $assignment->id,
                        'user_id' => $mhs->id,
                        'notes' => 'Tugas sudah dikerjakan dengan baik.',
                        'score' => $score,
                        'feedback' => $score ? ($score >= 80 ? 'Bagus, pertahankan!' : 'Perlu ditingkatkan lagi.') : null,
                        'status' => $status,
                        'submitted_at' => Carbon::now()->subDays(rand(1, 5)),
                        'graded_at' => $status === 'graded' ? Carbon::now()->subDays(rand(0, 2)) : null,
                    ]);
                }
            });

            // Certificates for students with good grades
            foreach ($mahasiswa as $mhs) {
                $finalGrade = Grade::where('user_id', $mhs->id)
                    ->where('class_id', $kelasItem->id)
                    ->where('type', 'final')
                    ->first();

                if ($finalGrade && $finalGrade->score >= 60) {
                    Certificate::create([
                        'user_id' => $mhs->id,
                        'class_id' => $kelasItem->id,
                        'issued_at' => Carbon::now()->subDays(rand(1, 30)),
                    ]);
                }
            }

            // Notifications
            foreach ($mahasiswa as $mhs) {
                Notification::create([
                    'user_id' => $mhs->id,
                    'type' => 'info',
                    'title' => 'Materi Baru: ' . ($kelasItem->materials()->first()->title ?? $kelasItem->name),
                    'message' => 'Materi baru telah ditambahkan di kelas ' . $kelasItem->name . '. Silakan dipelajari.',
                    'data' => ['class_id' => $kelasItem->id, 'type' => 'material'],
                    'is_read' => (bool) rand(0, 1),
                ]);

                Notification::create([
                    'user_id' => $mhs->id,
                    'type' => 'warning',
                    'title' => 'Tugas Mendekati Deadline',
                    'message' => 'Tugas ' . ($kelasItem->assignments()->first()->title ?? 'Tugas') . ' akan deadline dalam 3 hari. Segera kumpulkan!',
                    'data' => ['class_id' => $kelasItem->id, 'type' => 'assignment'],
                    'is_read' => (bool) rand(0, 1),
                ]);
            }
        }
    }
}
