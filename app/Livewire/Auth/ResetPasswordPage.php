<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordPage extends Component
{

    public string $token;
    #[Url]
    public string  $email;
    public string  $password, $password_confirmation;

    public function mount(string $token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate([
            'token' => 'required',
            'email' => 'required|max:255|email',
            'password' => 'required|min:8|max:255|string',
            'password_confirmation' => 'required|same:password',
        ]);
        $status = Password::reset(
            ['email' => $this->email, 'password' => $this->password,
            'password_confirmation' => $this->password_confirmation, 'token' => $this->token],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->intended()->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
