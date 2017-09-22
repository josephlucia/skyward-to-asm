@extends('layouts.app')

@section('content')
<div class="container">
    
    @include('partials.nav-tabs')
    
    <div class="row">
        <div class="col-md-12">
            <!-- Sync Status Component -->
            <sync-status></sync-status>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Configuration Sync -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-component-heading">Skyward Sync Configuration</div>
                        </div>
                        <div class="panel-body" style="margin-bottom: 6px;">

                            @include('common.alerts')

                            <form action="{{ url('/credentials') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="domain">Skyward Domain</label>
                                    <input type="text" class="form-control" id="domain" name="domain" value="{{ $credentials->domain or old('domain') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="https://skyward.example.com">
                                </div>
                                <div class="form-group">
                                    <label for="consumer_key">Skyward Consumer Key</label>
                                    <input type="text" class="form-control" id="consumer_key" name="consumer_key" value="{{ $credentials->consumer_key or old('consumer_key') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                </div>
                                <div class="form-group">
                                    <label for="consumer_secret">Skyward Consumer Secret</label>
                                    <input type="text" class="form-control" id="consumer_secret" name="consumer_secret" value="{{ $credentials->consumer_secret or old('consumer_secret') }}" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                                </div>
                                <button type="submit" class="btn btn-primary">Save API Credentials</button>
                                @if(isset($credentials) && $credentials->valid)
                                <span class="label label-success pull-right">
                                    <i class="fa fa-check-circle-o"></i> Validated
                                </span>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Manual Sync Tables Component -->
            <sync-tables credentials="{{ isset($credentials) && $credentials->valid ? 'valid' : 'invalid' }}"></sync-tables>
        </div>
    </div>
</div>
@endsection
