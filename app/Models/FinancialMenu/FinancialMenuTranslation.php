<?php
namespace App\Models\FinancialMenu;

use Illuminate\Database\Eloquent\Model;

class FinancialMenuTranslation extends Model
{

    protected $table    = 'financial_menus_translations';
    protected $fillable = ['name', 'locale', 'financial_menu_id'];
    public $timestamps  = false;
}
