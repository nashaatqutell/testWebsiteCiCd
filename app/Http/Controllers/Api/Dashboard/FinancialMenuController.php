<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Service\FinancialMenuService;
use App\Models\JobHierarchy\JobHierarchy;
use App\Http\Resources\JobWebsiteRescource;
use App\Models\FinancialMenu\FinancialMenu;
use App\Http\Resources\FinancialMenuResource;
use App\Http\Requests\Dashboard\FinancialMenu\StoreFinancialMenuRequest;
use App\Http\Requests\Dashboard\FinancialMenu\UpdateFinancialMenuRequest;

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
        $financial_menus = $this->financialMenuService->index('paginate');
        return $this->paginateResponse(FinancialMenuResource::collection($financial_menus), $financial_menus);
    }

    public function list()
    {
        $financial_menus = $this->financialMenuService->list();
        return $this->successResponse(FinancialMenuResource::collection($financial_menus), __('messages.retrieved_successfully'));
    }

    public function show(FinancialMenu $financial_menu)
    {
        $financial_menu = $this->financialMenuService->show($financial_menu);
        return $this->successResponse(FinancialMenuResource::make($financial_menu), __('messages.retrieved_successfully'));
    }

    public function store(StoreFinancialMenuRequest $request)
    {
        $financial_menu = $this->financialMenuService->store($request);
        return $this->successResponse(data: $financial_menu->getResource(), message: __('messages.success'));
    }

    public function update(UpdateFinancialMenuRequest $request, FinancialMenu $financial_menu)
    {
        $financial_menu = $this->financialMenuService->update($request, $financial_menu);

        return $this->successResponse(data: $financial_menu->getResource(), message: __('messages.update'));
    }

    public function destroy(FinancialMenu $financial_menu)
    {
        $this->financialMenuService->destroy($financial_menu);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(FinancialMenu $financial_menu)
    {
        $this->financialMenuService->changeStatus($financial_menu);
        return $this->successResponse(message: __('keys.status_updated_successfully'));
    }

}
