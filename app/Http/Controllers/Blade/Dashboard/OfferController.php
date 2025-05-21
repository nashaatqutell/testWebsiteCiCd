<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Offer\StoreOfferRequest;
use App\Http\Requests\Dashboard\Offer\UpdateOfferRequest;
use App\Models\Offer\Offer;
use App\Service\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected $offersService;
    public function  __construct(OfferService $offersService)
    {
        $this->offersService = $offersService;
        $this->middleware('permission:show_offers')->only(['index','show']);
        $this->middleware('permission:create_offers')->only(['store']);
        $this->middleware('permission:update_offers')->only(['update']);
        $this->middleware('permission:delete_offers')->only(['destroy']);
        $this->middleware('permission:active_offers')->only(['changeStatus']);
    }

    public function index()
    {
        $offers = $this->offersService->index('get');
        return view('dashboard.offer.index',get_defined_vars());
    }


    public function create()
    {
        $offer = new Offer();
        return view('dashboard.offer.single',compact('offer'));
    }


    public function store(StoreOfferRequest $request)
    {
        $this->offersService->store($request);
        return redirect()->route('admin.offers.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function show(Offer $offer)
    {
        $offer = $this->offersService->show($offer);
        return view('dashboard.offer.show',get_defined_vars());
    }


    public function edit(Offer $offer)
    {
        return view('dashboard.offer.single',get_defined_vars());
    }


    public function update(UpdateOfferRequest $request, Offer  $offer)
    {
        $this->offersService->update($request, $offer);
        return redirect()->route('admin.offers.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }
    public function destroy(Offer $offer)
    {
        try {
            $this->offersService->destroy($offer);
            return response()->json([
                'success' => true,
                'message' => __('offers.offers_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }
    public function changeStatus(Offer $offer)
    {
        $this->offersService->changeStatus($offer);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
