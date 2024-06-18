@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Tableau de bord
        </h3>
    </div>

    <div class="card-body">
        {{-- Montant total des realisations --}}
        <div class="d-flex gap-2 justify-content-between">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Montant total des devises</p>
                    <h4 class="mt-0">{{ number_format($total_devis->montant_total, 2, ',', ' ') }} Ar</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="mb-0">Montant total des paiements</p>
                    <h4 class="mt-0">{{ number_format($total_paiements->montant_total, 2, ',', ' ') }} Ar</h4>
                </div>
            </div>
        </div>

        {{-- Histogramme --}}
        <div class="card mt-5">
            <div class="card-body">
                {!! $histogramme_montant->container() !!}
            </div>

            <div class="card-footer">
                <form action="" class="d-flex gap-1">
                    <div class="form-floating" style="min-width: 300px">
                        <select name="annee" id="annee" class="form-control">
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->annee }}">{{ $annee->annee }}</option>
                            @endforeach
                        </select>
                        <label for="annee">Annee</label>
                    </div>

                    <input type="submit" value="Valider" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/charts.js') }}"></script>
{!! $histogramme_montant->script() !!}
@endsection