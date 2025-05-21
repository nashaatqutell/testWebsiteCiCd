<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GeneralObserver
{
    public function created(Model $model)
    {
        $this->logActivity($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logActivity($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logActivity($model, 'deleted');
    }

    protected function logActivity(Model $model, $event)
    {
        $description = __('activity.model_' . $event, ['model' => class_basename($model)]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($model)
            ->withProperties($model->getChanges())
            ->log($description);
    }
}
