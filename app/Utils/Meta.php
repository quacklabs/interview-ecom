<?php
namespace App\Utils;

use Currency\Util\CurrencySymbolUtil;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Exception;
use Illuminate\Support\Facades\Http;

class Meta {
    public static function money($value, $short = false,  $symbol = "USD") {
        $suffixes = ["", "K", "M", "B"];
        $suffixIndex = 0;
        $symbol = ($symbol != 'BTC') ? $symbol : 'USD';

        if($short) {
            while($value >= 1000 && $suffixIndex < count($suffixes) - 1) {
                $value /= 1000;
                $suffixIndex++;
            }
            return Meta::currency_symbol($symbol) . round($value, 2) . $suffixes[$suffixIndex];
        } else {
            return Meta::currency_symbol($symbol) . number_format($value, 2);
        }
    }

    public static function currency_symbol($code) {
        return CurrencySymbolUtil::getSymbol($code);
    }

    public static function vite_assets(): HtmlString
    {
        $devServerIsRunning = false;
     
        if (app()->environment('local')) {
            try {
                $server = Http::get("http://localhost:5173");
                if($server) {
                    $devServerIsRunning = true;
                }
            } catch (\Throwable $e) {
            }
        }
     
        if ($devServerIsRunning) {
    
            return new HtmlString(<<<HTML
                <script type="module" src="{{ env('APP_URL') }}/@vite/client"></script>
                <script type="module" src="{{ env('APP_URL') }}/resources/js/app.js"></script>
            HTML);
        }
     
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $css = $manifest['resources/js/main.ts']['css'][0];
        $js = $manifest['resources/js/main.ts']['file'];
     
        return new HtmlString(<<<HTML
            <link rel="stylesheet" type="text/css" rel="stylesheet" href="build/{$css}">
            <script type="module" src="build/{$js}"></script>
        HTML);
    }    
}