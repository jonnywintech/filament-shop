<x-mail::message>
    # Hello and thank you for contacting us


    Your information and content of message

    - First Name: {{ $first_name }}
    - Last Name: {{ $last_name }}
    - Email: {{ $email }}
    - Phone: {{ $phone }}
    - Message:
    {{ $details }}

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
