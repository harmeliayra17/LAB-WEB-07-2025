@extends('layouts.app')

@section('content')
<h1>Edit Ikan: {{ $fish->name }}</h1>

@include('fishes.form', ['fish' => $fish])
@endsection
