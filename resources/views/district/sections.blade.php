@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            @include('partials.nav-tabs')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Skyward Sections</h4>
                </div>
                <div class="panel-body">
                    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Location ID</th>
                                <th>Course ID</th>
                                <th>Class ID</th>
                                <th>Class Number</th>
                                <th>Instructor ID</th>
                                <th>Instructor ID 2</th>
                                <th>Instructor ID 3</th>
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
            [0, 'asc']
        ],
        ajax: {
            url: "/sections/datatable",
            type: "GET"
        }
    });
});
@endsection
