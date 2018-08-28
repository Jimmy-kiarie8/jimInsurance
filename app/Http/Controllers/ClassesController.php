<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InsuranceClass;
use App\InsuranceType;
use App\PolicyStatus;

class ClassesController extends Controller
{
    public function getStatus()
    {
        return PolicyStatus::all();
    }
    public function getinsuranceClass()
    {
        return InsuranceClass::all();
    }
    public function getinsuranceType()
    {
        return InsuranceType::all();
    }
}
