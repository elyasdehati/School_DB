<?php

namespace App\Http\Controllers;

use App\Models\ThematicArea;
use Illuminate\Http\Request;

class ThematicAreaController extends Controller
{
    public function AllThematicArea(){
        $themtaic = ThematicArea::all();
        return view('admin.pages.thematic.all_thematic', compact('themtaic'));
    }

    public function AddThematicArea(){
        return view('admin.pages.thematic.add_thematic');
    }

    public function StoreThematicArea(Request $request){
        ThematicArea::create([
            'name' => $request->name
        ]);

        return redirect()->route('all.thematic.area');
    }

    public function EditThematicArea($id){
        $themtaic = ThematicArea::findOrFail($id);
        return view('admin.pages.thematic.edit_thematic', compact('themtaic'));
    }

    public function UpdateThematicArea(Request $request, $id){
        $themtaic = ThematicArea::findOrFail($id);

        $themtaic->update([
            'name' => $request->name
        ]);

        return redirect()->route('all.thematic.area');
    }

    public function DeleteThematicArea($id){
        $themtaic = ThematicArea::findOrFail($id);
        $themtaic->delete();

        return redirect()->route('all.thematic.area');
    }
}
