@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Categorías') }}</div>

                <div class="card-body">
                    <ul>
                        @foreach ($categorias as $cat)
                            <li>
                                <a href="{{ route('categorias.show', $cat) }}">
                                    {{ $cat->nombre }}
                                </a>                                
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection