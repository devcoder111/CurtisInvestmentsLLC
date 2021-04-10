@component('mail::message')
    # Contact Message

    You have a contact message from {{ $name }} - {{ $email }}

    Subject: {{ $subject }}

    Message: {{ $body }}

    Thanks
@endcomponent
