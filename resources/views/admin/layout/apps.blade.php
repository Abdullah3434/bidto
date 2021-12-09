
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="author" content="ThemeBucket">
        <link rel="shortcut icon" href="{{URL('public/favicon.ico') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.css">

        <link href="{{URL('public/admin_assets/fontawesome5/css/all.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{URL('public/admin_assets/js/data-tables/DT_bootstrap.css') }}" />
    
        <title>Bidto Admin</title>

        <link href="{{URL('public/admin_assets/DataTables/datatables.min.css') }}" rel="stylesheet">
        <!--Core CSS -->

        <!-- Custom styles for this template -->
        <link href="{{URL('public/admin_assets/css/style.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/css/style-responsive.css') }}" rel="stylesheet" />

        <link href="{{URL('public/admin_assets/bs3/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/css/bootstrap-reset.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
        <!--icheck-->
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/minimal.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/red.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/green.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/blue.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/yellow.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/minimal/purple.css') }}" rel="stylesheet">

        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/square.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/red.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/green.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/blue.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/yellow.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/square/purple.css') }}" rel="stylesheet">

        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/grey.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/red.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/green.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/blue.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/yellow.css') }}" rel="stylesheet">
        <link href="{{URL('public/admin_assets/js/iCheck/skins/flat/purple.css') }}" rel="stylesheet">
<style>
  
    p 
        {
            font-size: 13px;
            padding: 15px;
            border-radius: 3px;
        }
    .base_receive p 
        {
            background:#ddd;
            display: table; 
            width: 50%;
            /* padding:5px; */
        }
    .base_sent p 
        {
            background: #59ace2;
            display: table;
            /* padding: 4px;
            margin: 4px 4px 4px 4px;
            text-decoration: none; */
            text-align:left;
            width: 50%;
            margin-right: 0px;
            margin-left: auto;
            /* margin-top: auto; */
        }
    time 
        {
            font-size: 1px;
            font-style: italic;
        }
    #chat_box 
        {
            position: fixed;
            top: 10%;
            right: 5%;
            width: 5%;
        }

    .close-chat 
        {
            margin-top: -17px;
            cursor: pointer;
        }

    .chat_box 
        {
            margin-right: 25px;
            width: 310px;
        }

    .chat-area 
        {
            height: 400px;
            overflow-y: scroll;
        }

    #users li 
        {
            margin-bottom: 5px;
        }

    #chat-overlay 
        {
            position: fixed;
            right: 0%;
            bottom: 0%;
        }

/* .glyphicon-ok {
    color: #42b7dd;
}

.loader {
    -webkit-animation: spin 1000ms infinite linear;
    animation: spin 1000ms infinite linear;
}
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
} */
div.gallery {
  margin: 5px;
  /* border: 1px solid #ccc; */
  float: left;
  width: 180px;
}

div.gallery:hover {
  /* border: 1px solid #777; */
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}
.image {
    width: 100px;
    height: 100px;
    position: relative;
}
.btn-delete {
    position: relative;
    /* left: 100%; */
    margin-left: 80px;
    margin-top: 2px;
    cursor: pointer;
}

.img-wrap {
    position: relative;
    display: inline-block;
    border: 1px red solid;
    font-size: 0;
}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 5px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
}
.img-wrap:hover .close {
    opacity: 1;
}


    </style>
    </head>

