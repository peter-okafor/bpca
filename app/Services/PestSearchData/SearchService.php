<?php
namespace App\Services\PestSearchData;

use App\Models\Postcode;
use App\Models\SearchData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchService {

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function storeSession() {

        $session = Session::getId();

        $postcode = Postcode::whereTitle($this->request->postcode)->first();

        SearchData::create([
            'postcode_id' => $postcode->id,
            'service' => $this->request->pest,
            'session_id' => $session
        ]);
    }
}