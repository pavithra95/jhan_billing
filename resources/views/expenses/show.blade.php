@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">Expense Details</h4>
         <a class="btn btn-primary float-right margin-right btn-sm" href='/expenses'>Back </a>
         @if(auth()->user()->privilege == "admin")

           <button type="button" class="btn btn-danger float-right margin-right btn-sm" data-toggle="modal" data-target="#exampleModalLong">
             Delete
        </button>
        @endif

       
       
        <a class="btn btn-warning float-right margin-right btn-sm" href="/expenses/{{ $expense->id }}/edit"> Edit </a>

    </div>
</div>
<br>

              <div class="row">
                <div class="col-md-3">
                  <h5>Date</h5>
                  <span>{{$expense->date}}</span>
                </div>
               <!--<div class="col-md-3">
                  <h5>Image</h5>
                  <span>{{$expense->image}}</span>
                </div>-->
                <div class="col-md-3">
                  <h5>Amount</h5>
                  <span>{{$expense->amount}}</span>
                </div>
                <div class="col-md-3">
                  <h5>Category</h5>
                  <span>{{$expense->Category->name}}</span>
                </div>
                <div class="col-md-3">
                  <h5>Notes</h5>
                  <span>{{$expense->notes}}</span>
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
         <a class="btn btn-danger" href="/expenses/{{ $expense->id }}/delete">Delete</a>
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


