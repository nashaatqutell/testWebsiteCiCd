<?php

namespace App\Http\Controllers\Api\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FinancialMenu\FinancialMenu;
use App\Http\Resources\FinancialMenuResource;

class FinancialMenuController extends Controller
{
    public function __invoke(Request $request)
    {
        $financial_menu = FinancialMenu::whereIsActive()->filter()->latest()->get();
        return $this->successResponse(FinancialMenuResource::collection($financial_menu));
    }

    public function downloadFile(FinancialMenu $financialMenu)
    {
        $filePath = str_replace(url(''), '', $financialMenu->getFirstMediaUrl('financial_file'));
        $filePath = public_path($filePath);

        if (!file_exists($filePath)) {
            abort(404);
        }
        return response()->download($filePath);
    }
}
