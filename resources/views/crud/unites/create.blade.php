@extends('layouts.app')
@section('title', 'Creer unite')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Creer unite</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('unites.store') }}" method="post" class="form d-flex flex-column gap-2">
                    @csrf
                    
                    <div class="form-floating">
                        <input type="text" name="designation" id="designation" class="form-control" placeholder="Service...">
                        <label for="designation">Designation</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection