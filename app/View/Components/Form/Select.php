<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public array $selects;

    /**
     * Select constructor.
     * @param $name
     * @param $selects
     */
    public function __construct($name, $selects)
    {
        $this->name = $name;
        $this->selects = arrayToObject($selects);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
