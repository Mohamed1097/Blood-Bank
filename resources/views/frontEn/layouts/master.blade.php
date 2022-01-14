<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        
        <!--google fonts css-->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!--font awesome css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="icon" href={{asset("imgs/icon.png")}}>
        
        <!--owl-carousel css-->
        <link rel="stylesheet" href={{asset('front/css/owl.carousel.min.css')}}>
        <link rel="stylesheet" href={{asset('front/css/owl.theme.default.min.css')}}>
        <link rel="stylesheet" href={{asset('front/css/style.css')}}>
        
        <!--override on style css-->
        <link rel="stylesheet" href={{ asset('front/css/style-ltr.css') }}>
        
        <title>{{$title}}</title>
    </head>
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src={{asset('plugins/jquery/jquery.min.js')}}></script>    
    <script src={{asset('front/js/bootstrap.bundle.js')}}></script>
    <script src={{asset('front/js/bootstrap.bundle.min.js')}}></script>
  
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <script src={{asset('front/js/owl.carousel.min.js')}}></script>
    
    <script src={{asset('front/js/main-ltr.js')}}></script>
    <script src={{asset('adminlte/js/custom.js')}}></script>

</body>
</html>