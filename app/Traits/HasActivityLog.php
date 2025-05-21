<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasActivityLog
{
    public static function bootHasActivityLog()
    {
        static::created(function (Model $model) {
            $model->logActivity('created');
        });

        static::updated(function (Model $model) {
            $model->logActivity('updated');
        });

        static::deleted(function (Model $model) {
            $model->logActivity('deleted');
        });
    }

    protected function logActivity($event)
    {
        $description = __('activity.model_' . $event, ['model' => __($this->getTranslationKey())]);
        $descriptionEn = __('activity.model_' . $event, ['model' => __($this->getTranslationKey(), [], 'en')]);
        $descriptionAr = __('activity.model_' . $event, ['model' => __($this->getTranslationKey(), [], 'ar')]);

        $activity = activity()
            ->causedBy(Auth::user())
            ->performedOn($this)
            ->withProperties($this->getChanges())
            ->log($description);

        $activity->update(['description_en' => $descriptionEn, 'description_ar' => $descriptionAr]);
    }

    protected function getTranslationKey()
    {
        return 'activity.' . class_basename($this);
    }
}
