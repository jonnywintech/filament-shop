<?php

namespace App\Livewire;

use App\Mail\Contact\Client;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactUs extends Component
{

    public string $first_name, $last_name, $email, $phone, $details;
    public bool|string $message_sent = '';

    public function submit()
    {
        $this->message_sent = '';
        $this->validate([
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|string|min:3|max:255',
            'phone' => 'required|string',
            'details' => 'required|string|min:3|max:1200',
        ]);
        try {
            Mail::to($this->email)->send(new Client($this->first_name, $this->last_name, $this->email, $this->phone, $this->details));
            $this->message_sent = true;
        } catch (\Exception $error) {
            $this->message_sent = false;
        }
        $this->cleanup();
    }

    public function cleanup()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->details = '';
    }

    public function render()
    {
        return view('livewire.contact-us');
    }
}
