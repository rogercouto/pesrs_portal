<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>Polo Educacional Superior de Restinga Sêca - Área administrativa</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootadmin.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.toast.min.css')}}" media="all" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('css/adm.css') }}" >
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootadmin.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.toast.min.js')}}"></script>
    <!-- Libraries -->
    @stack('libs')
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand navbar-dark" style="background-color: #204d74;">
        <a class="sidebar-toggle mr-3 d-block d-sm-none" href="#"><i class="fa fa-bars"></i></a>
        <a class="navbar-brand" href="#"><img title="logo" src="{{asset('img/logo_small.png')}}"></a>
        <div class="navbar-collapse collapse">

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" id="dd_notification" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i>
                        @if(($count = \App\Helpers\AdmHelper::newMessageCount()) > 0)
                            <span class="badge badge-light">{{$count}}</span>
                        @endif
                    </a>
                    @if($count > 0)
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_notification">
                            <a href="{{route('messages')}}" class="dropdown-item"><span>{{$count}} nova(s) mensagen(s)</span></a>
                        </div>
                    @endif
                </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                        <!--
                        <a href="#" class="dropdown-item"><i class="fa fa-address-card"></i> Perfil</a>
                        -->
                        <a href="{{route('logout')}}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        ><i class="fa fa-sign-out-alt"></i> Sair</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="d-flex">
        <div class="sidebar sidebar-dark bg-dark">
            <ul class="list-unstyled">
                <li>
                    <a href="#sm_expand_1" data-toggle="collapse">
                        <i class="fa fa-fw fa-newspaper"></i> Postagens
                    </a>
                    <ul id="sm_expand_1" class="list-unstyled collapse">
                        <li><a href="{{route('posts.create')}}"><i class="fa fa-plus-square"></i> Criar</a></li>
                        <li><a href="{{route('posts.index')}}"><i class="fa fa-list"></i> Listar</a></li>
                        <!--
                        <li><a href="#"><i class="fa fa-search"></i> Pesquisar</a></li>
                        -->
                    </ul>
                </li>
                <li>
                    <a href="{{route('tags.index')}}"><i class="fa fa-fw fa-tags"></i>Tags</a>
                </li>
                <li>
                    <a href="{{route('messages')}}"><i class="fa fa-fw fa-envelope"></i>Mensagens</a>
                </li>
                @if(\App\Helpers\AdmHelper::isAdmin())
                    <li>
                        <a href="#sm_expand_3" data-toggle="collapse">
                            <i class="fa fa-fw fa-ellipsis-h"></i> Menu
                        </a>
                        <ul id="sm_expand_3" class="list-unstyled collapse">
                            <li><a href="{{route('menus.create')}}"><i class="fa fa-plus-square"></i> Criar item</a></li>
                            <li><a href="{{route('menus.index')}}"><i class="fa fa-list"></i> Listar itens</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#sm_expand_4" data-toggle="collapse">
                            <i class="fa fa-fw fa-file-alt"></i> Páginas
                        </a>
                        <ul id="sm_expand_4" class="list-unstyled collapse">
                            <li><a href="{{route('pages.create')}}"><i class="fa fa-plus-square"></i> Criar</a></li>
                            <li><a href="{{route('pages.index')}}"><i class="fa fa-list"></i> Listar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('settings')}}"><i class="fa fa-fw fa-cog"></i>Configurações</a>
                    </li>
                @endif
                <!--
                <li>
                    <a href="#sm_expand_5" data-toggle="collapse">
                        <i class="fa fa-fw fa-users"></i> Usuários
                    </a>
                    <ul id="sm_expand_5" class="list-unstyled collapse">
                        <li><a href="#"><i class="fa fa-plus-square"></i> Criar</a></li>
                        <li><a href="#"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>
                -->
            </ul>
        </div>
        <div class="content p-4">
            <h2 class="mb-4">{{isset($title)?$title:''}}</h2>
            <div class="card mb-4">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('adm.messages')
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>