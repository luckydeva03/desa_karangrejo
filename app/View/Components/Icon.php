<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public $name;
    public $type;
    public $size;
    public $color;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $type = 'fontawesome', $size = '', $color = '', $class = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $this->color = $color;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.icon');
    }
}
