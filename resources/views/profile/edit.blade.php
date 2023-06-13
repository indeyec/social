@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">

            <h1>Редактирование профиля</h1>
            <form method="POST" action="{{ route('profile.edit') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="last_name">Ваша фамилия</label>
                    <input type="text" name="last_name"
                           class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" id="last_name"
                           value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
                    @if ($errors->has('last_name'))
                        <span class="help-block text-danger">
                    {{ $errors->first('last_name') }}
                </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="first_name">Ваше имя</label>
                    <input type="text" name="first_name"
                           class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" id="first_name"
                           value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
                    @if ($errors->has('first_name'))
                        <span class="help-block text-danger">
                    {{ $errors->first('first_name') }}
                </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="middle_name">Ваше отчество</label>
                    <input type="text" name="middle_name"
                           class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" id="middle_name"
                           value="{{ Request::old('middle_name') ?: Auth::user()->middle_name }}">
                    @if ($errors->has('middle_name'))
                        <span class="help-block text-danger">
                    {{ $errors->first('middle_name') }}
                </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary mt-3">Обновить профиль</button>
            </form>

        </div>
    </div>
@endsection

