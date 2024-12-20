<?php

namespace App\View\Components\Dashboard\Form\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Number extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public          $name,
        public          $hideLabel = false,
        public          $label = "",
        public          $placeholder = "",
        public          $class = "",
        public          $id = "",
        public          $value = "",
        public bool     $required = false,
        public          $error = "",
        public          $groupClass = "",
        public null|int $max = null,
        public null|int $min = null,
    )
    {
        $this->class = "form-control form-numeric-control" . $this->class;
        $this->label = !$this->label ? $this->placeholder : $this->label;
        $this->id = !$this->id ? str($this->name . rand(1000000, 99999999))->camel() : $this->id;
        $this->groupClass = !$this->error ? "form-group" : "form-group invalid-form-group";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public
    function render(): View|Closure|string
    {
        return view('components.dashboard.form.inputs.number');
    }
}
