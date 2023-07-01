<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        if ($request->user()) {
            $message = "Welcome back " . $request->user()->name . "! Your current role is " . $request->user()->getRoleNames() . " Great to have you back.";
        } else {
            $message = "Welcome to the /home page. You are not registered on the website.";
        }
        
        return response()->json(['message' => $message]);
    }
}
