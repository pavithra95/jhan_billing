@extends('layout.master')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <h4 class="m-0 text-dark">Edit user</h4>
                     <br>
                    
                     <form method="post" enctype="multipart/form-data" action="{{url('user-edit') }}">

      {{csrf_field()}}

                       <div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
     <div class="col-md-6">
    <input type="hidden" name="id" value="{{ $usrs->id}}"/>
    <input type="text" name="name" id= "name" class="form-control" required="true" value="{{ $usrs['name']}}" style="width: 330px; height: 34px"/>
</div>
   </div> 
   
 
   <div class="form-group row">
     <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
   <div class="col-md-6">
    <input type="text" name="email" id= "email" class="form-control" style="width: 330px; height: 34px" value="{{$usrs->email}}" />
   </div>
</div>
<div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" style="width: 330px; height: 34px" type="text" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" min="8" max="12">

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
                                 <input id="password-confirm" type="text" class="form-control" style="width: 330px; height: 34px" name="password_confirmation" required autocomplete="new-password" min="8" max="12">


                                
                            </div>
                        </div>

                       
                        


                            
                        <div class="form-group row">
                            <label for="privilege" class="col-md-4 col-form-label text-md-right">{{ __('Privilege') }}</label>

                            <div class="col-md-6">
                                <select style="width: 330px; height: 34px" class="form-control"  id="privilege" name="privilege" >

                                <option @if($usrs->privilege == "admin") selected="" @endif value="admin"  >Admin</option>
                                <option @if($usrs->privilege == "employee") selected="" @endif value="employee"  >Employee</option>
                               
                               
                               

                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <select style="width: 330px; height: 34px" class="form-control"  id="status" name="status" >

                                   <option @if($usrs->status == "active") selected="" @endif value="active"  >Active</option>
                                    <option @if($usrs->status == "inActive") selected="" @endif value="inActive"  >InActive</option>
                               
                              
                               

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
