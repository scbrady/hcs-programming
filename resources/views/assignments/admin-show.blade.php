@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="page-header">{{$assignment->name}}</h1>
            <h3>{{$assignment->description}}</h3>
            <h5>Due: {{$assignment->due}}</h5>
            
            <div class="panel panel-default">
                {{$assignment->uploads}}
            </div>
        </div>
    </div>
</div>
@endsection