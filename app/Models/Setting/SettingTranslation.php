<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{

    protected $table = "setting_translations";
    protected $fillable = [
        "name",
        "description",
        "footer_description",
        "footer_description2",
        "address"
    ];
}
