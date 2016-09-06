@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Edit Article</h2>
                </div>
                <div class="panel-body">
                    <form method="post" action='{{ url("/reading/update") }}'>
                        {{ csrf_field() }}
                        <input type="hidden" name="article_id" value="{{ $article->id }}{{ old('article_id') }}">
                        <div class="form-group">
                            <input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$article->title}}@endif{{ old('title') }}"/>
                        </div>
                        <div class="form-group">
                            <textarea name='body'class="form-control">
                            @if(!old('body'))
                            {!! $article->body !!}
                            @endif
                            {!! old('body') !!}
                            </textarea>
                        </div>
                        @if($article->active == '1')
                        <input type="submit" name='publish' class="btn btn-success" value = "Update"/>
                        @else
                        <input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
                        @endif
                        <input type="submit" name='save' class="btn btn-default" value = "Save As Draft" />
                        <a href="{{  url('/reading/delete/'.$article->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
  tinymce.init({
    selector : "textarea",
    plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
    toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages"
  }); 
</script>
@endsection