<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckEmail;

class ValidationController extends Controller
{
    public function isValidEmail(Request $request)
    {
        $validation = new CheckEmail();
        return $validation->checkEmail($request);
    }
}
