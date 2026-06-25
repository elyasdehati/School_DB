<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

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

        ActivityLogger::log(
            'create_language',
            'Language created: ' . $request->name
        );

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

        ActivityLogger::log(
            'update_language',
            'Language updated ID: ' . $id
        );

        return redirect()->route('all.language');
    }

    public function DeleteLanguage($id){
        $language = Language::findOrFail($id);

        ActivityLogger::log(
            'delete_language',
            'Language deleted ID: ' . $id
        );

        $language->delete();

        return redirect()->route('all.language');
    }
}