@extends('layouts.app')
@section('title', 'Modifier type de maison')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Modifier {{ $type_de_maison->tm_designation }}</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('type-maison.update', $type_de_maison->tm_id) }}" method="post" class="form d-flex flex-column gap-2">
                    @csrf
                    @method('PUT')

                    <div class="form-floating">
                        <input value="{{ $type_de_maison->tm_designation }}" type="text" name="designation" id="designation" class="form-control" placeholder="Designation">
                        <label for="designation">Designation</label>
                    </div>

                    <div class="form-floating mt-2">
                        <textarea type="text" name="description" id="description" class="form-control" placeholder="Description" rows="10">{{ $type_de_maison->tm_description }}</textarea>
                        <label for="description">Description</label>
                    </div>

                    <div class="form-floating mt-2">
                        <input value="{{ $type_de_maison->tm_duree_travaux }}" type="number" step="0.01" name="duree-travaux" id="duree-travaux" class="form-control" placeholder="Duree de travail">
                        <label for="duree-travaux">Duree travail</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection