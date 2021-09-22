@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => null])
            {{ 'Dynamic SMTP Laravel' }}
        @endcomponent
    @endslot

    {{-- Body --}}
    <!-- Body here -->

    {{-- Subcopy --}}
    @slot('subcopy')
        @component('mail::subcopy')
            Hi, {{ $user_name ?? 'Your name' }}
        @endcomponent
        @component('mail::subcopy')
            Thanks for using dynamic smtp
        @endcomponent
    @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
