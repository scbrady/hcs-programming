@extends('layouts.app')

@section('styles')
<style>
.box
{
    background-color: #f5f8fa;
    position: relative;
    padding: 20px 0;
}
.box.has-advanced-upload
{
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;

    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
}
.box.is-dragover
{
    outline-offset: -20px;
    outline-color: #c8dadf;
    background-color: #fff;
}
    .box__dragndrop,
    .box__icon
    {
        display: none;
    }
    .box.has-advanced-upload .box__dragndrop
    {
        display: inline;
    }
    .box.has-advanced-upload .box__icon
    {
        width: 100%;
        height: 50px;
        fill: #92b0b3;
        display: block;
        margin-bottom: 10px;
    }

    .box.is-uploading .box__input,
    {
        visibility: hidden;
    }

    .box__uploading,
    .box__error
    {
        display: none;
    }
    .box.is-uploading .box__uploading,
    {
        display: block;
        margin: auto;
        font-size: 20px;
    }

    .box__restart
    {
        font-weight: 700;
    }
    .box__restart:focus,
    .box__restart:hover
    {
        color: #39bfd3;
    }

    .box__file
    {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .box__file + label
    {
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        display: block;
        overflow: hidden;
        font-size: 20px;
        text-align: center;
    }
    .box__file + label:hover strong,
    .box__file:focus + label strong,
    .box__file.has-focus + label strong
    {
        color: #39bfd3;
    }
    .box__file:focus + label,
    .box__file.has-focus + label
    {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }
        .box__file + label *
        {
            /* pointer-events: none; */ /* in case of FastClick lib use */
        }

    .box__button
    {
        display: block;
        margin: 10px auto 0;
    }

</style>
@endsection

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
                    <h2 style="text-align:center">Change File:</h2>
                    @endif

                    <form method="post" action="/programs/{{$assignment->id}}/upload" enctype="multipart/form-data" novalidate class="box">
                        {{ csrf_field() }}
                        <div class="box__input">
                            <svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"/></svg>
                            <input type="file" name="file" id="file" class="box__file" />
                            <label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
                            <button type="submit" class="btn btn-primary box__button">Upload</button>
                        </div>

                        
                        <div class="box__uploading">Uploading&hellip;</div>
                        <div class="box__error">Error!</div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    ;( function( $, window, document, undefined )
	{
		var isAdvancedUpload = function()
        {
            var div = document.createElement( 'div' );
            return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
        }();

		$( '.box' ).each( function()
		{
			var $form		 = $( this ),
				$input		 = $form.find( 'input[type="file"]' ),
				$label		 = $form.find( 'label' ),
				droppedFiles = false,
                showFiles	 = function( files )
				{
					$label.text( files.length > 1 ? ( $input.attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );
				};

                $input.on( 'change', function( e )
                {
                    showFiles( e.target.files );
                });

			if( isAdvancedUpload )
			{
				$form
				.addClass( 'has-advanced-upload' ) // letting the CSS part to know drag&drop is supported by the browser
				.on( 'drag dragstart dragend dragover dragenter dragleave drop', function( e )
				{
					e.preventDefault();
					e.stopPropagation();
				})
				.on( 'dragover dragenter', function()
				{
					$form.addClass( 'is-dragover' );
				})
				.on( 'dragleave dragend drop', function()
				{
					$form.removeClass( 'is-dragover' );
				})
				.on( 'drop', function( e )
				{
					droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
					showFiles( droppedFiles );
				});
			}


			// if the form was submitted
			$form.on( 'submit', function( e )
			{
				// preventing the duplicate submissions if the current one is in progress
				if( $form.hasClass( 'is-uploading' ) ) return false;
				$form.addClass( 'is-uploading' );

                e.preventDefault();

                // gathering the form data
                var ajaxData = new FormData( $form.get( 0 ) );
                if( droppedFiles )
                {
                    $.each( droppedFiles, function( i, file )
                    {
                        ajaxData.append( $input.attr( 'name' ), file );
                    });
                }

                // ajax request
                $.ajax(
                {
                    url: 			$form.attr( 'action' ),
                    type:			$form.attr( 'method' ),
                    data: 			ajaxData,
                    dataType:		'json',
                    cache:			false,
                    contentType:	false,
                    processData:	false,
                    complete: function()
                    {
                        $form.removeClass( 'is-uploading' );
                    },
                    success: function( data )
                    {
                        location.reload();
                    },
                    error: function( data )
                    {
                        alert( data.responseJSON.file[0] );
                    }
                });
			});

			// Firefox focus bug fix for file input
			$input
			.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
			.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
		});

	})( jQuery, window, document );
</script>
@endsection