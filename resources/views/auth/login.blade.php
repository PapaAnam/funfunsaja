<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Masuk Admin | {{ $_web->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/animate.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> --}}
    <style>
        .delay-1 {
            animation-delay: .5s;
        }
        .delay-2 {
            animation-delay: 1s;
        }
        .delay-3 {
            animation-delay: 1.5s;
        }
    </style>
</head>
<body>
    <body class="align">
        <div class="grid">
            <form action="{{ route('login') }}" method="post" class="form login animated bounceIn">
                {{ csrf_field() }}
                <header class="login__header">
                    <h3 class="login__title animated fadeIn delay-1">{{ $_web->title }}</h3>
                </header>
                <div class="login__body">
                    <div class="form__field animated fadeIn delay-2">
                        <input type="text" placeholder="Username" name="username" value="{{ old('username') }}" required>
                        @if($errors->has('username'))
                        <font color="red">{{ $errors->first('username') }}</font>
                        @endif
                    </div>
                    <div class="form__field animated fadeIn delay-2">
                        <input type="password" name="password" placeholder="Password" required>
                        @if($errors->has('password'))
                        <font color="red">{{ $errors->first('password') }}</font>
                        @endif
                    </div>
                </div>
                <footer class="login__footer">
                    <input type="submit" value="Masuk" class="animated fadeIn delay-3">
                </footer>
            </form>
        </div>
    </body>
</body>
</html>