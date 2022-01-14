@extends('frontEn.layouts.master')
@inject('bloodTypes', 'App\Models\BloodType')
@inject('cities', 'App\Models\City')
@section('content')
<body>
    @include('frontEn.layouts.header')
    <div class="intro">
        <div id="slider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#slider" data-slide-to="0" class="active"></li>
                <li data-target="#slider" data-slide-to="1"></li>
                <li data-target="#slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item carousel-1 active">
                    <div class="container info en">
                        <div class="col-lg-5">
                            <h3>Blood bank moving forward to better health</h3>
                            <p>
                                There is a proven fact from a long time ago that the readable content of a page will not distract the reader from focusing on the. 
                            </p>
                            <a href="#">more</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-2">
                    <div class="container info en">
                        <div class="col-lg-5">
                            <h3>Blood bank moving forward to better health</h3>
                            <p>
                                There is a proven fact from a long time ago that the readable content of a page will not distract the reader from focusing on the. 
                            </p>
                            <a href="#">more</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-3">
                    <div class="container info en">
                        <div class="col-lg-5">
                            <h3>Blood bank moving forward to better health</h3>
                            <p>
                                There is a proven fact from a long time ago that the readable content of a page will not distract the reader from focusing on the. 
                            </p>
                            <a href="#">more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--about-->
    <div class="about">
        <div class="container">
            <div class="col-lg-6 text-center">
                <p>
                    <span>Blood Bank</span> There is a proven fact from a long time ago that the readable content of a page will not distract the reader from focusing on the external appearance of the text or the form of the paragraphs placed on the page he reads.
                </p>
            </div>
        </div>
    </div>
    
    <!--articles-->
    <div class="articles">
        <div class="container title">
            <div class="head-text">
                <h2>Articles</h2>
            </div>
        </div>
        <div class="view">
            <div class="container">
                <div class="row">
                    <!-- Set up your HTML -->
                    <div class="owl-carousel articles-carousel">
                        @if ($postMessage==null)
                        @foreach ($posts as $post)
                        <div class="card">
                            <div class="photo">
                                <img src={{asset('images/'.$post->image)}} class="card-img-top" alt="...">
                                <a href="article-details.html" class="click">المزيد</a>
                            </div>
                            <a class="favourite">
                                <i url={{route('client.toggle-favourite')}} class="far fa-heart @if ($post->clients()->exists(auth()->user()->id))
                                    red-heart
                                @endif" onclick="toggle(this)" id="{{$post->id}}"></i>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{$post->title}}</h5>
                            </div>
                        </div> 
                        @endforeach
                        @else
                        <p>{{$postMessage}}</p>
                        @endif
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--requests-->
    <div class="requests">
        <div class="container">
            <div class="head-text">
                <h2>Donation requests</h2>
            </div>
        </div>
        <div class="content">
            <div class="container">
                <form class="row filter" method="GET" action={{url()->current()}}>
                    <div class="col-md-5 blood">
                        <div class="form-group">
                            <div class="inside-select">
                                <select class="form-control" id="blood-type-filter" name='blood_type_id'>
                                    <option selected disabled>Choose The Blood Type</option>
                                    @foreach ($bloodTypes->all() as $bloodType)
                                     <option value={{$bloodType->id}}
                                    >{{$bloodType->name}}</option>   
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 city">
                        <div class="form-group">
                            <div class="inside-select">
                                <select class="form-control" id="city-filter" name="city_id">
                                    <option selected disabled>Choose The City</option>
                                    @foreach ($cities->all() as $city)
                                    <option value={{$city->id}}>{{$city->name}}
                                    </option>   
                                   @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="patients">
                    @if ($donationRequestMessage==null)
                    @foreach ($donationRequests as $donationRequest)
                    <div class="details">
                        <div class="blood-type">
                            <h2 dir="ltr">{{$donationRequest->bloodType->name}}</h2>
                        </div>
                        <ul>
                            <li><span>Pataint Name:</span>{{$donationRequest->patient_name}}</li>
                            <li><span>Hospital Address:</span>{{$donationRequest->hospital_address}}</li>
                            <li><span>City:</span>{{$donationRequest->city->name}}</li>
                        </ul>
                        <a href="inside-request.html">التفاصيل</a>
                    </div>    
                    @endforeach  
                    @else
                    <p>{{$donationRequestMessage}}</p>
                    @endif
                </div>
                <div class="more">
                    <a href="donation-requests-ltr.html">More</a>
                </div>
            </div>
        </div>
    </div>
    
    <!--contact-->
    <div class="contact">
        <div class="container">
            <div class="col-md-7">
                <div class="title">
                    <h3>Contact us</h3>
                </div>
                <p class="text">You can contact us to inquire about information and you will be answered</p>
                <div class="row whatsapp">
                    <a href="#">
                        <img src="imgs/whats.png">
                        <p dir="ltr">+002  1215454551</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!--app-->
    <div class="app">
        <div class="container">
            <div class="row">
                <div class="info col-md-6">
                    <h3>Blood bank app</h3>
                    <p>
                        This text is an example of text that can be replaced in the same space. This text was generated from.
                    </p>
                    <div class="download">
                        <h4>Available on</h4>
                        <div class="row stores">
                            <div class="col-sm-6">
                                <a href="#">
                                    <img src="imgs/google.png">
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="#">
                                    <img src="imgs/ios.png">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="screens col-md-6">
                    <img src="imgs/App.png">
                </div>
            </div>
        </div>
    </div>
    @include('frontEn.layouts.footer')
</body> 
@endsection