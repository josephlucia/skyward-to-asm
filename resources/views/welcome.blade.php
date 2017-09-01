@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-component-heading">
                        Skyward API to Apple School Manager CSV
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info">
                        Welcome to the Skyward API to Apple School Manager export application.
                    </div>

                    @if(Auth::check())
                    <a href="{{ url('/home') }}" class="btn btn-primary">Dashboard Home</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
