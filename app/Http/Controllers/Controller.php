<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Prefix to be used for view & route name for admin portal
     */
    protected $adminViewPrefix = 'portal';

    /**
     * Prefix to be used for view & route name for nomal user portal
     */
    protected $dashboardViewPrefix = 'dashboard';
}
