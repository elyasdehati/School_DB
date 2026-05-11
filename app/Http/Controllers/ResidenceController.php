<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    public function AllResidence(){
        $res = Residence::all();
        return view('admin.pages.residence.all_residence', compact('res'));
    }

    public function AddResidence(){
        return view('admin.pages.residence.add_residence');
    }

    public function StoreResidence(Request $request){
        Residence::create([
            'name' => $request->name
        ]);

        return redirect()->route('all.residence');
    }

    public function EditResidence($id){
        $res = Residence::findOrFail($id);
        return view('admin.pages.residence.edit_residence', compact('res'));
    }

    public function UpdateResidence(Request $request, $id){
        $themtaic = Residence::findOrFail($id);

        $themtaic->update([
            'name' => $request->name
        ]);

        return redirect()->route('all.residence');
    }

    public function DeleteResidence($id){
        $res = Residence::findOrFail($id);
        $res->delete();

        return redirect()->route('all.residence');
    }
}
