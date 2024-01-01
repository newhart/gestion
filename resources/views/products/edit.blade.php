@extends('layout')

@section('content')
@livewire('edit-product' , ['id' => $product->id])
@endsection