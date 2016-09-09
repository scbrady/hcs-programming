@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,r-2.1.0/datatables.min.css"/>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="page-header">Assignments</h1>
            <table id="assignment-list" class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Due Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    <tr class='clickable-row' data-href='/programs/{{$assignment->id}}'>
                        <td>{{$assignment->name}}</td>
                        <td>{{$assignment->due->format('M. jS')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if(Auth::user()->permissions == 0)
                <button class="btn btn-primary" style="margin-top:15px;"><a href="{{ url('/programs/create') }}" style="color: #fff;">New Assignment</a></button>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,r-2.1.0/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#assignment-list').DataTable({
            "order": [ 1, 'asc' ]
        });
    } );

    $(".clickable-row a").on('click', function(e) {
        e.stopPropagation();
    });
    $(".clickable-row").on('click', function() {
        document.location = $(this).data("href");
    });
</script>
@endsection