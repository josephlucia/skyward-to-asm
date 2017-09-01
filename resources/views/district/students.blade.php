@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @include('partials.nav-tabs')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Skyward Students</h4>
                </div>
                <div class="panel-body">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Location ID</th>
                                <th>Person ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Grade</th>
                                <th>SIS Username</th>
                                <th>Email Address</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
$(document).ready(function() {
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [
            [10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 500]
        ],
        columnDefs: [
            {
                orderable: true
            }
        ],
        order: [
            [2, 'asc']
        ],
        ajax: {
            url: "/students/datatable",
            type: "GET"
        }
    });
});
@endsection
