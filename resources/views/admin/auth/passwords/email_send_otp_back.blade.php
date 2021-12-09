
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password OTP</div>
                <div class="panel-body">
                   

              
                <!-- $resStr21=  str_replace('{reset_password_link}', 'abdullah', $resStr); -->
            @foreach($email_temp as $results)

{{$results->email_subject}}

{!!$resStr21!!}
            @endforeach

            
                </div>
            </div>
        </div>
    </div>
</div>

