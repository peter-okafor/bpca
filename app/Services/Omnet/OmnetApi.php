<?php
namespace App\Services\Omnet;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OmnetApi
{
    public static function getControllerInfo(string|int $id)
    {
        try {
            if (!is_numeric($id)) {
                return [];
            }
    
            $url = OmnetUrls::PESTCONTROLLER_URL.$id;
            $pestcontroller = Http::get($url);
    
            return $pestcontroller->json();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        
        return [];
    }
}
