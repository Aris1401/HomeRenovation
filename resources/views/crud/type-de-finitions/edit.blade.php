@extends('layouts.app')
@section('title', 'Modifier type de finition')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Modifier type de finition</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('type-de-finition.update', $type_de_finition->tf_id) }}" method="post" class="form d-flex flex-column gap-2">
                    @csrf
                    @method('PUT')

                    <div class="form-floating">
                        <input value="{{ $type_de_finition->tf_designation }}" type="text" name="tf_designation" id="tf_designation" class="form-control" placeholder="Service...">
                        <label for="tf_designation">Designation</label>
                    </div>

                    <div class="form-floating">
                        <input value="{{ $type_de_finition->tf_augmentation_prix }}" type="number" step="0.01" name="tf_augmentation_prix" id="tf_augmentation_prix" class="form-control" placeholder="Service...">
                        <label for="tf_augmentation_prix">Augmentation prix</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection