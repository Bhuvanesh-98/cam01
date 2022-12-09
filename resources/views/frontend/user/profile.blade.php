@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Update Profile')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">

     

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-12 col-md-6 col-lg-3">
                                <label class="">@changeLang('profile Image')</label>

                                <div id="image-preview" class="image-preview w-100"
                                    style="background-image:url({{ getFile('user',$user->image) }});">
                                    <label for="image-upload" id="image-label">@changeLang('Choose File')</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>

                            </div>

                         
                        

                            </div>

                            <div class="row">

                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('First Name')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control" name="fname"
                                     value="{{ $user->fname }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('Last Name')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control" name="lname"
                                     value="{{ $user->lname }}" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('Mobile')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control" name="mobile"
                                     value="{{ $user->mobile ?? old('mobile') }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('Country')<span class="text-danger">*</span></label>
                                <input type="text" name="country" class="form-control" value="{{@$user->address->country}}">
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('City')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control"  name="city"
                                    value="{{ @$user->address->city ?? old('city') }}" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('State')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control" 
                                    name="state" value="{{ @$user->address->state ?? old('state') }}" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('zip')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form_control"  name="zip"
                                    value="{{ @$user->address->zip ?? old('zip') }}" required>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label>@changeLang('Address')<span class="text-danger">*</span></label>
                               <input type="text" name="address" value="{{ @$user->address->address ?? old('address') }}" class="form-control form_control" required>
                            </div>
                            
                            @if($user->user_type == 2)
                                <div class="form-group col-md-12 col-12">
                                    <label>@changeLang('Designation')<span class="text-danger">*</span></label>
                                    <input type="text" name="designation" class="form-control form_control"  value="{{$user->designation ?? old('designation')}}" required>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>@changeLang('Details')<span class="text-danger">*</span></label>
                                <textarea name="details"  cols="30" rows="5" class="form-control summernote" >{{clean($user->details) ?? old('details')}}</textarea>
                                </div>
                                
                                <div class="form-group col-md-6 col-12">
                                    <label>@changeLang('Experience')<span class="text-danger">*</span></label>
                                <textarea name="experience"  cols="30" rows="5" class="form-control summernote" >{{clean($user->experience) ?? old('experience')}}</textarea>
                                </div>
                                
                                <div class="form-group col-md-6 col-12">
                                    <label>@changeLang('Qualification')<span class="text-danger">*</span></label>
                                <textarea name="qualification"  cols="30" rows="5" class="form-control summernote" >{{clean($user->qualification) ?? old('qualification')}}</textarea>
                                </div>

                                <div class="col-md-6 col-12">

                                    <div class="row">
                                    
                                        <div class="form-group col-12">
                                        
                                            <label for="">@changeLang('Facebook Link')</label>
                                            <input type="text" name="social[facebook]"  class="form-control" value="{{@$user->social->facebook}}">
                                        
                                        </div>
                                        
                                        <div class="form-group col-12">
                                        
                                            <label for="">@changeLang('Twitter Link')</label>
                                            <input type="text" name="social[twitter]"  class="form-control" value="{{@$user->social->twitter}}">
                                        
                                        </div>
                                        
                                        <div class="form-group col-12">
                                        
                                            <label for="">@changeLang('YouTube Link')</label>
                                            <input type="text" name="social[youtube]"  class="form-control" value="{{@$user->social->youtube}}">
                                        
                                        </div>
                                    
                                    
                                    
                                    </div>
                                
                                
                                </div>
                            @endif




                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">@changeLang('Update Profile')</button>
                    </div>
                </form>
            </div>
        </div>

    </div>


@endsection


@push('custom-script')

    <script>
        'use strict'

        $(function() {

                $.uploadPreview({
                    input_field: "#image-upload", // Default: .image-upload
                    preview_box: "#image-preview", // Default: .image-preview
                    label_field: "#image-label", // Default: .image-label
                    label_default: "@changeLang('File')", // Default: Choose File
                    label_selected: "@changeLang('Upload File')", // Default: Change File
                    no_label: false, // Default: false
                    success_callback: null // Default: null
                });


            $('#country option').each(function(index) {

                let country = "{{ @$user->address->country }}"

                if ($(this).val() == country) {
                    $(this).attr('selected', 'selected')
                }


            })
        })
    </script>


@endpush
