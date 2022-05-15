<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormComponent extends Component
{
    public $asyncSearchUser = null;

    public $model = null;

    public $user_id = null;

    public $modelMultiple = [];

    public $currency = null;

    public function render()
    {
        return view('livewire.form-component');
    }
}
