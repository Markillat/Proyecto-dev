@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card" style=" width: auto!important; margin: 0!important;">
                    <div class="card-body">
                        @if(Auth::check())
                            @if(session('access_token'))
                                <index-app access-token="{{ json_encode(session('access_token')) }}"
                                           tab="{{ 'first' }}"></index-app>
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
