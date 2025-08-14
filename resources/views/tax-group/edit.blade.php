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

        <h4 class="m-0 text-dark col-md-6 float-left">Update Tax Group</h4>

    </div>
</div>
<br>


                <form action="/tax-groups/{{$tax->id}}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}
                    {{method_field('PUT')}}

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('name')) text-danger @endif">
                                <label for="">Tax Type</label>
                                <select name="group_type" id="inputGroup" class="form-control" required="required">
                                    <option @if ($tax->group_type == "GST-Tax") selected=""  @endif value="GST-Tax">GST TAX</option>
                                    <option @if ($tax->group_type == "CESS-Tax") selected=""  @endif value="CESS-Tax">CESS TAX</option>
                                </select>

                            </div>

                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Tax Group Description</label>
                                <textarea name="description" class="form-control">{{$tax->description}}</textarea>

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
                                <input type="text" name="group_type_name" class="form-control" value="{{$tax->group_type_name}}" required="required">

                            </div> 
                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">Tax Group State Type</label>
                               <select name="group_state_type" id="inputGroup_state_type" class="form-control" required="required">
                                 <option @if ($tax->group_state_type == "within_state") selected="" @endif value="within_state">Within State</option>
                                 <option  @if ($tax->group_state_type == "outside_state") selected="" @endif value="outside_state">Outside State</option>
                                 <option  @if ($tax->group_state_type == "all_over_india") selected="" @endif value="all_over_india">All Over India</option>
                               </select>

                            </div> 
                        </div>
                        <div class="col-md-12">
                             <div class="form-group">
                            <label for="">Taxes</label><br>
                           <select  name="taxes[]" class="form-control framework" multiple="" >
                            @foreach ($taxes as $item)
                                {{-- expr --}}
                               <option value="{{$item->id}}" @if (App\Models\TaxGroupItem::CheckTax($tax->id,$item->id)=='1')
                                 {{'selected'}} @endif>{{$item->name}}</option>
                            @endforeach
                           </select>
                        </div>
                        </div>
                       

                            

                        </div>



                    
                    
                    <button type="submit" class="btn btn-primary col-md-2 offset-md-4 btn-sm">Update</button>
                   <a class="btn btn-danger col-md-2 btn-sm" href='/tax-groups'>Cancel </a>
                </form>



            </div>
        </div>
    </div>
</div>

@stop
@section('js')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>   --}}
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> --}}
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

  <script >

    $(document).ready(function(){
 $('.framework').multiselect({
  nonSelectedText: 'Select',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'360px'
 });
 });
</script>


@stop

