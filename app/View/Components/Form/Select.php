<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $title;
    public array $selects;

    /**
     * Select constructor.
     * @param $name
     * @param $selects
     */
    public function __construct($name, $selects, $title = null)
    {
        $this->name = $name;
        $this->title = $title;
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
