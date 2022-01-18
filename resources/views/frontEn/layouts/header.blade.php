<div class="upper-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="language">
                    <a href={{LaravelLocalization::getLocalizedURL('en')}} class="en active">EN</a>
                    <a href={{LaravelLocalization::getLocalizedURL('ar')}} class="ar inactive">عربى</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="social">
                    <div class="icons">
                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- not a member-->
            @if (!auth()->user())
            <div class="col-md-4">
                <div class="accounts">
                    <a href="create-account.html" class="create-new">create new account</a>
                    <a href="signin-account.html" class="signin">Sign in</a>
                </div> 
            @else
               <div class="member col-md-4">
                <p class="welcome">Welcome </p>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{auth()->user()->name}}
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index-1.html">
                            <i class="fas fa-home"></i>
                            Home
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="far fa-user"></i>
                            Info
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="far fa-bell"></i>
                            Notifications Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="far fa-heart"></i>
                            Favourites
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="far fa-comments"></i>
                            Report
                        </a>
                        <a class="dropdown-item" href="contact-us.html">
                            <i class="fas fa-phone-alt"></i>
                            Contact Us
                        </a>
                        <a href="{{ route('client.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-form dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            Log Out
                        </a>
                        <form id="logout-form" action="{{ route('client.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
            @endif
            
                

            

                
            </div>
        </div>
    </div>
</div>


<!--nav-->
<div class="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src={{asset('imgs/logo-ltr.png')}} class="d-inline-block align-top" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index-ltr.html">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">about us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donation-requests-ltr.html">donation requests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="who-are-us-ltr.html">who are us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us-ltr.html">contact us</a>
                    </li>
                </ul>
                <a href="#" class="donate">
                    <img src={{asset('imgs/transfusion.svg')}}>
                    <p>Ask donation</p>
                </a>
            </div>
        </div>
    </nav>
</div>