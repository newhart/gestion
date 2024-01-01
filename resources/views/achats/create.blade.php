@extends('layout')

@section('content')
    <div class="container">
        @livewire('add-new-entry', ['id' => $bonde->id, 'type' => $type])
    </div>
@endsection
