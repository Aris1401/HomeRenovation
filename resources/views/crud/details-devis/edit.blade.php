@extends('layouts.app')
@section('title', 'Modifier details devis')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Creer unite</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <form action="{{ route('details-devis.update', $details_devis->dd_id) }}" method="post"
                        class="form d-flex flex-column gap-2">
                        @csrf
                        @method('PUT')

                        {{-- 'dd_designation',
                        'dd_code_details',
                        'dd_id_unite',
                        'dd_quantite',
                        'dd_prix_unitaire' --}}

                        <div class="form-floating">
                            <input type="text" name="dd_designation" id="dd_designation" class="form-control"
                                value="{{ $details_devis->dd_designation }}">
                            <label for="dd_designation">Designation</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" name="dd_code_details" id="dd_code_details" class="form-control"
                                value="{{ $details_devis->dd_code_details }}">
                            <label for="dd_code_details">Code details</label>
                        </div>

                        <div class="form-floating">
                            <select name="dd_id_unite" id="dd_id_unite" class="form-control">
                                @foreach ($unites as $unite)
                                    <option value="{{ $unite->ut_id }}" @if ($unite->ut_id == $details_devis->dd_id_unite) selected @endif>
                                        {{ $unite->ut_designation }}</option>
                                @endforeach
                            </select>
                            <label for="dd_id_unite">Unite</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" step="0.01" name="dd_quantite" id="dd_quantite" class="form-control"
                                value="{{ $details_devis->dd_quantite }}">
                            <label for="dd_quantite">Quantite</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" step="0.01" name="dd_prix_unitaire" id="dd_prix_unitaire"
                                class="form-control" value="{{ $details_devis->dd_prix_unitaire }}">
                            <label for="dd_prix_unitaire">Prix unitaire</label>
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


                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
