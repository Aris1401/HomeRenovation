@extends('layouts.app')

@section('title', 'Succes import')

@section('content')
    <div class="alert alert-success p-3">
        <h4 class="alert-heading">
            Succes!
        </h4>


        <p>L'import de {{ $nombres_lignes }} lignes effectuer avec succes.</p>

        @isset($last_route)
            <a class="btn btn-outline-dark" href="{{ route($last_route) }}">Retour</a>
        @endisset
    </div>
@endsection