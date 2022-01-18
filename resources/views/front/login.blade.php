        @extends('front.layouts.master')
        @section('content')
         <body class="signin-account">
             @include('front.layouts.header')
            <div class="form">
                <div class="container">
                    <div class="path">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">تسجيل الدخول</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="signin-form">
                        <form action={{route('client.check')}} method="POST">
                            @csrf
                            <div class="logo">
                                <img src={{asset('imgs/logo.png')}}>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="الهاتف" name="phone">
                            </div>
                            @error('phone.required')
                            <small class="text-danger">{{__('message.phone')}}</small>  
                            @enderror
                            <div class="form-group">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="كلمة المرور" name="password">
                            </div>
                            @error('password.required')
                            <small class="text-danger">{{__('message.password')}}</small>  
                            @enderror
                            @error('failed')
                            <small class="text-danger">{{__('message.failed')}}</small>  
                            @enderror
                            
                            <div class="row options">
                                <div class="col-md-6 remember">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">تذكرنى</label>
                                    </div>
                                </div>
                                <div class="col-md-6 forgot">
                                    <img src={{asset('imgs/complain.png')}}>
                                    <a href="#">هل نسيت كلمة المرور</a>
                                </div>
                            </div>
                            <div class="row buttons">
                                <div class="col-md-6 right">
                                    <button>دخول</button>
                                </div>
                                <div class="col-md-6 left">
                                    <a href={{route('client.register')}}>انشاء حساب جديد</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('front.layouts.footer')
         </body>
        <!--form-->
        @endsection
        
     