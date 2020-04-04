<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class UserExistingController extends UserController
{
    
    public function __construct()
    {
        parent::__construct();
    }

    private function getMyFeedbacks(Request $request)
    {

    }
}
