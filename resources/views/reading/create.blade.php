@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Create New Article</h2>
                </div>
                <div class="panel-body">
                    <form action="/reading/new" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name = "title"class="form-control" />
                        </div>
                        <div class="form-group">
                            <textarea name='body'class="form-control">{{ old('body') }}</textarea>
                        </div>
                        <input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
                        <input type="submit" name='save' class="btn btn-default" value = "Save Draft" />
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