@extends('layouts.app')

@section('title', 'Details devis')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Details devis</h5>
    </div>

    <div class="card-body">
        <div class="row mt-3">
            <div class="col d-flex flex-column">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Type travaux</th>
                            <th>Designation</th>
                            <th>Code details</th>
                            <th>Unite</th>
                            <th>Quantite</th>
                            <th>Prix unitaire</th>
                            <th>Montant total</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($details_devises as $details_devis)
                            <tr>
                                {{-- <th>Type travaux</th>
                                <th>Designation</th>
                                <th>Code details</th>
                                <th>Quantite</th>
                                <th>Prix unitaire</th>
                                <th>Montant total</th> --}}
                                <td>@if($details_devis->typeDeTravaux) {{ $details_devis->typeDeTravaux->tt_designation }} @else N/A @endif</td>
                                <td>{{ $details_devis->dd_designation }}</td>
                                <td>{{ $details_devis->dd_code_details }}</td>
                                <td>{{ number_format($details_devis->dd_quantite, 2, '.', ' ') }}</td>
                                <td>{{ $details_devis->unite->ut_designation }}</td>
                                <td>{{ number_format($details_devis->dd_prix_unitaire, 2, '.', ' ') }} Ar</td>
                                <td>
                                    <strong>
                                        {{ number_format($details_devis->dd_montant_total, 2, '.', ' ') }} Ar
                                    </strong>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('details-devis.edit', $details_devis->dd_id) }}" class="btn btn-primary">
                                            <i class="cil-pencil icon"></i>
                                        </a>

                                        <form action="{{ route('unites.delete', $details_devis->dd_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        
                                            <button type="submit" class="btn btn-danger">
                                                <i class="cil-trash icon"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $details_devises->links() }}
            </div>
        </div>
    </div>
</div>
@endsection