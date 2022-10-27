@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Productos') }}</div>

                    <div class="card-body">

                        @if (Session('status'))
                            <div class="alert alert-success">
                                {{ Session('status') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <a class="btn btn-primary" href="{{ route('productos.create') }}"> Agregar producto </a>
                        </div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"> Nombre </th>
                                    <th scope="col"> Precio </th>
                                    <th scope="col"> Categoría </th>
                                    <th scope="col">  </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($productos->count() > 0)
                                    @foreach ($productos as $prod)
                                        <tr>
                                            <td> {{ $prod->nombre }} </td>
                                            <td> {{ $prod->precio_format() }} </td>
                                            <td> {{ $prod->categoria->nombre }} </td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('productos.show', $prod) }}"> Ingresar </a>
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

                        {{ $productos->links() }}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
