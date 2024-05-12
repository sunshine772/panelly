<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $userId;
    public $editMode = false;

    protected $rules = [
        'name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'password' => 'required',
        'email' => 'required|email',
    ];

    public function storeUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);

        session()->flash('user-message', 'Usuario creado exitosamente');
    }

    public function showUserModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }

    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode = true;

        $this->userId = $id;

        $this->loadUser();

        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'show']);
    }

    public function loadUser()
    {
        $user = User::find($this->userId);

        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $user = User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);

        session()->flash('user-message', 'Usuario actualizado exitosamente');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        session()->flash('user-message', 'Usuario eliminado exitosamente');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal', ['modalId' => '#userModal', 'actionModal' => 'hide']);
        $this->reset();
    }

    public function render()
    {
        $users = User::paginate(5);
        if (strlen($this->search) > 2) {
            $users = User::where('name', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.users.user-index', [
            'users' => $users
        ])->layout('layouts.main');
    }
}

