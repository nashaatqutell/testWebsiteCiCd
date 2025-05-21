<?php

namespace App\Http\Controllers;
use App\Traits\WebResponse;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\ApiResponse;

abstract class Controller  extends BaseController
{
    use ApiResponse ,WebResponse;
}
