<?php

namespace Modules\Support\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AppController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
