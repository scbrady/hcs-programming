@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>
                        {{ $article->title }}
                        @if(Auth::user()->permissions == 0)
                            <button class="btn btn-primary" style="float: right;"><a href="{{ url('/reading/edit/'.$article->slug)}}" style="color: #fff;">Edit Article</a></button>
                        @endif
                    </h2>
                </div>
                <div class="panel-body">
                    {!! $article->body !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection