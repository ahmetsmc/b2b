<?php

namespace App\View\Components\Dashboard\Form\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public       $name,
        public array $options,
        public       $hideLabel = false,
        public       $label = "",
        public       $class = "",
        public       $id = "",
        public       $selected = "",
        public bool  $required = false,
        public       $placeholder = "",
        public       $error = "",
        public       $groupClass = "",
    )
    {
        $this->class = "form-select" . $this->class;
        $this->id = !$this->id ? str($this->name . rand(1000000, 99999999))->camel() : $this->id;
        $this->groupClass = !$this->error ? "form-group" : "form-group invalid-form-group";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public
    function render(): View
    {
        return view('components.dashboard.form.inputs.select');
    }
}
