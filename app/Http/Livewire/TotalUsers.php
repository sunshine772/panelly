<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class TotalUsers extends Component
{
    public $totalUsers;
    public $userText;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->userText = $this->totalUsers === 1 ? 'usuario registrado' : 'usuarios registrados';
    }

    public function render()
    {
        return view('livewire.total-users');
    }
}
