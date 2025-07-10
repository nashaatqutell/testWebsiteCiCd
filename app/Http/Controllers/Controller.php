<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use App\Traits\WebResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ApiResponse ,WebResponse;
}
