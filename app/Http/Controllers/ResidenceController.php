<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

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

        ActivityLogger::log(
            'create_residence',
            'Residence created: ' . $request->name
        );

        return redirect()->route('all.residence');
    }

    public function EditResidence($id){
        $res = Residence::findOrFail($id);
        return view('admin.pages.residence.edit_residence', compact('res'));
    }

    public function UpdateResidence(Request $request, $id){
        $res = Residence::findOrFail($id);

        $res->update([
            'name' => $request->name
        ]);

        ActivityLogger::log(
            'update_residence',
            'Residence updated ID: ' . $id
        );

        return redirect()->route('all.residence');
    }

    public function DeleteResidence($id){
        $res = Residence::findOrFail($id);

        ActivityLogger::log(
            'delete_residence',
            'Residence deleted ID: ' . $id
        );

        $res->delete();

        return redirect()->route('all.residence');
    }
}