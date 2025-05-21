<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FinancialMenu\StoreFinancialMenuRequest;
use App\Http\Requests\Dashboard\FinancialMenu\UpdateFinancialMenuRequest;
use App\Models\FinancialMenu\FinancialMenu;
use App\Service\FinancialMenuService;

class FinancialMenuController extends Controller
{
    protected $financialMenuService;

    public function __construct(FinancialMenuService $financialMenuService)
    {
        $this->financialMenuService = $financialMenuService;
        $this->middleware('permission:show_financials')->only(['index', 'show']);
        $this->middleware('permission:create_financials')->only(['store']);
        $this->middleware('permission:update_financials')->only(['update']);
        $this->middleware('permission:delete_financials')->only(['destroy']);
        $this->middleware('permission:active_financials')->only(['changeStatus']);
    }

    public function index()
    {
        $financial_menus = FinancialMenu::get();
        $title = __('financial.Financial_Menu');
        return view('dashboard.financialMenu.index', compact('financial_menus'));
    }

    public function create()
    {
        $financial_menu = new FinancialMenu();
        return view('dashboard.financialMenu.single', get_defined_vars());
    }

    public function store(StoreFinancialMenuRequest $request)
    {
        $this->financialMenuService->store($request);
        return redirect()->route('admin.financial_menus.index')->with(
            [
                "message" => __("messages.success"),
                "alert-type" => "success",
            ]
        );
    }

    public function edit(FinancialMenu $financial_menu)
    {
        return view('dashboard.financialMenu.single', get_defined_vars());
    }

    public function update(UpdateFinancialMenuRequest $request, FinancialMenu $financial_menu)
    {
        $this->financialMenuService->update($request, $financial_menu);
        return redirect()->route('admin.financial_menus.index')->with(
            [
                "message" => __("messages.update"),
                "alert-type" => "success",
            ]
        );
    }

    public function destroy(FinancialMenu $financial_menu)
    {
        try {
            $this->financialMenuService->destroy($financial_menu);

            return response()->json([
                'success' => true,
                'message' => __('messages.delete'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong'),
            ], 500);
        }

    }

    public function changeStatus(FinancialMenu $financial_menu)
    {
        $this->financialMenuService->changeStatus($financial_menu);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated_successfully'),
        ]);
    }

}
