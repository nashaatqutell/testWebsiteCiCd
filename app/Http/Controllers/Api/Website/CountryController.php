<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __invoke(Request $request)
    {
        $countries = Country::whereIsActive()->filter()->latest()->get();
        return $this->successResponse(CountryResource::collection($countries));
    }
}
