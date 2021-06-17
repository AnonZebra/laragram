<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Type of message.
     *
     * @var string
     */
    public $type;

    /**
     * Message to be displayed.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
