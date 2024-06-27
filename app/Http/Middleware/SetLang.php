<?php

namespace App\Http\Middleware;

use App\Language;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SetLang
{
    public function handle($request, Closure $next)
    {
        $defaultLang =  \Cache::remember('lang_key', 60 * 60, function () {
            try {
                return \App\Models\Language::where('default',1)->first();
            } catch (\Exception $exception) {
                return null;
            }
        });

        if (session()->has('lang')) {
            $current_lang = \App\Models\Language::where('slug',session()->get('lang'))->first();
            if (!empty($current_lang)){
                Carbon::setLocale($current_lang->slug);
                app()->setLocale($current_lang->slug);
            }else {
                session()->forget('lang');
            }
        }else{
            app()->setLocale($defaultLang->slug);
            Carbon::setLocale($defaultLang->slug);
        }
        return $next($request);
    }
}
