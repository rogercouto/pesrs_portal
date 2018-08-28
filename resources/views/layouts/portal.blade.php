<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Polo Eduacacional Superior de Restinga Sêca</title>
    <!--Styles-->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <!--Font awesome icons-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome-all.min.css')}}">
    <!-- Toast -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.toast.min.css')}}" media="all" />
    <!-- Website CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/portal.css') }}" >
    @stack('libs')
</head>
<body>
    <header>
        <!-- Banner -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                @foreach(($postsWB = \App\Helpers\PageHelper::getPostsWithBanners()) as $postWB)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index+1}}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Carousel Items -->
                <div class="carousel-item active">
                    <a>
                        <img class="d-block img-fluid banner" src="{{asset('img/header.png')}}" />
                    </a>
                </div>
                @foreach($postsWB as $postWB)
                    <div class="carousel-item">
                        <a href="{{route('post',['id'=>$postWB->id])}}">
                            <img class="d-block img-fluid banner" src="{{asset($postWB->bannerUrl())}}" />
                        </a>
                    </div>
                @endforeach
                <!-- /Carousel items -->
            </div>
            <!-- Carousel Indicators -->
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <!-- /Carousel Indicators-->
        </div>
        <!--Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark  top-navbar" data-toggle="sticky-onscroll">
            <div class="container">
                <a class="navbar-brand" href="{{route('main')}}"><i class="fa fa-home"></i>
                    <span style="color: {{Request::url()==route('main')?'#FFFFFF':'#BBBBBB'}};">Home</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav pull-right">
                        @foreach(\App\Helpers\PageHelper::getMenuItems() as $menuItem)
                            @if(sizeof($menuItem->children)==0)
                                <li class="nav-item">
                                    <a class="nav-link{{($menuItem->url==Request::url())?' active':''}}" href="{{$menuItem->url}}">{{$menuItem->name}}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle{{\App\Helpers\PageHelper::isActive($menuItem,Request::url())}}" href="#" id="navbarDropdownMenuLink"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$menuItem->name}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach($menuItem->children as $submenu)
                                            <a class="dropdown-item" href="{{$submenu->url}}">{{$submenu->name}}</a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
        <!--Navbar-->
    </header>
    <div id="maindiv">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <footer>
        <div class="footer navbar-bottom navbar-inverse">
            <div class="container">&nbsp;</div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <p>
                            Polo Educacional Superior de Restinga S&ecirc;ca<br/>
                            Rua: José Celestino Alves - 134, Bairro: Centro <br/>Restinga S&ecirc;ca - RS Cep: 97200-000</p>
                    </div>
                    <div class="col-sm-4">
                        <p>Telefone: (55) 3261-4778<br/>
                            E-mail: uabrestingaseca@gmail.com</p>
                    </div>
                    <div class="col-sm-4">
                        <p>Facebook:</p>
                        <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fuabrestingaseca%2F&width=300&layout=standard&action=like&size=large&show_faces=true&share=true&height=80&appId" width="300" height="80" style="font-color:#FFF; border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="container">
                <p class="adm-anchor">
                    <a style="color: #00334d" href="{{route('home')}}">&Aacute;rea restrita</a>
                </p>
            </div>
        </div>
    </footer>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/sticky.navbar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.toast.min.js')}}"></script>
    @stack('scripts')
    @include('messages')
</body>
</html>