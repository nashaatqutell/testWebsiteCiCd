<?php
namespace App\Models\FinancialMenu;

use App\Http\Filters\FinancialMenuFilter;
use App\Http\Resources\FinancialMenuResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class FinancialMenu extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'financial_menus';

    protected $fillable = ['is_active', 'added_by_id', 'year'];

    public $translatedAttributes = ['name'];

    protected $filter = FinancialMenuFilter::class;

    public function getResource(): FinancialMenuResource
    {
        return new FinancialMenuResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('financial_icon')
            ->useDisk('public');

        $this
            ->addMediaCollection('financial_file')
            ->useDisk('public');

    }
}
