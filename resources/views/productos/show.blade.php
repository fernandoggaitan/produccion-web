@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $producto->nombre }}</div>
                <div class="card-body">
                    <img class="imagen-producto" src="{{ asset('/storage/' . $producto->imagen) }}" alt="">
                    {{ $producto->descripcion }}
                    <hr>
                    <a class="btn btn-primary" href="{{ route('productos.index') }}"> Volver a productos </a>
                    <a class="btn btn-success" href="{{ route('productos.edit', $producto) }}"> Editar producto </a>
                    <form class="d-inline" method="POST" action="{{ route('productos.destroy', $producto) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"> Eliminar </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection