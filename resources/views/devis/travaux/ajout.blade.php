@extends('layouts.app')

@section('title', 'Ajouter travaux pour devis')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Ajout de travaux
        </h3>
    </div>

    <div class="card-body">
        <form action="">
            <div class="form-floating">
                <select class="form-control" name="type-travil" id="type-travail">
                    @foreach ($type_de_travaux as $type_de_travail)
                        <option value="{{ $type_de_travail->tt_id }}">{{ $type_de_travail->tt_designation }}</option>
                    @endforeach
                </select>
                <label for="type-travail">Type de travail</label>
            </div>

            <div class="form-floating mt-2">
                <input type="text" name="designation" id="designation" class="form-control">
                <label for="designation">Designation</label>
            </div>

            <div class="form-floating mt-2">
                <input type="text" name="code" id="code" class="form-control">
                <label for="code">Code details</label>
            </div>

            <div class="form-floating mt-2">
                <select name="unite" id="unite" class="form-control">
                    @foreach ($unites as $unite)
                        <option value="{{ $unite->ut_id }}">{{ $unite->ut_designation }}</option>
                    @endforeach
                </select>
                <label for="unite">Unite</label>
            </div>
        </form>
    </div>
</div>
@endsection