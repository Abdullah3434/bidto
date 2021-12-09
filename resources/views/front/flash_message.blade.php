@if ( $errors->count() > 0 )
    <div class="alert alert-block alert-danger fade in">
        @foreach( $errors->messages() as $message )
            <p> {{$message[0]}} </p>
        @endforeach
    </div>
@endif

@if(Session::has('error_message'))
    <div class="alert alert-block alert-danger fade in">
        <p> {{ Session::get('error_message') }} </p>
    </div>
@endif

@if(Session::has('success_message'))
    <div class="alert alert-block alert-success fade in">
        <p> {{ Session::get('success_message') }} </p>
    </div>
@endif
