@extends('layouts.master')

@section('title', 'Kuliner Khas Tashkent')

@section('content')
    <h2>Kuliner Khas Tashkent</h2>
    <p>Sebagai ibu kota, Tashkent menawarkan beragam kuliner nasional Uzbekistan.</p>

    <div class="card-container">
        <x-card 
            image="plov.jpg" 
            title="Tashkent Plov" 
            description="Varian plov (nasi pilaf) khas ibu kota, hidangan nasi, daging, wortel, dan buncis yang wajib dicoba di Plov Center." 
        />
        
        <x-card 
            image="shashlik.jpg" 
            title="Shashlik" 
            description="Sate daging domba, sapi, atau ayam yang dipanggang di atas bara api, disajikan dengan bawang dan roti pipih (non)." 
        />

        <x-card 
            image="lagman.jpg" 
            title="Lagman" 
            description="Sup mi tarik tangan yang kental dan kaya rasa, berisi daging dan sayuran. Pengaruh kuat dari masakan Uighur." 
        />
    </div>
@endsection