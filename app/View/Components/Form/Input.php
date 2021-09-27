<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

/**
 * Class Input
 * @package App\View\Components\Form
 */
class Input extends Component
{

    /**
     * @var
     */
    public $name, $type, $value, $placeholder, $title, $inputClass;


    /**
     * Input constructor.
     * @param $name
     * @param string $type
     * @param false $value
     * @param null $placeholder
     * @param false $title
     * @param false $inputClass
     */
    public function __construct($name, $type = 'text', $value = false, $placeholder = null, $title = false, $inputClass = false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->inputClass = $inputClass;
    }


    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Support\Htmlable|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
