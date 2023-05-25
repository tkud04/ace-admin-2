@extends('login_layout')

@section('title',"Sign up")

@section('content')
        <form method="post" action="{{url('register')}}">
			{!! csrf_field() !!}
  <div class="registration-block">
            <div class="block block-transparent">
                <div class="head tac">                    
                   <img src="img/icon.png" class="img-circle img-thumbnail"/>
                </div>
                <div class="content controls npt">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-user"></span>
                                </div>
                                <input type="text" class="form-control" name="fname" placeholder="First Name"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-user"></span>
                                </div>
                                <input type="text" class="form-control" name="lname" placeholder="Last Name"/>
                            </div>
                        </div>
                    </div>                  
                    <div class="form-row" style="margin-top: 10px;">   
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-envelope"></span>
                                </div>
                                <input type="text" class="form-control" name="email" placeholder="E-mail address"/>
                            </div>
                        </div>
						 <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-phone"></span>
                                </div>
                                <input type="text" class="form-control" name="phone" placeholder="Phone number"/>                                
                            </div>
                        </div>
                    </div>                    
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-lock"></span>
                                </div>
                                <input type="password" class="form-control" name="pass" placeholder="Password"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="icon-unlock-alt"></span>
                                </div>
                                <input type="password" class="form-control" name="pass_confirmation" placeholder="Confirm password"/>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <label><input type="checkbox" checked/> Agree with terms and conditions</label>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-default btn-block btn-clean">Submit</button>
                        </div>
                    </div>                    
                                   
                </div>
            </div>
        </div>
	 </form>
@stop