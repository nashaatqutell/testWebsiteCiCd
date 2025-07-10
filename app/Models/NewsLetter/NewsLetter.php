<?php

namespace App\Models\NewsLetter;

use App\Models\BaseModel;

class NewsLetter extends BaseModel
{
    protected $table = 'news_letters';

    protected $fillable = [
        'email',
        'name',
        'is_active',
        'added_by_id',
        'phone',
    ];
}
