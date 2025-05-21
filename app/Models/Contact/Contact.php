<?php

namespace App\Models\Contact;

use App\Http\Resources\ContactResource;
use App\Models\BaseModel;
use App\Models\Service\Service;

class Contact extends BaseModel
{
    protected $guarded = ['id'];

    public function getResource(): ContactResource
    {
        return new ContactResource($this->fresh());
    }


    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
