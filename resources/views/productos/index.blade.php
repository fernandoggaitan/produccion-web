@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Productos') }}</div>

                    <div class="m-3">
                        <a class="text text-primary" href="{{ route('productos.create') }}"> Agregar producto </a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> Nombre </th>
                                <th scope="col"> Precio </th>
                                <th scope="col"> Categoría </th>
                                <th scope="col"> Acciones </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($productos->count() > 0)
                                @foreach ($productos as $prod)
                                    <tr>
                                        <td> {{ $prod->nombre }} </td>
                                        <td> {{ $prod->precio }} </td>
                                        <td> {{ $prod->categoria_id }} </td>
                                        <td>
                                            <a class="text text-primary" href=""> Editar </a>
                                            |
                                            <a class="text text-danger" href=""> Eliminar </a>
                                        </td>
                                    </tr>
                                @endforeach                           
                            @else
                                <tr>
                                    <td class="text-center" colspan="4"> No existen productos cargados. </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
