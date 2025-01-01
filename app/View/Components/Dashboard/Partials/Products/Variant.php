<?php

namespace App\View\Components\Dashboard\Partials\Products;

use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Variant extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $class = "",
        public null|ProductVariant $variant = null,
    )
    {
        $this->class = "variant-item " . $this->class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.dashboard.partials.products.variant');
    }
}
