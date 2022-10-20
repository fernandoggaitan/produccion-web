@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $categoria->nombre }}</div>

                <div class="card-body">
                    {{ $categoria->descripcion }}
                    <hr>
                    <a href="{{ route('categorias.index') }}"> Volver a categorías </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection