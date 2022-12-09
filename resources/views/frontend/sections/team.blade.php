@php
if(request()->routeIs('pages')){

 $experts = App\Models\User::whereHas('services',function($q){$q->where('status',1)->where('admin_approval',1);})->whereHas('schedules')->latest()->serviceProvider()->paginate();

}else{
$content = content('team.content');

$featureds = App\Models\User::whereHas('services',function($q){$q->where('status',1)->where('admin_approval',1);})->where('status', 1)
    ->serviceProvider()
    ->where('featured', 1)
    ->get();

}

@endphp

@if(request()->routeIs('pages'))

   <!--Service Start-->
    <div class="team-page pt_30 pb_60">
        <div class="container">
            <div class="row justify-content-center">

                @forelse ($experts as $expert)
                    <div class="col-lg-3 col-md-4 col-12 mt_30">
                        <div class="team-item">
                            <div class="team-photo">
                                <img src="@if($expert->image) {{getFile('user',$expert->image)}} @else {{getFile('logo',$general->default_image)}} @endif" alt="Team Photo">
                            </div>
                            <div class="team-text">
                                <a
                                    href="{{ route('service.provider.details', $expert->slug) }}">{{ __(ucwords($expert->fullname)) }}</a>
                                <p>{{ $expert->designation }}</p>
                            </div>
                            @if($expert->social)
                            <div class="team-social">
                                <ul>
                                    @if($expert->social->facebook)
                                    <li><a href="{{$expert->social->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                     @if($expert->social->twitter)
                                    <li><a href="{{$expert->social->twitter}}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if($expert->social->youtube)
                                    <li><a href="{{$expert->social->youtube}}"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty

                            <div class="col-12 col-md-6 col-sm-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="empty-state" data-height="400">
                                            <div class="empty-state-icon">
                                                <i class="far fa-sad-tear"></i>
                                            </div>
                                            <h2>@changeLang('Sorry We could not find any data')</h2>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
              

                @endforelse

            </div>
        </div>
    </div>
    <!--Service End-->


@else
<!--Team Area Start-->
<div class="team-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <h1>{{ __(@$content->data->title) }}</h1>
                    <p>{{ __(@$content->data->sub_title) }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="team-carousel owl-carousel">
                    @forelse ($featureds as $feature)
                        <div class="team-item">
                            <div class="team-photo">
                                <img src="@if ($feature->image) {{ getFile('user', $feature->image) }} @else {{ getFile('logo', $general->default_image) }} @endif" >
                            </div>
                            <div class="team-text">
                                <a
                                    href="{{ route('service.provider.details',$feature->slug) }}">{{ __(ucwords($feature->fullname)) }}</a>
                                <p>{{ __($feature->designation) }}</p>
                                <p><span><b><i class="fas fa-street-view"></i>
                                            {{ @$feature->address->city }}</b></span>
                                </p>
                            </div>
                            @if ($feature->social)
                                <div class="team-social">
                                    <ul>
                                        @if ($feature->social->facebook)
                                            <li><a href="{{ $feature->social->facebook }}"><i
                                                        class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if ($feature->social->twitter)
                                            <li><a href="{{ $feature->social->twitter }}"><i
                                                        class="fab fa-twitter"></i></a></li>
                                        @endif
                                        @if ($feature->social->youtube)
                                            <li><a href="{{ $feature->social->youtube }}"><i
                                                        class="fab fa-youtube"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @empty

                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
<!--Team Area End-->
@endif


@push('custom-css')

    <style>
        .empty-state {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
        }

        .empty-state .empty-state-icon {
            position: relative;
            background-color: #ca9520;
            width: 80px;
            height: 80px;
            line-height: 100px;
            border-radius: 5px;
        }

        .empty-state .empty-state-icon i {
            font-size: 40px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .empty-state h2 {
            font-size: 20px;
            margin-top: 30px;
        }

        .empty-state p {
            font-size: 16px;
        }

    </style>

@endpush