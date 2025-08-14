@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row" id="payment">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <div class="row">

    <div class="col-md-12">

        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>

    </div>
</div>
<br>


                <form action="/create-payment-from-invoice/{{ $sales->id }}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}
                    

                    <div class="row">

                       


                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Customer Name</label>
                                <input type="hidden" name="customer_id" value="{{$sales->customer_id}}">
                                <div>
                               <span class="hidden-xs">{{ $sales->customer->name }} </span>
                           </div>
                               
                                

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Inv Total amount</label>
                            <div>
                               <span class="hidden-xs">{{ $sales->total_amount}}</span>
                           </div>
                               
                                

                            </div>
                       
                    </div>

                    <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Inv Balance amount</label>
                            <div>
                               <span class="hidden-xs">{{ $sales->total_amount - $sales->paid_amount}}</span>
                           </div>
                               
                                

                            </div>
                       
                    </div>

                    <div class="row">

                       


                        <div class="col-md-4">
                            <div class="form-group" >
                                
                               <label for=""> Amount</label>
                               <div v-if="checkbox ===true" >
                                <input type="number" v-model="full_amount" disabled="">
                                     <input type="hidden" name="payment" v-model="full_amount" required="" >
                                </div>
                                <div v-else>


                         <input type="number" name="payment" v-model="amount" :min="1" required="required">
                               
                                

                            </div>
                           </div>
                               
                                

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                              
                                <br/>

                              
                                <div> <input type="checkbox" name="colorCheckbox" value="red" v-model="checkbox" > Pay Full amount
                                </div>
                              
                            
                               
                                

                            </div>
                       
                    </div>
                   
                   <div class="row">
                        <div class="col-md-4">

                    <div class="form-group ">
                            <label for=""> Payment Date</label>
                            <input type="text" name="payment_date" class="form-control date-picker "  value="{{date('Y-m-d')}}" required="">
                           
                        </div>
                    </div>
                    <div class="col-md-4">

                    <div class="form-group ">
                            <label for=""> Payment Mode</label>
                           <select  class="form-control"  id="payment_mode" name="payment_mode" style="width: 250px" required="" >
                              <option value=""></option>
                               
                                <option value="cash"  >Cash</option>
                               <option value="bank_transfer"  >bank Transfer </option>
                           </select>
                           
                        </div>
                    </div>


                   
                  </div>

                    <div class="col-md-12">

                     

                             <div class="col-md-6 offset-md-5">

               <button type="submit" class="btn btn-primary btn-sm">Save</button>


               <a class="btn btn-danger btn-sm" href='/sales-invoices/{{$sales->id}}'>Cancel </a>


           </div>
                        


                           
                             

                   
                    
                   
                </form>



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
    el : "#payment",
    data : {
      full_amount : {{$sales->total_amount - $sales->paid_amount}},
       checkbox : false,
       amount : 0
     }
  })
</script>

@stop
