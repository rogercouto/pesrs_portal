<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="">-->
    <title>Polo Educacional Superior de Restinga Seca - Login</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{asset('css/login-form.css')}}">
</head>
<body class="text-center">
<form class="form-signin" method="POST" action="{{route('login')}}">
    @csrf
    <img class="mb-4" src="{{ asset('img/logo_small.png') }}" alt="">
    <h1 class="h3 mb-3 font-weight-normal">Por favor identifique-se</h1>
    <label for="inputEmail" class="sr-only">Email</label>
    <input name="email" value="{{ old('email') }}" type="email" id="inputEmail" class="form-control" placeholder="E-mail"
           required autofocus onchange="checkForm()">
    <label for="inputPassword" class="sr-only">Senha</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Senha"
           required onkeyup="checkForm()">
    @if($errors->any())
        <span style="color: #FF0000">Login(e) ou senha inválido(s)!</span>
    @endif
    <button id="buttonSubmit" class="btn btn-lg btn-primary btn-block" type="submit" disabled="disabled">Entrar</button>
    <p class="mt-5 mb-3 text-muted">&copy; Polo Educacional Superior de Restinga Sêca</p>
</form>
<script type="text/javascript">
    function checkForm(){
        var disabled = false;
        if (document.getElementById("inputEmail").value == "")
            disabled = true;
        if (document.getElementById("inputPassword").value == "")
            disabled = true;
        document.getElementById("buttonSubmit").disabled = disabled;
    }
</script>
</body>
</html>
