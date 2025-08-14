@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">View Tax Group</h4>
         <a class="btn btn-primary float-right ml-3 btn-sm" href='/tax-groups'>Back </a>
           @if(auth()->user()->privilege == "admin")

           <a href="/tax-groups/{{$tax->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
           @endif
       
       
        <a class="btn btn-warning float-right ml-3 btn-sm" href="/tax-groups/{{ $tax->id }}/edit"> Edit </a>

    </div>
</div>
<br>


                

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">Tax Type</label>
                               <span>{{$tax->group_type}}</span>
                            </div>

                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Tax Group Description</label>
                               <span>{{$tax->description}}</span>

                            </div>

                            

                             
                          

                            
                            
                            {{-- <div class="form-group @if($errors->has('price')) text-danger @endif">
                                <label for="">Selling Price</label>
                                <input type="number" name="price" class="form-control" value="" required="required" min="1">
                                @if($errors->has('price'))
                                    <div class="error text-danger">{{ $errors->first('price') }}</div>
                                @endif

                            </div> --}}
                        </div>
                        <div class="col-md-6">
                             
                            <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Tax Group Name</label>
                                <span>{{$tax->group_type_name}}</span>

                            </div> 
                        </div>
                        <div class="col-md-12">
                        <div class="col-md-3">
                             <div class="form-group">
                            <label for="">Taxes</label><br>
                            <ul>
                              @foreach ($groups as $item)
                               <li>{{$item->Tax->name}}</li>
                              @endforeach
                            </ul>
                       

                            

                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tax Percentage</label><br>
                            <ul>
                              @foreach ($groups as $item)
                               <li>{{$item->Tax->percentage}} %</li>
                              @endforeach
                            </ul>
                       

                            
                        </div>
                        </div>
                        </div>



                    
                    
                  
            </div>
        </div>
    </div>
</div>

@stop

