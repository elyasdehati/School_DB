<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function AllLanguage(){
        $language = Language::all();
        return view('admin.pages.language.all_languages', compact('language'));
    }

    public function AddLanguage(){
        return view('admin.pages.language.add_language');
    }

     public function StoreLanguage(Request $request){
        Language::create([
            'name' => $request->name
        ]);

        return redirect()->route('all.language');
    }

    public function EditLanguage($id){
        $language = Language::findOrFail($id);
        return view('admin.pages.language.edit_language', compact('language'));
    }

    public function UpdateLanguage(Request $request, $id){
        $language = Language::findOrFail($id);

        $language->update([
            'name' => $request->name
        ]);

        return redirect()->route('all.language');
    }

    public function DeleteLanguage($id){
        $language = Language::findOrFail($id);
        $language->delete();

        return redirect()->route('all.language');
    }
}
