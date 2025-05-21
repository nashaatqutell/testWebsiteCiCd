<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait WebResponse
{

    public function webSuccessResponse(string $route, string $message = '', $alertType = 'success'): RedirectResponse
    {
        return to_route($route)->with(array(
            'message' => $message,
            'alert-type' => $alertType
        ));
    }

    public function webDataResponse(string $route, $data, string $message = '', $alertType = 'success'): RedirectResponse
    {
        return to_route($route, $data)->with(array(
            'message' => $message,
            'alert-type' => $alertType
        ));
    }
}
