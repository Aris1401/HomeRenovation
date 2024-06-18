@extends('layouts.app')

@section('title', 'Mes Realisations')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Realisations</h3>
        </div>

        <div class="card-body">
            @if ($realisations->count() == 0)
                <p>Vous n'aviez aucun en cours.</p>
            @else
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Contact utilisateur</th>
                            <th>Ref. devis</th>
                            <th>Type de maison</th>
                            <th>Type de finition</th>
                            <th>Date ajout realisation</th>
                            <th>Duree de travail</th>
                            <th>Date debut travaux</th>
                            <th>Date fin travaux</th>
                            <th>Montant</th>
                            <th>Montant deja payer</th>
                            <th>Pourcentage deja payer</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($realisations as $realisation)
                            <tr>
                                <td>
                                    @if ($realisation->utilisateur)
                                        {{ $realisation->utilisateur->u_contact }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $realisation->rt_ref_devis }}</td>
                                <td>{{ $realisation->typeDeMaison->tm_designation }}</td>
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
                                        {{ number_format($realisation->rt_montant_total, 2, '.', ' ') }} Ar
                                        (+{{ $realisation->rt_augmentation }}%)
                                    </strong>
                                </td>
                                <td>
                                    <p
                                        @if ($realisation->avancementPaiement->pourcentage_deja_payer > 50.0)
                                            style="color: green"
                                        @elseif ($realisation->avancementPaiement->pourcentage_deja_payer < 50.0)
                                            style="color: red"
                                        @endif
                                    >
                                        {{ number_format($realisation->avancementPaiement->total_deja_payer, 2, '.', ' ') }} Ar
                                    </p>
                                </td>
                                <td>
                                    {{ number_format($realisation->avancementPaiement->pourcentage_deja_payer, 2, '.', ' ') }}
                                    %
                                </td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ route('realisations.admin.details', $realisation->rt_id) }}">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div>
                {{ $realisations->links() }}
            </div>
        </div>
    </div>
@endsection
