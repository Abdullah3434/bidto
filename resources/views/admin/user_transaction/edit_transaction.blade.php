@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Transaction
                        </header>
                        <div class="panel-body">
                              
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                    
                                            {!! \Session::get('success') !!}
                                        
                                    </div>
                                @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/transactions/'.$ifexist->id.'/'.$user_id)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf
 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Balance </label>
                                    <div class="form-group{{ $errors->has('balance') ? ' has-error' : '' }}">
                                    <input type="text" oninput="return validateForm2()" id="text1" class="form-control" name="balance" value="{{$ifexist->amount}}" >
                                    
                                        @if ($errors->has('balance'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('balance') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                           
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Transaction Type </label>
                                    <div class="form-group{{ $errors->has('transaction_type') ? ' has-error' : '' }}">
                                    <!-- <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="transaction_type" value="{{$ifexist->transaction_type}}"> -->
                                        <select oninput="return validateForm2()" id="text1" class="form-control" name="transaction_type" value="{{$ifexist->transaction_type}}">
                                           @if($ifexist->transaction_type=='add_balance')
                                        <option value="add_balance">Deposit Funds For Top-up Account</option> 
                                        <option value="purchase_promotion">Fee for Promotion Package</option> 
                                        @elseif($ifexist->transaction_type=='purchase_promotion')
                                        <option value="purchase_promotion">Fee for Promotion Package</option>
                                        <option value="add_balance">Deposit Funds For Top-up Account</option> 
                                            @endif
                                    
                                        </select>
                                            @if ($errors->has('transaction_type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('transaction_type') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                         
                             <script>
                                function validateForm() {
                                var x = document.forms["myForm"]["transaction_type","balance"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                
                                }

                                function validateForm2() {
                                var x = document.forms["myForm"]["transaction_type","balance"].value;
                                if (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }

                                }
                                </script>
 
                                    <button type="submit" id="submit" class="btn btn-info" style="margin-top:10px">Submit</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
           
            </section>

        </div>
    </div>


    </section>

@endsection
