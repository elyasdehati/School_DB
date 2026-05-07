<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use Illuminate\Http\Request;

class ClassTypeController extends Controller
{
    public function AllClassType(){
        $classtype = ClassType::all();
        return view('admin.pages.classtype.all_classtype', compact('classtype'));
    }

    public function AddClassType(){
        return view('admin.pages.classtype.add_classtype');
    }

    public function StoreClassType(Request $request){
        ClassType::create([
            'name' => $request->name
        ]);

        return redirect()->route('all.class.type');
    }

    public function EditLanguage($id){
        $classtype = ClassType::findOrFail($id);
        return view('admin.pages.classtype.edit_classtype', compact('classtype'));
    }

    public function UpdateLanguage(Request $request, $id){
        $classtype = ClassType::findOrFail($id);

        $classtype->update([
            'name' => $request->name
        ]);

        return redirect()->route('all.class.type');
    }

    public function DeleteLanguage($id){
        $classtype = ClassType::findOrFail($id);
        $classtype->delete();

        return redirect()->route('all.class.type');
    }
}
