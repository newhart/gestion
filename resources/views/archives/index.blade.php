@extends('layout')

@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Gestion d'archive
            {{-- <span class="text-muted pt-2 font-size-sm d-block">Javascript array as data source</span> --}}
        </h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{route('ventes.create')}}" class="btn btn-primary font-weight-bolder">
           Ajouter</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        @livewire('list-archive')
    </div>
</div>
@endsection
