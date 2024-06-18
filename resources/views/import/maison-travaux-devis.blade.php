@extends('layouts.app')

@section('title', 'Import type de maison')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Import de donnees
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('import.maison-travaux.inserer') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="maison-travaux">Maison Travaux</label>
                    <input type="file" name="maison-travaux" id="maison-travaux" class="form-control">
                </div>

                <div class="form-group mt-3">
                    <label for="maison-travaux">Devis</label>
                    <input type="file" name="devis" id="devis" class="form-control">
                </div>


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <input type="submit" value="Importer donnees" class="btn btn-primary mt-3">
            </form>
        </div>
    </div>
@endsection
