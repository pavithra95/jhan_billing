@extends('layout.master')



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">View User</h4>
         <a class="btn btn-primary float-right margin-right btn-sm" href='/users'>Back </a>
           @if(auth()->user()->privilege == "admin")

           <button type="button" class="btn btn-danger float-right margin-right btn-sm" data-toggle="modal" data-target="#exampleModalLong">
             Delete
        </button>
        @endif

       
       
        <a class="btn btn-warning float-right margin-right btn-sm" href="/users/{{ $user->id }}/edit"> Edit </a>

    </div>
</div>
<br>

              <div class="row">
                <div class="col-md-3">
                  <h5>Name</h5>
                  <span>{{$user->name}}</span>
                </div>
                <div class="col-md-3">
                  <h5>Email</h5>
                  <span>{{$user->email}}</span>
                </div>
                <div class="col-md-3">
                  <h5>Privilege</h5>
                  <span>{{$user->privilege}}</span>
                </div>
               
                
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       Are You Sure..You Want to Delete
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
         <a class="btn btn-danger" href="/delete/{{$user->id}}">Delete</a>
      </div>
    </div>
  </div>
</div>


<style>
    .margin-right {
        margin-left: 10px;
    }
</style>

@stop



