<?php

namespace App\Service;

use App\Models\Country\Country;
use Illuminate\Http\Request;

class CountryService
{
    public function getAllCountries($query)
    {
        $countriesQuery = Country::filter()->latest();
        return $query === 'paginate' ? $countriesQuery->paginate(10) : $countriesQuery->get();
    }

    public function listCountries()
    {
        return Country::latest()->get();
    }

    public function storeCountry($data)
    {
        $country = Country::create($data + ['added_by_id' => auth()->user()->id]);

        if (isset($data['image'])) {
            $country->storeImages(media: $data['image'], collection: 'country_images');
        }

        return $country;
    }

    public function updateCountry(Country $country, $data)
    {
        $country->update($data);

        if (isset($data['image'])) {
            $country->storeImages(media: $data['image'], update: true, collection: 'country_images');
        }

        return $country;
    }

    public function deleteCountry(Country $country)
    {
        $country->delete();
        $country->clearMediaCollection('country_images');
    }

    public function toggleCountryStatus(Country $country)
    {
        $country->toggleActivation();
    }
}
