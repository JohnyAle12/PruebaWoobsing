@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Listado de usuarios</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="card" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title">{{ $user->name ." ". $user->lastname }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
                        <p class="card-text">Dirección: {{ $user->address }}</p>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
