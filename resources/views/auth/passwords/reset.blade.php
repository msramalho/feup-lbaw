@extends('layouts.app')

@section('title', "Vecto: Reset Password")

@section('content')
<div class="container passwordForgotten">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="text-center">
                <h3><i class="fa fa-lock fa-4x"></i></h3>
                <h2 class="text-center">Reset Password</h2>
                <div class="panel-body">
                    <div class="text-center">
                        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                            @include("partials.errors")
                            {{ csrf_field() }}
                            <fieldset>
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <label for="email" style="display:none">Email</label>
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <input name="email" placeholder="email address" class="form-control" type="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="form-grouformp{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                                <div class="input-group">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
