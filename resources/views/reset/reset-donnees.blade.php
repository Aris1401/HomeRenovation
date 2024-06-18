@extends('layouts.app')

@section('title', 'Reinitialiser les donnees de bases')

@section('content')
<div class="card">
    <div class="card-body d-flex justify-content-center flex-column align-items-center">
        <h5 class="text-center mt-3">Voulez-vous vraiment reinitialiser toutes les donnees de la base donnees?</h5>
        @error('failed')
            <p class="alert alert-danger">{{ $message }}</p>
        @enderror
        <a href="{{ route('reset-database') }}" class="btn btn-danger mb-3">Continuer</a>
    </div>
</div>
@endsection