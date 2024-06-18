@extends('layouts.app')

@section('title', 'Unites')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Unites</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <a class="btn btn-primary" href="{{ route('unites.create') }}">Ajouter unites</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col d-flex flex-column">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Designation</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($unites as $unite)
                            <tr>
                                <td>{{ $unite->ut_designation }}</td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-end">
                                        <a href="{{ route('unites.edit', $unite->ut_id) }}" class="btn btn-primary">
                                            <i class="cil-pencil icon"></i>
                                        </a>

                                        <form action="{{ route('unites.delete', $unite->ut_id) }}" method="POST">
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

                {{ $unites->links() }}
            </div>
        </div>
    </div>
</div>
@endsection