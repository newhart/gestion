@extends('layout')

@section('content')
@livewire('edit-membre' , ['id' => $user->id])
@endsection