<?php

namespace App\Http\Controllers;

use App\Models\Infastractor;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class InfastractorController extends Controller
{
    public function AllInfas(){
        $infas = Infastractor::latest()->get();
        return view('admin.pages.infastractor.all_infas', compact('infas'));
    }

    public function AddInfas(){
        return view('admin.pages.infastractor.add_infas');
    }

    public function StoreInfas(Request $request){
        Infastractor::create([
            'name' => $request->name
        ]);

        ActivityLogger::log(
            'create_infastractor',
            'Infastractor created: ' . $request->name
        );

        return redirect()->route('all.infas');
    }

    public function EditInfas($id){
        $infas = Infastractor::findOrFail($id);
        return view('admin.pages.infastractor.edit_infas', compact('infas'));
    }

    public function UpdateInfas(Request $request, $id){
        $infas = Infastractor::findOrFail($id);

        $infas->update([
            'name' => $request->name
        ]);

        ActivityLogger::log(
            'update_infastractor',
            'Infastractor updated ID: ' . $id
        );

        return redirect()->route('all.infas');
    }

    public function DeleteInfas($id){
        $infas = Infastractor::findOrFail($id);

        ActivityLogger::log(
            'delete_infastractor',
            'Infastractor deleted ID: ' . $id
        );

        $infas->delete();

        return redirect()->route('all.infas');
    }
}