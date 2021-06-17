<?php

namespace App\Http\Controllers\Locale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{

    private array $allowedLocales = ['ja', 'en', 'sv'];

    /**
     * inspired by
     * https://medium.com/swlh/laravel-localization-and-
     * multi-language-functionality-in-web-554ca8dfa7e8
     * @param string $language
     */
    public function updateLocale($language)
    {
        if (in_array($language, $this->allowedLocales)) {
            session(['locale' => $language]);
        }

        return back();
    }
}
