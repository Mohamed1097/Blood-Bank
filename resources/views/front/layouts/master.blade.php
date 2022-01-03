<!doctype html>
<html lang="en" dir="rtl">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
        
        <!--google fonts css-->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!--font awesome css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="icon" href={{asset("imgs/icon.png")}}>
        
        <!--owl-carousel css-->
        <link rel="stylesheet" href={{asset('front/css/owl.carousel.min.css')}}>
        <link rel="stylesheet" href={{asset('front/css/owl.theme.default.min.css')}}>
        <link rel="stylesheet" href={{asset('front/css/style.css')}}>
        <!--style css-->
        
        <title>{{$title}}</title>
    </head>

        @yield('content')
        
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src={{asset('plugins/jquery/jquery.min.js')}}></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> --}}
        <script src={{asset('front/js/bootstrap.bundle.js')}}></script>
        <script src={{asset('front/js/bootstrap.bundle.min.js')}}></script>
      
        
      
        <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js" integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k" crossorigin="anonymous"></script>
        
        <script src={{asset('front/js/owl.carousel.min.js')}}></script>
        
        <script src={{asset('front/js/main.js')}}></script>

        <script src={{asset('adminlte/js/custom.js')}}></script>

</html>