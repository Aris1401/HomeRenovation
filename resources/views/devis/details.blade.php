@extends('layouts.app')

@section('title', 'Details devis')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Details devise - Num. {{ str_pad($devis->d_id, 4, '0', STR_PAD_LEFT) }}
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between">
                    <h3>Travaux</h3>

                    <a href="{{ route('devis.travaux.ajout', $devis->d_id) }}" class="btn btn-primary">Ajouter travaux</a>
                </div>

                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Unite</th>
                            <th>Quantite</th>
                            <th>Prix unitaire</th>
                            <th>Montant total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($travaux as $details_devis)
                            <tr>
                                <td>{{ $details_devis->dd_code_details }}</td>
                                <td>{{ $details_devis->dd_designation }}</td>
                                <td>{{ $details_devis->unite->ut_designation }}</td>
                                <td>{{ number_format($details_devis->dd_quantite, 2, ',', '') }}</td>
                                <td>{{ number_format($details_devis->dd_prix_unitaire, 2, ',', ' ') }} Ar</td>
                                <td>{{ number_format($details_devis->dd_montant_total, 2, ',', ' ') }} Ar</td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td colspan="5">Total montant</td>
                            <td>
                                <strong>
                                    {{ number_format($devis->d_montant_total, 2, ',', ' ') }} Ar
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection