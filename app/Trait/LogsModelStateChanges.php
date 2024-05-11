<?php


namespace AppTraits;

use Illuminate\Support\Facades\Log;

trait LogsModelStateChanges
{
    public static function bootLogsModelStateChanges()
    {
        static::created(function ($model) {
            $model->logChange('created');
        });

        static::updated(function ($model) {
            $model->logChange('updated');
        });

        static::deleted(function ($model) {
            $model->logChange('deleted');
        });
    }

    protected function logChange($event)
    {
        $className = class_basename($this);
        $changes = [
            'before' => $event === 'updated' ? $this->getOriginal() : null,
            'after' => $this->getAttributes(),
        ];

        Log::info("A {$className} record has been {$event}", $changes);
    }
}
