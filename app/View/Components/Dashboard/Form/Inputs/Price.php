<?php

namespace App\View\Components\Dashboard\Form\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Price extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public      $name,
        public      $hideLabel = false,
        public      $label = "",
        public      $placeholder = "",
        public      $class = "",
        public      $id = "",
        public      $value = "",
        public bool $required = false,
        public      $error = "",
        public      $groupClass = ""
    )
    {
        $this->class = "form-control price-control " . $this->class;
        $this->label = !$this->label ? $this->placeholder : $this->label;
        $this->id = !$this->id ? str(str($this->name . rand(1000000, 99999999))->slug('_'))->camel() : $this->id;
        $this->groupClass = !$this->error ? "form-group" : "form-group invalid-form-group";
        $this->value = !$this->value ? old($this->name) : $this->value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.form.inputs.price');
    }
}
