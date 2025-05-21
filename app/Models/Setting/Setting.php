<?php

namespace App\Models\Setting;

use App\Http\Filters\SettingFilter;
use App\Http\Resources\SettingResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description','notes_and_suggestions',"footer_description",
        "footer_description2" , "address"];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name','description','is_active','added_by_id',"email","phone","phone2",'support_phone',
        'notes_and_suggestions',"location","facebook","x","instagram","whatsapp","youtube","tiktok","embed_map",
    ];

    protected string $filter = SettingFilter::class;

    public function getResource(): SettingResource
    {
        return new SettingResource($this->fresh());
    }
}
