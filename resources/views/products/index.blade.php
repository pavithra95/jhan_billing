@extends('layout.master')




@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>

        <a class="btn btn-primary float-right btn-sm" href="/{{$url}}/create">NEW</a>
    </div>
</div>
<br>
 <div class="row">
       <form action="" method="GET"  role="form">

        
          
          <div class="row">


            
            
            <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Product Name</label>
                
                <input type="text" name="product" class=" form-control"  value="{{ $product }}" autocomplete="off" placeholder="Product Name">
              </div>
            </div>
            
           
             <div class="col-md-4">
              <div class="form-group">
                <label class="" for="">Category</label>
                 <select name="category_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($category as $c)
                           <option @if ($category_id == $c->id) selected=""
                              
                           @endif  value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
            </div>


  </div> 
  <div class="col-md-4">
              <!-- <div class="form-group">
                <label class="" for="">Unit</label>
                
                    <select name="unit_id" id="input" class="form-control select2">
                        <option value="">All</option>
                        @foreach ($units as $unit)
                           <option @if ($unit_id == $unit->id) selected=""
                              
                           @endif value="{{$unit->id}}">{{$unit->name}}</option>
                        @endforeach
                    </select>
            </div> -->


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
                          <th><input type="checkbox" id="select-all"></th>
                            <th>S.No</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Size</th>
                          
                            <th>Hsn Code</th>
                           
                            <th>Stock Quantity</th>
                          
                            <th>Status</th>
                            <th>Action</th>
                          
                        
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                        <tr>
                          <td>
   <input type="checkbox" class="product-checkbox" value="{{ $item->id }}">
</td>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="/{{$url}}/{{ $item->id }}/edit" >{{ $item->name }}</a></td>
                            <td>{{ $item->Category->name ??'' }}</td>
                            <td>{{ $item->Size->name ??'' }}</td>
                            <td>{{ $item->hsn_code }}</td>
                          
                            <td>{{ $item->quantity }}</td>
                           
                            
                            <td> <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}></td>
                             
                            <td>
                              <a href="/products/{{$item->id}}/edit"><i class= "fa fa-edit"></i></a>
                                @if(auth()->user()->privilege == "admin")
                              <a href="/products/{{$item->id}}/delete"><i class="fa fa-trash" ></i></a>
                            @endif

                            <a href="{{ url('/products/' . $item->id . '/labels') }}" 
   class="btn btn-sm btn-info" target="_blank">
    <i class="fas fa-barcode"></i> Print Label
</a>

                              
                            </td>
                           
                            {{-- <td>{{$item->stockQuantity()}}</td>
                            --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button id="print-selected" class="btn btn-success">
    <i class="fas fa-barcode"></i> Print Selected Labels
</button>

                 {{$items->links()}}




            </div>
        </div>
    </div>
</div>
@stop


@section('js')

   
<script >



   
    $(document).ready(
        function() { 


            $('.date-picker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

                //Initialize Select2 Elements
                $('.select2').select2({
                  theme: 'bootstrap4'
              })

            });
</script>

<script>
  $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/changeProductStatus',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
              console.log(data.success)
            }
        });
    })
  })

$(document).ready(function() {

    // Select All
    $('#select-all').on('click', function() {
        $('.product-checkbox').prop('checked', this.checked);
    });

    // Print Selected
    $('#print-selected').on('click', function() {
        let ids = [];
        $('.product-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if(ids.length === 0){
            alert("Please select at least one product.");
            return;
        }

        // open new window with selected IDs
        window.open('/products/labels/print?ids=' + ids.join(','), '_blank');
    });

});


</script>

@stop








