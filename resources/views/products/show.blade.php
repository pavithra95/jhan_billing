@extends('layout.master')


@section('content')
<div class="row" id="test">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>
         <a href="/products" class="btn btn-warning float-right ml-3 btn-sm">Back</a>
        <a href="/products/{{$product->id}}/edit" class="btn btn-success float-right ml-3 btn-sm">Edit</a>
          @if(auth()->user()->privilege == "admin")
        <a href="/products/{{$product->id}}/delete" class="btn btn-danger float-right ml-3 btn-sm">Delete</a>
        @endif

    </div>
</div>
<br>


              

                    <div class="row">

                        <div class="col-md-6">


                        
                            <div class="form-group @if($errors->has('item_name')) text-danger @endif">
                                <label for=""> Product Name</label>
                               <span>{{$product->name}}</span>

                            </div>

                             <div class="form-group @if($errors->has('type')) text-danger @endif">
                                <label for="">Product Category</label>
                                


                               <span>{{$product->Category->name ?? '-'}}</span>
                            </div>




                             <div class="form-group @if($errors->has('hsn_code')) text-danger @endif">
                                <label for="">HSN Code</label>
                                <span>{{$product->hsn_code}}</span>
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

                             <div class="form-group @if($errors->has('gst')) text-danger @endif">
                                <label for="">Within State</label>
                               <span>{{$product->ProductTax->group_type_name}}</span>
                               
                            </div> 
                            <div class="form-group @if($errors->has('gst')) text-danger @endif">
                                <label for="">Outside State</label>
                                <span>{{$product->IgstProductTax->group_type_name}}</span>
                            </div> 
                            <div class="form-group @if($errors->has('cess')) text-danger @endif">
                                <label for="">CESS</label>
                                <span>{{ $product->CessProductTax->group_type_name}}</span>

                       
                             <div class="form-group @if($errors->has('status')) text-danger @endif">
                                <label for="">Status</label>
                               <span>{{$product->status}}</span>
                            </div>
                            


                        </div>

                            

                        </div>



                    
                    
                  


            </div>
        </div>
    </div>
</div>

@stop

@section("js")
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

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
 <script >
              var app = new Vue({
                el:'#test',
                data:{
                 
                   editId: 0,
     
             isEditLoading: false,
                    isPageLoading: false,
                    isLoading: false,
                    selectedCategory: 0,
                    selectedTest: 0,
                    tests: [],
                    view_items: [],
                    items: [],
                    values: []

                },

                // created: function () {
                //     console.log('works');
                //     this.getReportItems();
                //   },
                  methods: {


                     getTest: function() {
        var self = this;
        self.isLoading = true;
        var url = "/getCategory/" + this.selectedCategory;
        axios.get(url)

        .then(function (response) {
          // handle success
            self.values = [];
          self.tests = response.data;
          if (self.tests.length == 0) {
            self.item_message = 'No Test Found';
          }
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .finally(function () {
          self.isLoading = false;
        });


     },


     

    

     
    }

    });




               
          
    
  </script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
      $(document).ready(function(){

      $(document).on('change','.category_id',function(){
        var hsn=$(this).val();
        console.log(hsn);

        var a=$(this).parent();
        //var a_id=$(this).closest('ul').attr('id');
        console.log(hsn);
        var op="";
        $.ajax({
          type:'get',
          url:'{!!URL::to('getTest')!!}',
          data:{'id':hsn},
          dataType:'json',
          success:function(data){
             console.log("hsn_code");
             //var c=data.hsn_code
             console.log(data.hsn_code);
            
             
             $('.hsn_code').val(data.hsn_code);
           

           

            
             //a.find('.mobile').val(data.mobile);

          
          },
          error:function(){

        }

        });
       
      });
    });


</script>
@stop


