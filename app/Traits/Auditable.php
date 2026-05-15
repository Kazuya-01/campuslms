<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::logAudit('created', $model, null, $model->toArray());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            if (count($changes) > 0) {
                static::logAudit('updated', $model, $model->getOriginal(), $changes);
            }
        });

        static::deleted(function ($model) {
            static::logAudit('deleted', $model, $model->toArray(), null);
        });
    }

    protected static function logAudit(string $action, $model, $oldValues, $newValues): void
    {
        if (!Auth::check()) return;

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
