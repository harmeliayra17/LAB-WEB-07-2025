@extends('layouts.master')

@section('content')
    <h2 class="text-3xl font-bold mb-6 text-center">Destinasi Wisata Unggulan Jogja</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @component('components.card')
            @slot('title') Candi Prambanan @endslot
            @slot('description') Datang siang disini panas banget buset. @endslot
            @slot('image') {{ asset('images/prambanan.jpg') }} @endslot
        @endcomponent

        @component('components.card')
            @slot('title') Malioboro @endslot
            @slot('description') Kalo ke sini mending pagi pas jam kerja enak buat jogging ga gitu ramai. @endslot
            @slot('image') {{ asset('images/malioboro.jpg') }} @endslot
        @endcomponent

        @component('components.card')
            @slot('title') Pantai Parangtritis @endslot
            @slot('description') Lumayan jauh sih dari Jogja pusat tapi okelah pantainya @endslot
            @slot('image') {{ asset('images/parangtritis.jpg') }} @endslot
        @endcomponent
    </div>
@endsection