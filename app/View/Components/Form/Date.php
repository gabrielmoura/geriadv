<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Date extends Component
{
    public $name, $title,$value;



    public function __construct($name, $title = false,$value=null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.date');
    }
}
