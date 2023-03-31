@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style=" width: auto!important; margin: 0!important;">
                    <div class="card-body">
                        @if(Auth::check())
                            @if(session('data'))
                                <index-app data-array="{{ json_encode(session('data')) }}"
                                           tab="{{ 'first' }}"></index-app>
                            @else
                                <index-app data-array="{{ null }}" tab="{{ 'first' }}"></index-app>
                            @endif
                        @else
                            {{ 'Iniciar Session!!' }}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
