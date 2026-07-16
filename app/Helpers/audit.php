<?php

use App\Models\AuditLog;

if (!function_exists('audit')) {
    function audit($action, $description = null, $model = null, $meta = [])
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'meta' => $meta,
        ]);
    }
}