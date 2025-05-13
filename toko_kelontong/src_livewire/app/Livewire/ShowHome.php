<?php

namespace App\Livewire;

use App\Models\Footer;
use Livewire\Component;

class ShowHome extends Component
{

    public $footers;

    public function mount(){
        $this->footers= Footer::first();
    }

    public function render()
    {
        return view('livewire.show-home', ['footers'=>'name']);
    }
}
