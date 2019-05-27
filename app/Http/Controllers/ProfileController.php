<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipment;

class ProfileController extends Controller
{
    public function todayShopments()
    {
        Shipment::all();
    }
}
