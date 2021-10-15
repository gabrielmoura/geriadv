<?php

namespace App\View\Components\Bootstrap;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name, $type, $value, $placeholder, $title, $inputClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $name = 'modal')
    {
        $this->title = $title;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bootstrap.modal');
    }
}
