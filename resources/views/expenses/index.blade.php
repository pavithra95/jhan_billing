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

        <h4 class="m-0 text-dark col-md-6 float-left">All Expenses</h4>

        <a class="btn btn-primary float-right btn-sm" href="/expenses/create">NEW</a>
    </div>
</div>
<br>
<br>
 <div class="row">
       <form action="" method="GET"  role="form">

        
          
          <div class="row">


            
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">From Date</label>
                
                <input type="text" name="from_date" class="date-picker form-control" value="{{ $from }}" autocomplete="off" placeholder="From Date">
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">To Date</label>
                
                <input type="text" name="to_date" class="date-picker form-control"  value="{{ $to }}" autocomplete="off" placeholder="To Date">
              </div>
            </div>
            
            {{-- <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Invoice No</label>
                <input type="text" name="inv_no" class="form-control"  value="{{ $inv_no }}" autocomplete="off" placeholder="Invoice No">
                
               
              </div>
            </div> --}}
            
  <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Category</label>
                
                    <select name="category_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($category as $c)
                           <option @if ($category_id == $c->id) selected=""
                               {{-- expr --}}
                           @endif value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
            </div>


  </div>
   
            <button type="submit" class="btn btn-primary" style="margin-left: 10px">Filter</button>
            @if(!empty($_GET))


      <a style="margin-left: 10px;" href="/{{ request()->path() }}" class="btn btn-primary float-right">
          Clear Filter
      </a>
      @endif
</div>

</form>
</div>

<br>



                <table id="example" class="table table-hover table-light" style="width:100%">
               <thead class="thead-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Expense Date</th>
                           
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Created Date</th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            
                            <td><a href="/expenses/{{ $item->id }}">
                                {{ $item->date}}</td>
                                <td>
                                    {{$item->amount}}
                                </td>
                               
                                 <td>
                                    {{$item->Category->name}}
                                </td> 
                                <td>
                                    {{$item->created_at}}
                                </td>
                                 <td>
                              <a href="/expenses/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/expenses/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
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
@stop
