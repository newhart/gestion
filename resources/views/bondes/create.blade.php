@extends('layout')

@section('content')
    <div class="card">
        <div class="card-body">
            @livewire('create-bonde' , ['type' => $type])
        </div>
    </div>

@endsection
