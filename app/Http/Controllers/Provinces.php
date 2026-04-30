<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\District;
use Illuminate\Http\Request;

class Provinces extends Controller
{

    // -----------  Province ----------
    public function AllProvinces(){
        $provinces = Province::with('districts')->get();
        return view('admin.pages.provinces.all_provinces', compact('provinces'));
    }

    public function AddProvince(){
        return view('admin.pages.provinces.add_province');
    }

    public function StoreProvince(Request $request){
        $province = Province::create([
            'name' => $request->province
        ]);

        $districts = json_decode($request->districts[0], true);

        if ($districts) {
            foreach ($districts as $district) {
                District::create([
                    'province_id' => $province->id,
                    'name' => $district
                ]);
            }
        }

        return redirect()->route('all.provinces');
    }

    public function EditProvince($id){
        $province = Province::with('districts')->findOrFail($id);
        return view('admin.pages.provinces.edit_province', compact('province'));
    }

    public function UpdateProvince(Request $request, $id){
        $province = Province::findOrFail($id);

        $province->update([
            'name' => $request->province
        ]);

        District::where('province_id', $province->id)->delete();

        $districts = json_decode($request->districts[0], true);

        if($districts){
            foreach($districts as $district){
                District::create([
                    'province_id' => $province->id,
                    'name' => $district
                ]);
            }
        }

        return redirect()->route('all.provinces');
    }

    public function DeleteProvince($id){
        $province = Province::findOrFail($id);
        $province->delete();

        return redirect()->route('all.provinces');
    }
}