<body>

    <section id="container" >
            <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="{{url('/admin/home')}}" class="logo"> 
                    <img src="{{asset('public/admin_assets/images/logo.svg')}}" alt="">
                </a>
              
            </div>
            <div class="top-nav clearfix">
                    <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown"> 
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="{{asset('admin_assets/images/avatar1_small.jpg')}}">
                                <span class="username">{{{ isset(Auth::user()->admin_name) ? Auth::user()->admin_name : Auth::user()->admin_email }}}</span>
                            </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="{{url('/admin/profile')}}"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="{{url('/admin/change/password')}}"><i class="fas fa-unlock-alt"></i> Change Password</a></li>
                            <li><a href="{{url('/admin/logout')}}"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>

        <aside id="nav">
            <div id="sidebar" class="nav-collapse">
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="{{url('/admin/home')}}" class="{{ 
                                (request()->is('admin/home') ) ? 'active' : '' }}">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sub-menu">
                            <a href="{{url('/admin/users')}}" class="{{ 
                                (request()->is('admin/users') ) || request()->is('admin/user/*')
                                || request()->is('admin/transactions/*')|| request()->is('admin/reviews/*') || request()->is('admin/card/*') || request()->is('admin/users/*')
                                ? 'active' : '' }}">
                                <i class="fa fa-user"></i>
                                    <span>Manage Users</span>
                            </a>
                           
                        </li>
                        <li class="sub-menu">
                            <a href="javascript:;"  class="{{ 
                                (request()->is('admin/items')  || request()->is('admin/item/*') 
                               
                                || request()->is('admin/bids/*')  || request()->is('admin/services') || request()->is('admin/service/*') ||request()->is('admin/requests')|| request()->is('admin/request/*'))  ? 'active' : '' }}">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                    <span>Manage Posts </span>
                            </a>
                            <ul class="sub" >
                                <!-- <li class="{{ (request()->is('admin/item/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/items')}}" >Items</a></li>  -->
                                
                                <li class="{{ (request()->is('admin/item/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/items')}}" >Manage Items</a></li> 
                                <li class="{{ (request()->is('admin/services')|| request()->is('admin/service/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/services')}}" >Manage Services</a></li> 
                                <li class="{{ (request()->is('admin/requests')|| request()->is('admin/request/*'))  ? 'active' : '' }}"><a  href="{{url('/admin/requests')}}" >Manage Requests </a></li> 
                               

                            </ul>
                        </li>
                        <li  class="sub-menu ">
                            <a href="javascript:;" class="{{ 
                                (request()->is('admin/categories') || request()->is('admin/category/*') 
                                || request()->is('admin/color')  || request()->is('admin/color/*')
                                || request()->is('admin/transmission') || request()->is('admin/transmission/*') 
                                || request()->is('admin/item-types') || request()->is('admin/item-types/*')
                                || request()->is('admin/condition') || request()->is('admin/condition/*')
                                || request()->is('admin/cylinder') || request()->is('admin/cylinder/*')
                                || request()->is('admin/makes')) || request()->is('admin/make/*')  
                                || request()->is('admin/models/*')  || request()->is('admin/model/*') ? 'active' : '' }}">
                                <i class="fa fa-laptop"></i>
                                    <span>Manage Meta Data</span>
                            </a>
                            <ul class="sub" >
                                <li  class="{{ (request()->is('admin/category/*') )  ? 'active' : '' }}" ><a  href="{{url('/admin/categories')}}">Manage Category</a></li>
                                <li class="{{ (request()->is('admin/color/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/color')}}">Manage Colors</a></li>
                                <li class="{{ (request()->is('admin/transmission/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/transmission')}}">Manage Transmission</a></li>
                                <li class="{{ (request()->is('admin/item-types/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/item-types')}}">Manage Item Types</a></li>
                                <li class="{{ (request()->is('admin/condition/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/condition')}}">Manage Condition</a></li>
                                <li class="{{ (request()->is('admin/cylinder/*') )  ? 'active' : '' }}" ><a  href="{{url('/admin/cylinder')}}">Manage Cylinder</a></li>
                                <li class="{{ (request()->is('admin/make/*') ) || request()->is('admin/models/*') || request()->is('admin/model/*') 
                                     ? 'active' : '' }}"><a  href="{{url('/admin/makes')}}">Manage Make</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="{{url('/admin/sponsors')}}"  class="{{ 
                                (request()->is('admin/sponsors') )|| request()->is('admin/sponsor/*')  ? 'active' : '' }}">
                            
                                <i class="fa fa-users"></i>
                                    <span>Manage Sponsors</span>
                            </a>
                        
                        </li>
			
                        <li class="sub-menu">
                            <a href="javascript:;" class="{{ 
                                (request()->is('admin/email/templates') || request()->is('admin/email-temp/edit/*')
                                || request()->is('admin/notification/templates') || request()->is('admin/notification/template/*')
                                || request()->is('admin/message/templates') || request()->is('admin/message-temp/edit/*')
                                || request()->is('admin/page/content') || request()->is('admin/content/edit/*')
                                || request()->is('admin/settings')) ? 'active' : '' }}">
                                <i class="fa fa-cog"></i>
                                    <span>System Settings</span>
                            </a>
                            <ul class="sub">
                                <li class="{{ (request()->is('admin/email-temp/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/email/templates')}}">Manage Email Templates</a></li>
                                <li class="{{ (request()->is('admin/notification/template/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/notification/templates')}}">Manage Notification Templates</a></li>
                                <li class="{{ (request()->is('admin/message-temp/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/message/templates')}}">Manage Message Templates</a></li>
                                <li class="{{ (request()->is('admin/content/edit/*') )  ? 'active' : '' }}"><a  href="{{url('/admin/page/content')}}">Manage Page Content</a></li> 
                                <li><a  href="{{url('/admin/settings')}}">Settings</a></li>
                            </ul>
                        </li>


                    </ul>
                </div>        

            </div>
        </aside>
    </section>
