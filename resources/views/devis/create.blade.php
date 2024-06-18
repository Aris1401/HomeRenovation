@extends('layouts.app')

@section('title', 'Creer devis')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Creation de devis
        </h3>
    </div>

    <div class="card-body">
        <form action="{{ route('devis.store') }}" method="POST">
            @csrf
            <div class="form-floating">
                <input type="datetime-local" name="date-ajout" id="date-ajout" class="form-control">
                <label for="date-ajout">Date ajout de devis</label>
            </div>

            <div class="form-floating mt-2">
                <select name="type-maison" id="type-maison" class="form-control">
                    @foreach ($type_de_maisons as $type_de_maison)
                        <option value="{{ $type_de_maison->tm_id }}">{{ $type_de_maison->tm_designation }}</option>
                    @endforeach
                </select>
                <label for="type-maison">Type de maison</label>
            </div>

            <div class="form-floating mt-2">
                <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation devis">
                <label for="designation">Designation devis</label>
            </div>

            <div class="row mt-2">
                <div class="col">
                    <input type="submit" class="btn btn-primary" value="Ajouter devis">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection