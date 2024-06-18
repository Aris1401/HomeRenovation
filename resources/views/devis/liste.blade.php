@extends('layouts.app')

@section('title', 'Liste des devis')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Liste des devis
        </h3>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-end">
            <a href="{{ route('devis.create') }}" class="btn btn-primary">Ajouter devis</a>
        </div>

        <table class="table table-responsive mt-2">
            <thead>
                <tr>
                    <th>Date ajout devis</th>
                    <th>Type de maison</th>
                    <th>Montant total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devises as $devis)
                    <tr>
                        <td>{{ $devis->d_date_ajout }}</td>
                        <td>{{ $devis->typeDeMaison->tm_designation }}</td>
                        <td>{{ number_format($devis->d_montant_total, 2, ',', ' ') }} Ar</td>
                        <td>
                            <a href="{{ route('devis.show', $devis->d_id) }}" class="btn btn-primary">Afficher plus de details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection