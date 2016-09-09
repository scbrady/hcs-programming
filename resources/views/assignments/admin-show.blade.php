@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="page-header">{{$assignment->name}}</h1>

            <h3>{{$assignment->description}}</h3>
            <h5>Due: {{$assignment->due->format('M. jS')}}</h5>
            
            <div class="panel panel-default">
                @foreach($assignment->uploads as $upload)
                    <p>{{$upload->user->name}} - {{$upload->updated_at->diffForHumans()}} - <a href="{{Storage::url($upload->file)}}">Download</a></p>
                @endforeach
            </div>

            <button id="lock" class="btn btn-primary" style="margin-top:15px;"><a href="#" style="color: #fff;">Lock Assignment</a></button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
    $('#lock').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/programs/{{$assignment->id}}/lockout",
            type: "POST",
            success: function (data) {
                alert('Successfully locked');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert('Error');
            }
        })
    });
</script>
@endsection