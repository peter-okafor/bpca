<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ExpandSearch extends Component
{
    public $expandSearchUrl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $currentUrl = request()->url();
        $queryParams = request()->query();

        $pest = $queryParams['pest'] ?? null;
        $postcode = $queryParams['postcode'] ?? null;
        $path = request()->path();
        $this->expandSearchUrl = route('expand-search', ['pest' => $pest, 'postcode' => $postcode, 'path' => $path]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.primary.expand-search');
    }
}
