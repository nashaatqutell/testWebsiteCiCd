<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Countries\StoreCountryRequest;
use App\Http\Requests\Dashboard\Countries\UpdateCountryRequest;
use App\Models\Country\Country;
use App\Service\CountryService;
use Illuminate\Http\Request;
use Exception;

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
        $countries = $this->countryService->getAllCountries('get');
        return view('dashboard.country.index', get_defined_vars());
    }


    public function create()
    {
        return view('dashboard.country.single');
    }


    public function store(StoreCountryRequest $request)
    {
        $this->countryService->storeCountry($request->validated());

        return to_route('admin.countries.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function edit(Country $country)
    {
        return view('dashboard.country.single', get_defined_vars());
    }


    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country = $this->countryService->updateCountry($country, $request->validated());

        return to_route('admin.countries.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }


    public function destroy(Country $country)
    {
        try {
            $this->countryService->deleteCountry($country);
            return response()->json([
                'success' => true,
                'message' => __('keys.country_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }


    public function changeStatus(Country $country)
    {
        $this->countryService->toggleCountryStatus($country);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
