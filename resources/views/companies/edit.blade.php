@extends('layout')

@section('content')
@livewire('edit-company' , ['id' => $company->id])
@endsection