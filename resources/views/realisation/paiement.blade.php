@extends('layouts.app')

@section('title', 'Payer devis')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Payer devis - Num. {{ str_pad($realisation_id, 4, 0, STR_PAD_LEFT) }}
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ route('realisation.payer', $realisation_id) }}" method="POST" id="paiement-form">
                @csrf
                <div class="form-floating">
                    <input type="datetime-local" name="date-paiement" id="date-paiement" class="form-control">
                    <label for="date-paiement">Date de paiement</label>
                </div>

                <div class="form-floating mt-2">
                    <input type="number" name="montant-a-payer" id="montant-a-payer" class="form-control">
                    <label for="montant-a-payer">Montant a payer</label>
                </div>

                <div class="alert alert-success mt-3 d-none" id="success-message-container">
                    <p id="success-message"></p>
                </div>

                <div class="alert alert-danger mt-3 d-none" id="error-message-container">
                    <p id="error-message"></p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <input type="submit" value="Ajouter paiement" class="btn btn-primary mt-2">
            </form>

            <div class="mt-4">
                <h5>
                    Liste des paiements faites
                </h5>
                <div>
                    <p class="m-0">Total a payer: {{ number_format($avancement_paiement->montant_a_payer, 2, ',', ' ') }} Ar</p>
                    <p class="m-0">Deja payer: {{ number_format($avancement_paiement->total_deja_payer, 2, ',', ' ') }} Ar</p>
                    <p class="m-0">Reste a payer: {{ number_format($avancement_paiement->reste_a_payer, 2, ',', ' ') }} Ar</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let paiementForm = document.getElementById('paiement-form');

        // Inputs
        let datePaiement = document.getElementById('date-paiement');
        let montantPaiement = document.getElementById('montant-a-payer');

        // Error message
        let errorMessageContainer = document.getElementById('error-message-container');
        let errorMessageText = document.getElementById('error-message');

        // Success message
        let successMessageContainer = document.getElementById('success-message-container');
        let successMessageText = document.getElementById('success-message');

        paiementForm.addEventListener('submit', (e) => {
            e.preventDefault();

            let paiementFormData = new FormData(paiementForm);

            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = JSON.parse(xhr.responseText); // Log the response

                        // Si il y a erreur
                        if (data.erreur.length > 0) {
                            successMessageContainer.classList.add('d-none');
                            errorMessageContainer.classList.remove('d-none');

                            errorMessageText.textContent = data.erreur[0];
                        } else {
                            successMessageContainer.classList.remove('d-none');
                            errorMessageContainer.classList.add('d-none');

                            successMessageText.textContent = data.message;

                            datePaiement.value = "";
                            montantPaiement.value = "";
                        }
                } else {
                    console.error('XHR request failed');
                }
            }
        };

            xhr.open("POST", "{{ route('realisation.valider.paiement', $realisation_id) }}", true);
            xhr.send(paiementFormData);
        });
    </script>
@endsection
