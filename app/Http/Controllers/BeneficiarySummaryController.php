<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeneficiarySummaryController extends Controller
{
    public function AllBeneficiarySummary(){
        return view('admin.pages.ben_summary.all_summary');
    }
}
