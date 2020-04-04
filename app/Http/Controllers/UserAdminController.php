<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

class UserAdminController extends UserController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function getAllUsers(Request $request) {
        
    }

    private function getAllUsersFeedback(Request $request) {
        
    }

    private function respondToUserFeedback(Request $request) {
        
    }

    private function blockAccount(Request $request) {

    }

    private function removeAccount(Request $request) {

    }

    private function blockBulkAccount(Request $request) {

    }

    private function removeBulkAccount(Request $request) {

    }
}
