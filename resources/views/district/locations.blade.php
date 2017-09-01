@extends('layouts.app')

@section('content')
<locations inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('partials.nav-tabs')

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-split">
                            <span class="panel-component-heading">
                                Skyward Locations
                            </span>
                        </div>
                    </div>
                    <div class="panel-body">

                        <p v-if="locations.length === 0">
                            There are no locations available. Please re-sync.
                        </p>

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">@{{ error }}</li>
                            </ul>
                        </div>

                        <form role="form">
                            <div class="row" style="margin-bottom: 8px;" v-for="location in locations">
                                <div class="col-md-1">
                                    @{{ location.location_id }}
                                </div>
                                <div class="col-md-8">
                                    @{{ location.location_name }}
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="sync" v-model="location.sync" @change="updateSync(location)">
                                        <option value="1">Sync</option>
                                        <option value="0">Don't Sync</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</locations>
@endsection
