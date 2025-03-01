<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('customer-service.index', [
            'noTelpon' => \App\Models\User::role('admin')->first()->no_telpon,
        ]);
    }
}
