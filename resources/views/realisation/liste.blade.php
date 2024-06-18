@extends('layouts.app')

@section('title', 'Mes Realisations')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Mes realisations</h3>
    </div>

    <div class="card-body">
        @if($realisations->count() == 0)
            <p>Vous n'aviez aucun realisation en cours.</p>
        @else    
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Type de maison</th>
                        <th>Lieu</th>
                        <th>Type de finition</th>
                        <th>Date ajout realisation</th>
                        <th>Duree de travail</th>
                        <th>Date debut travaux</th>
                        <th>Date fin travaux</th>
                        <th>Montant</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($realisations as $realisation)
                        <tr>
                            <td>{{ $realisation->typeDeMaison->tm_designation }}</td>
                            <td>{{ $realisation->rt_lieu }}</td>
                            <td>
                                <p class="badge bg-primary">
                                    {{ $realisation->typeDeFinition->tf_designation }}
                                </p>
                            </td>
                            <td>{{ $realisation->rt_date_ajout_realisation }}</td>
                            <td>{{ $realisation->rt_duree_travail }} jours</td>
                            <td>{{ $realisation->rt_date_debut_travaux }}</td>
                            <td>{{ $realisation->rt_date_fin_travaux }}</td>
                            <td>
                                <strong>
                                    {{ number_format($realisation->rt_montant_total, 2, '.', ' ') }} Ar (+{{ $realisation->rt_augmentation }}%)
                                </strong>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('realisation.paiement', $realisation->rt_id) }}">Ajouter paiement</a>
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{ route('realisation.export', $realisation->rt_id) }}">Afficher details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
