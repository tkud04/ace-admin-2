@extends('layout')

@section('title',"Add Courier")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('add-courier')}}" id="ac-form">
				{!! csrf_field() !!}
				<div class="block">
                    <div class="header">
                        <h2>Add new courier</h2>
                    </div>
                    <div class="content controls">
					           <div class="form-row">
                                <div class="col-md-3">Name:</div>
								<div class="col-md-9">
							      <input type="text" class="form-control" name="name" id="ac-name" placeholder="Courier name e.g Fedex" required/>
								 </div>
								</div>
								<div class="form-row">
								<div class="col-md-3">Nickname:</div>
								<div class="col-md-9">
							      <input type="text" class="form-control" name="nickname" id="ac-nickname" placeholder="System nickname e.g fedex" required/>
								 </div>
								</div>
								
								<div class="form-row">
                                <div class="col-md-3">Type:</div>
								<div class="col-md-9">
							      <select class="form-control" name="type" id="ac-type" style="margin-bottom: 5px;">
							        <option value="none">Select type</option>
								    <?php
								     $types = [
									     'prepaid' => "Prepaid",
									     'pod' => "Pay on Delivery"
										 ];
										 
								     foreach($types as $key => $value){
										
								    ?>
								    <option value="{{$key}}">{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								 </div>
								</div>
								
								<div class="form-row">
                                <div class="col-md-3">Price (&#8358;):</div>
								<div class="col-md-9">
							      <input type="number" class="form-control" name="price" id="ac-price" required/>
								 </div>
								</div>
						

								<div class="form-row">
                                <div class="col-md-3">Coverage:</div>
								<div class="col-md-9">
							      <select class="form-control" name="coverage" id="ac-coverage" style="margin-bottom: 5px;">
							        <option value="none">Select coverage</option>
								    <?php
								     $cvgs = [
									     'lagos' => "Lagos",
									     'sw' => "Southwest states",
									     'others' => "Other states",
									     'individual' => "Select state"
										 ];
										 
								     foreach($cvgs as $key => $value){
										
								    ?>
								    <option value="{{$key}}">{{$value}}</option>
								    <?php
								    }
								    ?>
							      </select>
								  <select class="form-control" name="coverage_individual" id="ac-coverage-individual" style="margin-bottom: 5px;">
							        <option value="none">Select state</option>
								    <?php
							
							 foreach($states as $key => $value)
							 {
								
						    ?>
                           
							   <option value="{{$key}}">{{$value}}</option>
							<?php
							 }
                            ?>
							      </select>
								 </div>
								</div>
                        
						<div class="form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
							  <center>
							  <span class="text-danger text-bold" id="ac-validation-error">All fields are required</span>
							    <button type="submit" id="ac-submit" class="btn btn-default btn-block btn-clean">Submit</button>
							  </center>
							</div>
                            <div class="col-md-4"></div>							
                        </div>
                                              
                    </div>
                </div>  
            </form>				
            </div>
@stop