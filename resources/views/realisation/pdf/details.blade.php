<style>
    table {
        border-collapse: collapse;
    }

    th {
        padding: 1rem;
    }

    td {
        padding: .4rem;
    }
</style>

<h1>Devis {{ $realisation_travaux->rt_ref_devis }}</h1>

<table class="table table-responsive" border="1">
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

            <tr>
                <td colspan="5">Total</td>
                <td>{{ number_format($realisation_travaux->rt_montant_total, 2, ',', ' ') }} Ar</td>
            </tr>
    </tbody>
</table>

<hr>

<table border="1">
    <thead>
        <tr>
            <th>Ref paiement</th>
            <th>Date de paiement</th>
            <th>Montant</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($paiements as $paiement_devis)
            <tr>
                <td>{{ $paiement_devis->pd_ref_paiement }}</td>
                <td>{{ $paiement_devis->pd_date_de_paiement }}</td>
                <td>{{ number_format($paiement_devis->pd_montant, 5, ',', ' ') }} Ar</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="2">Total</td>
            <td>{{ number_format($realisation_travaux->avancementPaiement->total_deja_payer, 5, ',', ' ') }} Ar</td>
        </tr>
    </tbody>
</table>