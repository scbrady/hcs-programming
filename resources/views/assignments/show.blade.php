@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div>

            <h1 class="page-header">{{$assignment->name}}</h1>
            <h3>{{$assignment->description}}</h3>
            <h5>Due: {{$assignment->due}}</h5>
            
            <div class="panel panel-default">
                <div class="panel-heading">Submit Assignment</div>
                <div class="panel-body">
                    @if($assignment->upload)
                    <h4>Submitted File: {{$assignment->upload->name}}</h4>
                    <hr />
                    <h5>Change File</h5>
                    @endif

                    <form action="/programs/{{$assignment->id}}/upload" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="file" name="file">
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection