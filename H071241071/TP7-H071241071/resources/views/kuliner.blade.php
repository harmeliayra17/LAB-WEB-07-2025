@extends('layouts.master')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center">Kuliner Khas Jogja</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @component('components.card')
            @slot('title') Gudeg @endslot
            @slot('description') Sayur gori(nangka) nya enak tergantung yang masak, krecek(krupuk kulit) mantep woilah @endslot
            @slot('image') {{ asset('images/gudeg.jpg') }} @endslot
        @endcomponent

        @component('components.card')
            @slot('title') Bakpia @endslot
            @slot('description') Aku prefer yang isi keju sih udah bosen sama yang kacang hijau @endslot
            @slot('image') {{ asset('images/bakpia.jpg') }} @endslot
        @endcomponent

        @component('components.card')
            @slot('title') Sate Klathak @endslot
            @slot('description') Ya sate........................ @endslot
            @slot('image') {{ asset('images/sate-klathak.jpg') }} @endslot
        @endcomponent
    </div>
@endsection