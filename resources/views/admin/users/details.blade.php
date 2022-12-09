  @extends('admin.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('User Details')</h1>
      
          
        
          </div>
</section>
@endsection
  @section('content')

      <div class="row">

          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                      <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                      <div class="card-header">
                          <h4>@changeLang('Total Bookings')</h4>
                      </div>
                      <div class="card-body">
                          {{ $user->bookings_count }}

                         
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                      <i class="far fa-money-bill-alt"></i>
                  </div>
                  <div class="card-wrap">
                      <div class="card-header">
                          <h4>@changeLang('Total Transaction')</h4>
                      </div>
                      <div class="card-body">
                          {{$user->transactions()->sum('amount').' '. $general->site_currency}}

                          
                      </div>
                  </div>
              </div>
          </div>

          </div>

          <div class="row">


          <div class="col-md-3">
              <div class="card shadow">
                  <img src="@if($user->image) {{getFile('user',$user->image)}} @else {{getFile('logo',$general->default_image)}} @endif" 
                      class="w-100">
                  <div class="container my-3">
                      <h4>{{ __($user->fullname) }}</h4>
                      <p class="title">{{ __($user->designation) }}</p>
                      <p class="title">{{ __($user->email) }}</p>
                      <a href="" class="btn btn-primary sendMail">@changeLang('Send Mail To user')</a>
                  </div>
              </div>
          </div>

          <div class="col-md-9">
              <div class="card">
                  <div class="card-body">
                      <form action="{{route('admin.user.update',$user->id)}}" method="post">
                          @csrf

                          <div class="row">

                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('First Name')</label>
                                  <input type="text" name="fname" class="form-control" 
                                      value="{{ $user->fname }}">

                              </div>
                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('Last Name')</label>
                                  <input type="text" name="lname" class="form-control" 
                                      value="{{ $user->lname }}">

                              </div>

                              <div class="form-group col-md-6 mb-3 col-6">
                                  <label>@changeLang('Country')</label>
                                 <input type="text" name="country" class="form-control" value="{{ @$user->address->country }}">
                              </div>

                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('city')</label>
                                  <input type="text" name="city" class="form-control form_control"
                                       value="{{ @$user->address->city }}">

                              </div>

                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('zip')</label>
                                  <input type="text" name="zip" class="form-control form_control"
                                      value="{{ @$user->address->zip }}">

                              </div> 
                              
                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('state')</label>
                                  <input type="text" name="state" class="form-control form_control" 
                                      value="{{ @$user->address->state }}">

                              </div>

                              <div class="col-md-6 mb-3">

                                  <label for="">@changeLang('Status')</label>
                                  <select name="status" id="" class="form-control">

                                      <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>@changeLang('Inactive')</option>
                                      <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>@changeLang('Active')</option>

                                  </select>

                              </div> 
                              
                             

                              <div class="col-md-12 mt-4">

                                  <button type="submit" class="btn btn-primary w-100">@changeLang('Update User')</button>

                              </div>




                          </div>
                      </form>

                  </div>

              </div>


          </div>

      </div>


      <div class="modal fade" tabindex="-1" role="dialog" id="mail">
          <div class="modal-dialog" role="document">
              <form action="{{ route('admin.user.mail', $user->id) }}" method="post">
                  @csrf
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">{{ __('Send Mail to user') }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">

                              <label for="">@changeLang('Subject')</label>

                              <input type="text" name="subject"  class="form-control">

                          </div>

                          <div class="form-group">

                              <label for="">@changeLang('Message')</label>

                              <textarea name="message" id="" cols="30" rows="10" class="form-control summernote"></textarea>

                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">@changeLang('Send Mail')</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">@changeLang('Close')</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>

  @endsection


  @push('custom-script')

      <script>
          'use strict'

          $(function() {
              $('.sendMail').on('click', function(e) {
                  e.preventDefault();

                  const modal = $('#mail');

                  modal.modal('show');
              })

              $('#country option').each(function(index) {

                  let country = "{{ @$user->address->country }}"

                  if ($(this).val() == country) {
                      $(this).attr('selected', 'selected')
                  }


              })
          })
      </script>

  @endpush
