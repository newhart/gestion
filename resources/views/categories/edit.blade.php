@extends('layout')

@section('content')
@livewire('edit-category' , ['id' => $category->id])
@endsection