@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 style="float: left;">Reading Material</h3>
                    @if(Auth::user()->permissions == 0)
                        <button class="btn btn-primary" style="float: right; margin-top:15px;"><a href="{{ url('/reading/new') }}" style="color: #fff;">New Article</a></button>
                    @endif
                    <div class="clearfix"></div>

                    @foreach($articles as $article)
                    <h4>
                        <a href="/reading/show/{{$article->slug}}">{{$article->title}}</a>
                    </h4>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection