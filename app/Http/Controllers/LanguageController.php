<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Change the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(Request $request)
    {
        $lang = $request->lang;
        
        // Validate language (only allow 'en' or 'fr')
        if (in_array($lang, ['en', 'fr'])) {
            App::setLocale($lang);
            session()->put('locale', $lang);
        }
        
        return redirect()->back();
    }
}
