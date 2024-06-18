@extends('layouts.app')

@section('title', 'Realiser')

@section('additional-styles')
    <link rel="stylesheet" href="{{ asset('css/pages/realiser.css') }}">
@endsection

@section('content')
    <div class="d-flex justify-content-center flex-column align-items-center">
        <h1>Realisons votre projet</h1>

        <form action="{{ route('realiser.store') }}" method="post" class="mt-3">
            @csrf
            <div class="row">
                <div class="col d-flex gap-2">

                    @foreach ($type_de_maisons as $type_de_maison)
                        <input type="radio" class="btn-check type-maison-radio" name="type-maison" id="type-maison-{{ $type_de_maison->tm_id }}" value="{{ $type_de_maison->tm_id }}">
                        <label for="type-maison-{{ $type_de_maison->tm_id }}" class="type-maison-label">
                            <div class="card" style="min-width: 300px">
                                <div class="card-body text-center">
                                    <h5>
                                        {{ $type_de_maison->tm_designation }}
                                    </h5>

                                    <div class="p-3">
                                        <h2>
                                            @if ($type_de_maison->devis->count() > 0)
                                                {{ number_format($type_de_maison->devis->first()->d_montant_total, 2, '.', ' ') }}
                                            @else
                                                0
                                            @endif
                                            Ar
                                        </h2>
                                    </div>

                                    <div class="d-flex flex-column w-100 align-items-center">
                                        <p style="max-width: 200px">
                                            {{ $type_de_maison->tm_description }}
                                        </p>

                                        <p>
                                            {{ $type_de_maison->tm_duree_travaux }} jours
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="row mt-5">
                <div class="col d-flex flex-column align-items-center">
                    <h3>Choississez le type de finition</h3>

                    <div class="d-flex gap-1 align-items-center mt-2">
                        @foreach ($type_de_finitions as $type_de_finition)
                            <input type="radio" class="btn-check type-de-finition-radio" name="type-finition" id="type-finition-{{ $type_de_finition->tf_id }}" value="{{ $type_de_finition->tf_id }}">
                            <label for="type-finition-{{ $type_de_finition->tf_id }}" class="type-de-finition-label">
                                <div class="card" style="min-width: 200px">
                                    <div class="card-body text-center d-flex flex-column align-items-center">
                                        <h5>{{ $type_de_finition->tf_designation }}</h5>

                                        <div class="p-2">
                                            <h4>{{ number_format($type_de_finition->tf_augmentation_prix, 1, '.', '') }}%
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col d-flex flex-column align-items-center">
                    <h3>Entrez la date de debut de notre collaboration</h3>

                    <div class="form-floating">
                        <input type="datetime-local" name="date-debut" id="date-debut" class="form-control">
                        <label for="date-debut">Date debut</label>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col d-flex flex-column align-items-center w-100">
                    <h3>Entrez le lieu</h3>

                    <div class="form-floating w-100">
                        <input type="text" name="lieu" id="lieu" class="form-control w-100" placeholder="Lieu">
                        <label for="lieu">Lieu</label>
                    </div>
                </div>

            </div>

            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row mt-5 mb-5">
                <div class="col">
                    <input type="submit" value="Obtenir le devis" class="btn btn-outline-info w-100">
                </div>
            </div>
        </form>
    </div>
@endsection
