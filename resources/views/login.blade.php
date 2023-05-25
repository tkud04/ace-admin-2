@extends('login_layout')

@section('title',"Sign in")

@section('content')
        <form method="post" action="{{url('login')}}">
			{!! csrf_field() !!}
        <div class="login-block">
            <div class="block block-transparent">
                <div class="head">
                    <div class="user">
                                                                             
                            <img src="img/icon.png" class="img-circle img-thumbnail"/>
                            <div class="user-change-button">
                                <span class="icon-off"></span>
                         
                        </div>                            
                    </div>
                </div>
                <div class="content controls npt">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-user"></span>
                                </div>
                                <input type="text" class="form-control" name="id" placeholder="Login"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-key"></span>
                                </div>
                                <input type="password" class="form-control" name="pass" placeholder="Password"/>
                            </div>
                        </div>
                    </div>                        
                    <div class="form-row">
                        <div class="col-md-6">
                            <a href="{{url('register')}}" class="btn btn-default btn-block btn-clean">Register</a>                                
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-default btn-block btn-clean">Log In</button>
                        </div>
                    </div>
                    <div class="form-row">                            
                        <div class="col-md-12">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
	 </form>
@stop