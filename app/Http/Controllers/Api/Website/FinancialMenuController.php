<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinancialMenuResource;
use App\Models\FinancialMenu\FinancialMenu;
use Illuminate\Http\Request;

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

        if (! file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath);
    }
}
