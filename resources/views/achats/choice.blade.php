@extends('layout')

@section('content')
<div class="card card-custom">
    <div class="card-body text-center">
        <a href="{{route('bonde.create')}}" class="btn btn-primary">Ajout de stock</a>
        <a href="{{route('products.create')}}" class="btn btn-secondary mx-4">Nouveau produit</a>
    </div>
</div>
{{-- @livewire('create-entry') --}}
@endsection
