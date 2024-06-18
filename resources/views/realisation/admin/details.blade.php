@extends('layouts.app')

@section('title', 'Details')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h3>Travaux</h3>

                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Designation</th>
                            <th>Unite</th>
                            <th>Quantite</th>
                            <th>Prix Unitaire</th>
                            <th>Montant</th>
                        </tr>
                    </thead>

                    <tbody>

                            @foreach ($details_travaux as $details)
                                <tr>
                                    <td>{{ $details->dr_code_details }}</td>
                                    <td>{{ $details-> dr_designation}}</td>
                                    <td>{{ $details->unite->ut_designation }}</td>
                                    <td>{{ $details->dr_quantite }}</td>
                                    <td>{{ number_format($details->dr_prix_unitaire, 2, ',', ' ') }} Ar</td>
                                    <td>{{ number_format($details->dr_montant_total, 2, ',', ' ') }} Ar</td>
                                </tr>
                            @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h3>Paiements</h3>

                <div>
                    <p class="m-0">Total a payer: {{ $avancement_paiement->montant_a_payer }} Ar</p>
                    <p class="m-0">Deja payer: {{ $avancement_paiement->total_deja_payer }} Ar</p>
                    <p class="m-0">Reste a payer: {{ $avancement_paiement->reste_a_payer }} Ar</p>
                </div>

                <table class="table table-responsive">

                </table>
            </div>
        </div>
    </div>
</div>
@endsection