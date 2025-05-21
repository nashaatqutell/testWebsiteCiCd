<?php
namespace App\Service;

use App\Http\Requests\Dashboard\FinancialMenu\StoreFinancialMenuRequest;
use App\Http\Requests\Dashboard\FinancialMenu\UpdateFinancialMenuRequest;
use App\Models\FinancialMenu\FinancialMenu;

class FinancialMenuService
{
    public function index($query)
    {
        $financial_menus = FinancialMenu::query()->latest();
        return $query === 'paginate' ? $financial_menus->paginate(10) : $financial_menus->get();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return FinancialMenu::query()->latest()->get();
    }

    public function show(FinancialMenu $financial_menu): FinancialMenu
    {
        return $financial_menu;
    }

    public function store(StoreFinancialMenuRequest $request): FinancialMenu
    {
        $financial_menu = FinancialMenu::query()->create($request->validated() + ['added_by_id' => auth()->user()->id]);
        $financial_menu->storeImages(media: $request->file('icon'), collection: 'financial_icon');
        $financial_menu->storeImages(media: $request->file('file'), collection: 'financial_file');
        $financial_menu->save();
        return $financial_menu;
    }

    public function update(UpdateFinancialMenuRequest $request, FinancialMenu $financial_menu): FinancialMenu
    {
        $validatedDate = collect($request->validated())->except(['icon', 'file'])->toArray();
        $financial_menu->update($validatedDate);
        $financial_menu->storeImages(media: $request->file('icon'), update: true, collection: 'financial_icon');
        $financial_menu->storeImages(media: $request->file('file'), update: true, collection: 'financial_file');
        return $financial_menu;
    }

    public function destroy(FinancialMenu $financial_menu): void
    {
        $financial_menu->delete();
        $financial_menu->clearMediaCollection('financial_icon');
        $financial_menu->clearMediaCollection('financial_file');
    }

    public function changeStatus(FinancialMenu $financial_menu): FinancialMenu
    {
        $financial_menu->toggleActivation();
        return $financial_menu;
    }
}
