<?php

namespace App\Services;

use App\Models\LMSClass;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function send(int $userId, string $type, string $title, ?string $message = null, ?array $data = null): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function sendToClass(int $classId, string $type, string $title, ?string $message = null, ?array $data = null): void
    {
        $users = LMSClass::find($classId)?->students;
        if ($users) {
            foreach ($users as $user) {
                self::send($user->id, $type, $title, $message, $data);
            }
        }
    }

    public static function sendToRole(string $role, string $type, string $title, ?string $message = null, ?array $data = null): void
    {
        $users = User::role($role)->get();
        foreach ($users as $user) {
            self::send($user->id, $type, $title, $message, $data);
        }
    }
}
