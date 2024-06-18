@extends('layouts.app')

@section('title', 'Types de maison')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Types de maison</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary" href="{{ route('type-maison.create') }}">Ajouter types de maison</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col d-flex flex-column">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Designation</th>
                            <th>Description</th>
                            <th>Duree travaux</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($type_de_maisons as $type_de_maison)
                            <tr>
                                <td>{{ $type_de_maison->tm_designation }}</td>
                                <td>{{ $type_de_maison->tm_description }}</td>
                                <td>{{ $type_de_maison->tm_duree_travaux }} jours</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('type-maison.edit', $type_de_maison->tm_id) }}" class="btn btn-primary">
                                            <i class="cil-pencil icon"></i>
                                        </a>

                                        <form action="{{ route('type-maison.delete', $type_de_maison->tm_id) }}" method="POST">
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

                {{ $type_de_maisons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection