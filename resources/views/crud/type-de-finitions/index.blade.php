@extends('layouts.app')

@section('title', 'Types de finition')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Types de finition</h5>
    </div>

    <div class="card-body">
        <div class="row mt-3">
            <div class="col d-flex flex-column">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Designation</th>
                            <th>Augmentation de prix</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($type_de_finitions as $type_de_finition)
                            <tr>
                                <td>{{ $type_de_finition->tf_designation }}</td>
                                <td>{{ number_format($type_de_finition->tf_augmentation_prix, 2, ',', ' ') }} %</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('type-de-finition.edit', $type_de_finition->tf_id) }}" class="btn btn-primary">
                                            <i class="cil-pencil icon"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $type_de_finitions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection