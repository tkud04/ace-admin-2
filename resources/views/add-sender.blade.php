@extends('layout')

@section('title',"Add SMTP Sender")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('add-sender')}}" id="add-sender-form" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" id="spp-s" value="show">
                <div class="block">
                    <div class="header">
                        <h2>Add new SMTP sender (to power the system's email)</h2>
                    </div>
                    <div class="content controls">
					<div class="form-row">
                                <div class="col-md-3">Full name:</div>
								<div class="col-md-9">
							      <input type="text" class="form-control" name="name" id="as-name" placeholder="Sender name e.g Ace Luxury Store" value="Ace Luxury Store" required/>
								 </div>
								</div>
						<div class="form-row" id="server-form-row">
                            <div class="col-md-3">Choose server:</div>
                            <div class="col-md-9">
							  <select class="form-control" id="server" name="server">
							    <option value="none">Select SMTP server</option>
								<?php
								 $servers = ['gmail' => "Gmail",'yahoo' => "Yahoo mail",'other' => "Other"];
								foreach($servers as $key => $value){
								//$ss = $product['status'] == $key ? " selected='selected'" : "";
								?>
								 <option value="{{$key}}">{{$value}}</option>
								<?php
								}
								?>
							  </select>
							</div>
                        </div>
                        <div id="as-other">
						<div class="form-row">
							   <div class="col-md-3">SMTP host:</div>
							   <div class="col-md-9">
							      <input type="text" class="form-control" name="ss" id="as-server" placeholder="Server address e.g smtp.gmail.com"/>
								 </div>
								</div>
								<div class="form-row">
							   <div class="col-md-3">SMTP port:</div>
							   <div class="col-md-9">
							      <input type="number" class="form-control" name="sp" id="as-sp" placeholder="Port e.g 587" value="587"/>
								 </div>
								</div>
								<div class="form-row">
                                <div class="col-md-3">Encryption:</div>
								<div class="col-md-9">
							      <select class="form-control" name="sec" id="as-sec" style="margin-bottom: 5px;">
							        <option value="nonee">Select encryption</option>
								    <?php
								     $secs = ['tls' => "TLS",'ssl' => "SSL",'none' => "No encryption"];
								     foreach($secs as $key => $value){
								    ?>
								    <option value="{{$key}}">{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								 </div>
								</div>
							  </div>
								<div class="form-row">
                                <div class="col-md-3">Username</div>
								<div class="col-md-9">
							      <input type="text" class="form-control" name="username" id="as-username" placeholder="Login username/email" required/>
								 </div>
								</div>
								<div class="form-row">
                                <div class="col-md-3">Password</div>
								<div class="col-md-7">
							      <input type="password" class="form-control" name="password" id="as-password" placeholder="Password" required/>
								 </div>
								<div class="col-md-2">
									<button id="spp-show" class="btn-default btn-block btn-clean">Show</button>
								</div>
								</div>
                        
						<div class="form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
							  <center>
							    <button type="submit" id="add-sender-submit" class="btn btn-default btn-block btn-clean">Submit</button>
							  </center>
							</div>
                            <div class="col-md-4"></div>							
                        </div>
                                              
                    </div>
                </div>  
            </form>				
            </div>
@stop