<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Countries\StoreCountryRequest;
use App\Http\Requests\Dashboard\Countries\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Country\Country;
use App\Service\CountryService;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->middleware('permission:show_countries')->only(['index','show']);
        $this->middleware('permission:create_countries')->only(['store']);
        $this->middleware('permission:update_countries')->only(['update']);
        $this->middleware('permission:delete_countries')->only(['destroy']);
        $this->middleware('permission:active_countries')->only(['changeStatus']);

        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getAllCountries('paginate');
        return $this->paginateResponse(CountryResource::collection($countries), $countries);
    }

    public function list()
    {
        $countries = $this->countryService->listCountries();
        return $this->successResponse(SimpleDataResource::collection($countries));
    }

    public function store(StoreCountryRequest $request)
    {
        $country = $this->countryService->storeCountry($request->validated());
        return $this->successResponse(data: $country->getResource(), message: __('messages.success'));
    }

    public function show(Country $country)
    {
        return $this->successResponse(data: CountryResource::make($country));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country = $this->countryService->updateCountry($country, $request->validated());
        return $this->successResponse(data: $country->getResource(), message: __('messages.update'));
    }

    public function destroy(Country $country)
    {
        $this->countryService->deleteCountry($country);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(Country $country)
    {
        $this->countryService->toggleCountryStatus($country);
        return $this->successResponse(message: __('messages.update'));
    }
}
