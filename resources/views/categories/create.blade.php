@extends('layout')

@section('content')
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('categories.create')}}">Catégorie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('categories.sub.create')}}">Sous-catégorie</a>
            </li>
        </ul>
        @livewire('create-category')
    </div>
</div>

@endsection
