@extends('layout.master')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <h4 class="m-0 text-dark">Create user</h4>
                     <br>
                    
                    <form method="POST" action="" role="form" class="col-md-12 " autocomplete="off">
                      

      {{csrf_field()}}

                       <div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
     <div class="col-md-6">
    
    <input type="text" name="name" id= "name" class="form-control" required="true" value="" style="width: 330px; height: 34px"/>
</div>
   </div> 
   
 
   <div class="form-group row">
     <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
   <div class="col-md-6">
    <input type="text" name="email" id= "email" class="form-control" style="width: 330px; height: 34px" value="" />
   </div>
</div>
 <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" style="width: 330px; height: 34px" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

 <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                 <input id="password-confirm" type="password" class="form-control" style="width: 330px; height: 34px" name="password_confirmation" required autocomplete="new-password" >


                                
                            </div>
                        </div>

                       
                        


                            
                        <div class="form-group row">
                            <label for="privilege" class="col-md-4 col-form-label text-md-right">{{ __('Privilege') }}</label>

                            <div class="col-md-6">
                                <select style="width: 330px; height: 34px" class="form-control"  id="privilege" name="privilege" >

                                <option  value="admin"  >Admin</option>
                                <option  value="employee"  >Employee</option>
                               
                               
                               

                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <select style="width: 330px; height: 34px" class="form-control"  id="status" name="status" >

                                   <option  value="active"  >Active</option>
                                    <option  value="inActive"  >InActive</option>
                               
                              
                               

                                </select>
                            </div>
                        </div>
                         &nbsp;

                         <div class="col-md-4 offset-md-4">
                            
                         {{-- <button type="submit" class="btn btn-primary" style="position: absolute;left: 30%">Submit</button> --}}
                         <button type="submit" class="btn btn-primary">Submit</button>

                         {{-- <a class='btn btn-primary' href='../product-details' style="background-color: #337ab7;border-color: #2e6da4;position: absolute;left: 40%">Cancel <span class='glyphicon glyphicon-plus-sign'></span></a> --}}
                         <a class='btn btn-primary' href='/users'>Cancel <span class='glyphicon glyphicon-plus-sign'></span></a>
    
                    
                        </div>

   
  
                </div>
            </div>
        </div>
    </div>
@stop
