@extends('layout.master')



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                     <h4 class="m-0 text-dark">All Users</h4>
     <div id="top_right_buttons" align="right">
     
   
    
            <a class='btn btn-primary' href='register' style="background-color: #337ab7;
    border-color: #2e6da4;">New User <span class='glyphicon glyphicon-plus-sign'></span></a>
    
    </div>
    <br>
                    
         <div class="col-md-12">
     <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Privilege </th>
                <th>Action </th>
               
         
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td> <a href="/users/{{ $user['id'] }}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                   
                    <td>{{$user->privilege}}</td>

                     <td>
                              <a href="/users/{{ $user['id'] }}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/delete/{{ $user->id }}"><i class="fa fa-trash" ></i></a>
                              @endif
                              
                            </td>
                   
                   
                </tr> 
            @endforeach
        </tbody>
    </table>
    


                </div>
            </div>
            </div>
        </div>
    </div>
@stop
