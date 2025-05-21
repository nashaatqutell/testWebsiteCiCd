<?php

namespace App\Models;

use App\Enums\User\RoleEnum;
use App\Http\Filters\Filterable;
use App\Traits\HasActivation;
use App\Traits\HasActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class BaseModel extends Model implements HasMedia
{
    use HasActivation, Filterable, SoftDeletes, InteractsWithMedia , HasActivityLog;


    protected $casts = [
        'role' => RoleEnum::class, // Ensure role is cast as enum
    ];
    public function storeImages($media, $update = false, $collection = 'images'): void
    {
        $images = array_filter(convertToArray($media));
        if ($update && !empty($images)) {
            $this->deleteMedia(collection: $collection);
        }
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $this->addMedia($image)->toMediaCollection($collection);
                }
            }
        }
    }

    public function deleteMedia($collection = 'images'): void
    {
        $media = $this->getMedia($collection);
        foreach ($media as $m) {
            $m->delete();
        }
    }

    public function storeVideos($media, $update = false, $collection = 'videos'): void
    {
        $videos = array_filter(convertToArray($media));
        if ($update && !empty($videos)) {
            $this->clearMediaCollection($collection);
        }
        if (count($videos) > 0) {
            foreach ($videos as $video) {
                $this->addMedia($video)->toMediaCollection($collection);
            }
        }
    }

    public function deleteMediaVideos($collection = 'videos'): void
    {
        $media = $this->getMedia($collection);
        foreach ($media as $m) {
            $m->delete();
        }
    }

    public function getImages($collection = 'images'): array
    {
        return $this->getMedia($collection)->map(fn($media) => $media->getUrl());
    }

    public function getVideos($collection = 'videos'): array
    {
        return $this->getMedia($collection)->map(fn($media) => $media->getUrl());
    }

    public function getImage($collection = 'images'): ?string
    {
        return $this->getFirstMediaUrl($collection) ?: null;
    }

    public function getVideo($collection = 'videos'): ?string
    {
        return $this->getFirstMediaUrl($collection) ?: null;
    }

    public function AddedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "added_by_id");
    }
}

