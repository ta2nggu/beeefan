<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class SubscriptionController extends Controller
{
    //
    public function paymentMethod_store(Request $request) {
        try
        {
            return var_dump($request);
            return "deleted";
        }
        catch(Exception $ex)
        {
            //Log errror
            return "failed";
        }
    }
}
