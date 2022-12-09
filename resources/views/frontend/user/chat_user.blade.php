@extends('frontend.layout.master')
@section('breadcrumb')
 <section class="section">
          <div class="section-header">
        
            <h1>@changeLang('Chatting With Provider')</h1>
      
          
        
          </div>
</section>
@endsection
@section('content')

    <div class="row">
    

        <div class="col-12 col-md-6 col-lg-6">
            <div class="card chat-box" id="mychatbox">
               
                <div class="card-body chat-content" tabindex="2">

                    @foreach ($chats as $chat)
                    @if($chat->sender == 'provider')    
                    <div class="chat-item chat-left" ><img src="@if($chat->provider->image) {{getFile('user',$chat->provider->image)}} @else {{getFile('logo',$general->default_image)}} @endif">
                        <div class="chat-details">
                          <div class="chat-text">{{__($chat->message)}}</div>
                            <div class="chat-time">{{__($chat->created_at->format('h:i'))}}</div>
                        </div>
                    </div>
                    @else
                    <div class="chat-item chat-right" ><img src="@if($chat->user->image) {{getFile('user',$chat->user->image)}} @else {{getFile('logo',$general->default_image)}} @endif">
                        <div class="chat-details">
                            <div class="chat-text">{{__($chat->message)}}</div>
                            <div class="chat-time">{{__($chat->created_at->format('h:i'))}}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    
                </div>
                <div class="card-footer chat-form">
                    <form id="chat-form" method="post">
                    @csrf
                        <input type="text" name="message" class="form-control" placeholder="@changeLang('Type a message')">
                        <input type="hidden" name="user" value="{{auth()->id()}}">
                        <input type="hidden" name="provider" value="{{$booking->service->user->id}}">
                        <button class="btn btn-primary" type="submit">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom-style')

<style>

    .chat-content{
        overflow: hidden; outline: none;
    }

   

</style>
    
@endpush