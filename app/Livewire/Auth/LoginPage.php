<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('Login')]
class LoginPage extends Component
{

    public string $email, $password;

    public function login()
    {

        $credentials = $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended();
        } else {
            $this->addError('email', 'Invalid credentials');
            return redirect()->back();
        };
    }

    public function render()
    {

        return view('livewire.auth.login-page');
    }
}
