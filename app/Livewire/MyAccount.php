<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class MyAccount extends Component
{
    public string $name, $email, $old_password, $new_password, $new_password_confirm;
    public array $notifications = [];

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateInfo()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|min:3|max:255'
        ]);

        $user = auth()->user();
        $user->update(['name' => $this->name, 'email' => $this->email]);

        $this->addNotification('Successfully updated user info.', 'success');
    }

    public function updatePassword()
    {
        $this->validate([
            'old_password' => 'required|string|min:3|max:255',
            'new_password' => 'required|string|min:3|max:255',
            'new_password_confirm' => 'required|string|same:new_password'
        ]);

        $user = auth()->user();

        if (Hash::check($this->old_password, $user->password)) {
            $user->password = Hash::make($this->new_password);
            $user->save();

            $this->addNotification('Successfully updated password.', 'success');
            $this->old_password = '';
            $this->new_password = '';
            $this->new_password_confirm = '';
        } else {
            $this->addNotification('Current password is incorrect.', 'error');
        }
    }

    public function addNotification($message, $type)
    {
        $this->notifications[] = [
            'message' => $message,
            'type' => $type,
            'id' => uniqid()
        ];
    }

    public function removeNotification($id)
    {
        $this->notifications = array_filter($this->notifications, function($notification) use ($id) {
            return $notification['id'] !== $id;
        });
    }

    public function render()
    {
        return view('livewire.my-account');
    }
}
