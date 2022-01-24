<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $value, $name, $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $title, $value = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.text-area');
    }
}
