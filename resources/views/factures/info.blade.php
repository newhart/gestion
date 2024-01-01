@extends('layout')

@section('content')

    <!--begin::Container-->
    <div class="container">
        @livewire('create-info-facture' , ['facture' => $facture])
    </div>
    <!--end::Container-->

@endsection
