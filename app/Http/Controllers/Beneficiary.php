<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Beneficiary extends Controller
{
    public function AllBeneficiary(){
        return view('admin.pages.beneficiary.all_beneficiary');
    }
}
