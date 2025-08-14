@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">Record Payment</h1>

    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                 @if (empty(request()->vendor_id))
                  <form action="" method="GET" role="form">
                  
                    <div class="row">

                       


                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for="">Select Vendor</label>
                                
                               <select name="vendor_id" id="input" class="form-control select2" required="">
                                <option value=""></option>
                                   @foreach($vendors as $vendor)
                                   <option value="{{$vendor->id}}">{{$vendor->first_name}} {{$vendor->last_name}}</option>

                                   @endforeach 
                               </select>
                          
                               
                                

                            </div>
                        </div>
                      </div>
                       
                    
                  
                    <button type="submit" class="btn btn-primary btn-sm">Get Un Paid invoices</button>
                  </form>
                @else
                 <div id="payment">
                   <template v-if="items.length > 0">

                <form action="/new-purchase-payment" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}
                    

                    <div class="row">

                       
                              
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Vendor Name</label>
                                <input type="hidden" name="vendor_id" value="{{request()->vendor_id}}">
                               <h4>{{$vendor->first_name}} {{$vendor->last_name}}</h4>

                               
                                

                            </div>

                          
                        </div>
                        {{-- <label>utuy</label> --}}
                        <div> <br/>
                         {{-- <button type="submit" class="btn btn-primary" style="height: 40px" href="../">Change Customer</button> --}}
                         <a class="btn btn-primary btn-sm" href='/new-purchase-payment'>Change Vendor </a>
                       
                      </div>
                      </div>
                        
                       
                   
                       
                     
                   <div class="row">

                       


                     
                        <div class="col-md-4">
                            <div class="form-group" >
                              
                                <br/>

                              
                                <div> <input type="checkbox" name="checkbox" @click="togglePayinFull" value="red" > Pay Full amount


                                  <label> Rs.</label>
                                  <span>{{$total_amount - $paid_amount}}</span>
                                </div>
                              
                            
                               
                                

                            </div>
                       
                    </div>
                  </div>
                  
                            
                   
                        <div class="col-md-12">

                    <div class="form-group ">
                            <label for=""> Payment Date</label>
                            <input type="text" name="payment_date" class="form-control date-picker "  style="width: 320px" value="" required="">
                           
                        </div>
                    </div>
                    <div class="col-md-12">

                    <div class="form-group ">
                            <label for=""> Payment Mode</label>
                           <select  class="form-control"  id="payment_mode" name="payment_mode" style="width: 320px" required="">
                            <option value=""></option>
                               
                                <option value="cash"  >Cash</option>
                               <option value="bank_transfer"  >bank Transfer </option>
                           </select>
                           
                        </div>
                    </div>


                    <div class="col-md-12">

                    <div class="form-group ">
                        <label for=""> Deposit to</label>
                           <select  class="form-control"  id="deposit_to" name="deposit_to" style="width: 320px" required="">
                               <option value=""></option>
                            <option value="3">icici bank</option>
                            <option value="4">cash</option>
                        </select>
                           
                        </div>
                    </div>

                    <div class="col-md-12">

                     <div class="form-group ">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" style="width: 198px" required="required">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                
                            </div>


                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>S no</th>
                                  <th>Date</th>
                                  <th>Inv No</th>
                                  <th>Inv Amount</th>
                                  <th>Amount Due</th>
                                  <th>Amount</th>
                                </tr>
                              </thead>
                              <tbody>
                                 <tr v-for="(item, index) in items">
                                <input type="hidden" name="invoices[]" :value="item.id">
                                  <td>@{{index + 1}}</td>
                                  <td>@{{item.invoice_date}}</td>
                                  <td><input type="hidden" name="invoice_id[]">@{{item.invoice_no}}</td>
                                  <td>@{{item.total_amount}}</td>
                                  <td>@{{item.balance_amount}}</td>

                                  <td>
                                    <div  v-if="checkbox === true">
                                    <input type="text" name="paid_amount[]" v-model="item.amount" disabled="">
                                     <input type="hidden" name="paid_amount[]" v-model="item.amount" >
                                    </div>
                                    <div v-else>
                                     <input type="number" name="paid_amount[]" v-model="item.amount" :max="item.balance_amount" :min="0">
                                     </div> 
                                  </td>
                                 
                                </tr>
                                
                              </tbody>
                            </table>
                              <template v-if="itemsAmountTotal > 0">
                             <div class="col-md-6 offset-md-5">
                
               <button type="submit" class="btn btn-primary btn-sm">Save</button>
<a class="btn btn-danger btn-sm" href='/payment-sales-invoices'>Cancel </a>



               

           </div>
                        


                  
              </template>
              <template v-else>
              <h3 class="text-center text-danger">Please Enter Amount</h3>

                             <div class="col-md-6 offset-md-5">
                
               <button disabled="" type="submit" class="btn btn-primary btn-sm">Save</button>
                <a class="btn btn-danger btn-sm" href='/payment-sales-invoices'>Cancel </a>

                </div>
              </template>
                           
                             

                   
                    
                   
                </form>
               </template>
                <template v-else>
                 
                   <div class="row">

                       


                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Vendor Name</label>
                                <input type="hidden" name="vendor_id" value="{{request()->vendor_id}}">
                               <h4>{{$vendor->first_name}} {{$vendor->last_name}}</h4>

                               
                                

                            </div>

                          
                        </div>
                        {{-- <label>utuy</label> --}}
                        <div> <br/>
                         {{-- <button type="submit" class="btn btn-primary" style="height: 40px" href="../">Change Customer</button> --}}
                         <a class="btn btn-primary btn-sm" href='/new-purchase-payment'>Change Vendor </a>
                       
                      </div>
                        
                       
                      </div>
                       <h3>No Pending Invoices for Vendor</h3>

                </template>
              </div>
             

@endif


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
      full_amount : {{$total_amount- $paid_amount}},
      items: [ 
       @foreach ($sales as $key => $item)
        {
            
          id: "{{$item->id}}",
         invoice_date: "{{$item ->invoice_date}}",
          invoice_no: "{{$item ->invoice_no}}",
          total_amount: "{{$item ->total_amount}}",
          balance_amount: "{{($item->total_amount - $item->paid_amount)}}",
          amount: 0
        },
        @endforeach
        ],
      checkbox : false
    },
     computed:{
      itemsAmountTotal(){
        var total = 0;
        for (var i = 0; i < this.items.length; i++) {
          total += parseFloat(this.items[i].amount);
        }
        return total;
      }

    },
    methods: {
      togglePayinFull() {
        this.checkbox = !this.checkbox;
        console.log("toggled");
        for (var i = 0; i < this.items.length; i++) {
          console.log("inside loop");
          console.log(this.checkbox);
          if(this.checkbox) {
            console.log('checked');
            this.items[i].amount = this.items[i].balance_amount;  
          } else {
            console.log('not checked');
            this.items[i].amount = 0;
          }
          
        }
      }
    }

    
  })
</script>
@stop
