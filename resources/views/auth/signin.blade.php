@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h1>Войти на сайт</h1>
            <form method="POST" action="{{ route('auth.signin') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"
                           placeholder="например, test@mail.ru"
                           value="{{ Request::old('email') ?: '' }}">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                    {{ $errors->first('email') }}
                </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" name="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password"
                           placeholder="минимум 6 символов">
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                    {{ $errors->first('password') }}
                </span>
                    @endif
                </div>

                <div class="col-md-12 form-group">
                    {!! captcha_img('math') !!}
                    <input type="text" name="captcha" required>
                    @if ($errors->has('captcha'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('captcha') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="col-auto my-1">
                    <div class="custom-control custom-checkbox mr-sm-2 mb-3">
                        <input name="remember" type="checkbox" class="custom-control-input" id="remember">
                        <label class="custom-control-label" for="remember">Запомнить меня</label>
                    </div>

                    

                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
@endsection


