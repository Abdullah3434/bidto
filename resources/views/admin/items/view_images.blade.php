@extends('admin.layout.apps')
@section('content')
    <section id="main-content" class="">
      <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <section class="panel">
                <header class="panel-heading">
                  View Item Gallery
                </header>
                  <div class="panel-body">
                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                          {!! \Session::get('success') !!}
                      </div>
                    @endif
                        @if(count($all_images)>0)
                        @foreach($all_images as $single_image)
                          <div class="gallery"> 
                            <div class="img-container" ng-repeat="file in imagefinaldata">                        
                              <a href="" data-toggle="modal" data-target="#exampleModal{{$single_image->id}}">
                                <span class="fas fa-trash-alt btn-delete" style="color:red"></span> 
                              </a>   
                              <a href=""  data-toggle="modal" data-target="#ImageModal{{$single_image->id}}">
                                <img src="{{ asset('public/uploads/items/thumbs/'.$single_image->image) }}" alt="" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
                              </a>  
                            </div>
                          </div> 
                              <div class="modal fade" id="exampleModal{{$single_image->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                      <div class="modal-body">
                                        Are you sure to delete this?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{url('/admin/delete/item/image/'.$single_image->id)}}" class="btn btn-danger">Delete</a>
                                      </div>
                                  </div>
                                </div>
                              </div>  
                              <div class="modal fade" id="ImageModal{{$single_image->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                   
                                      <img src="{{ asset('public/uploads/items/'.$single_image->image) }}" alt="" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">    
                                  </div>
                                </div>
                              </div> 
                        @endforeach
                          @else
                          <div class="position-center">
                            <h3><strong>  No Images are Available </strong> </h3>
                        </div>
                        @endif
                      </div>
                  </section>
              </div>
            </section>
          </div>
        </div>
    </section>


@endsection