@yield('content')
@yield('scripts')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script>

                $(document).ready(function() {
                validate();
                $('input').on('keyup', validate);
                });

                function validate() {
                var inputsWithValues = 0;

                // get all input fields except for type='submit'
                var myInputs = $("input:not([type='submit']),input[type=file]");

                myInputs.each(function(e) {
                // if it has a value, increment the counter
                if ($(this).val()) {
                inputsWithValues += 1;
                }
                });

                if (inputsWithValues == myInputs.length) {
                $("input[type=submit]").prop("disabled", false);
                } else {
                $("input[type=submit]").prop("disabled", true);
                }
                }
            </script>
                    
                    <script type="text/javascript">
                       $("#item_make_id").on('change',function(e){

                            console.log(e);

                            var cat_id = e.target.value;
                            // alert(cat_id);

                            $.get('{{URL('/')}}/ajax-subcategory?cat_id='+ cat_id,function(data){
                            $('#item_model_id').empty();
                            $('#item_model_id').append('<option value="" disable="true" selected="true" >Select Model Name</option>');

                            $.each(data,function(create,subcatObj){

                                $('#item_model_id').append('<option value ="'+subcatObj.id+'">'+subcatObj.model_name+'</option>');
                                    });
                       
                            });
                        

                            });

                    </script>
            <script>

                $(function(){
                var current_page_URL = location.href;
                $( "a" ).each(function() {
                    if ($(this).attr("href") !== "#") {
                    var target_URL = $(this).prop("href");
                    if (target_URL == current_page_URL) {
                        $('nav a').parents('li, ul').removeClass('active');
                        
                        $(this).parent('li').addClass('active');
                        return false;
                    }
                    }
                });
                });
    
            </script>

            <script>
                $(document).ready(function(){
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
                });
            </script>
            <script>
                function loadPreview(input, id) {
                    id = id || '#preview_img';
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                
                        reader.onload = function (e) {
                            $(id)
                                    .attr('src', e.target.result)
                                    .width(200)
                                    .height(150);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>
            <script>

                $(document).ready(function() {
                    $('#example').dataTable( {
                    "pageLength": 25,
                    "ordering": false,
                    } );
                } );

            </script>
            <script type="text/javascript">
                var x=document.getElementById("text").value;
            
                
                // alert(y);
            
                        $(document).ready(function(){
                        $('.sendButton').attr('disabled',true);
                
                        $('.ig').keyup(function(){
                
                        if($(this).val().length !=0){
                        $('.sendButton').attr('disabled', false);
                    }
                else
                    {
                        $('.sendButton').attr('disabled', true);        
                    }
                            })
                        }); 
                    

            </script>


<!-- <script src="{{asset('public/admin_assets/js/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script src="{{asset('public/admin_assets/js/bootstrap-switch.js')}}"></script>

<script type="text/javascript" src="{{asset('public/admin_assets/js/fuelux/js/spinner.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-fileupload/bootstrap-fileupload.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/jquery-multi-select/js/jquery.multi-select.js')}}"></script>
<script type="text/javascript" src="{{asset('public/admin_assets/js/jquery-multi-select/js/jquery.quicksearch.js')}}"></script>

<script type="text/javascript" src="{{asset('public/admin_assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>

<script src="{{asset('public/admin_assets/js/jquery-tags-input/jquery.tagsinput.js')}}"></script>

<script src="{{asset('public/admin_assets/js/select2/select2.js')}}"></script>
<script src="{{asset('public/admin_assets/js/select-init.js')}}"></script> -->




<script src="{{asset('public/admin_assets/js/toggle-init.js')}}"></script>

<script src="{{asset('public/admin_assets/js/advanced-form.js')}}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-lightbox/0.7.0/bootstrap-lightbox.min.js"></script>

        <script src="{{asset('public/admin_assets/bootstrap_validator/validator.min.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="{{URL('public/admin_assets/js/jquery-1.8.3.min.js') }}"></script>
        <script src="{{URL('public/admin_assets/js/jquery.js') }}"></script>
        <script src="{{URL('public/admin_assets/bs3/js/bootstrap.min.js') }}"></script>

        <script class="include" type="text/javascript" src="{{URL('public/admin_assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/jquery.scrollTo.min.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/jquery.nicescroll.js')}}"></script>
        <!-- <script src="{{URL('admin_assets/js/dashboard.js')}}"></script> -->
        <!--Easy Pie Chart-->
        <script src="{{URL('public/admin_assets/js/easypiechart/jquery.easypiechart.js')}}"></script>
        <!--Sparkline Chart-->
        <script src="{{URL('public/admin_assets/js/sparkline/jquery.sparkline.js')}}"></script>
        <!--jQuery Flot Chart-->
        <script src="{{URL('public/admin_assets/js/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/flot-chart/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{URL('public/admin_assets/js/flot-chart/jquery.flot.pie.resize.js')}}"></script>

        <script src="{{URL('public/admin_assets/js/iCheck/jquery.icheck.js')}}"></script>

        <script type="text/javascript" src="{{URL('public/admin_assets/js/ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{URL('public/admin_assets/DataTables/datatables.min.js')}}"></script>
        <!--common script init for all pages-->
        <script src="{{URL('public/admin_assets/js/scripts.js')}}"></script>

        

        <script type="text/javascript" src="{{URL('public/admin_assets/js/data-tables/jquery.dataTables.js')}}"></script>

        <!--script for this page only-->
        <script src="{{URL('public/admin_assets/js/table-editable.js')}}"></script>

        <script>
            jQuery(document).ready(function() {
                EditableTable.init();
            });
        </script>



        <!--icheck init -->
        <script src="{{URL('public/admin_assets/js/icheck-init.js')}}"></script>
    </footer>
</body>
</html>
