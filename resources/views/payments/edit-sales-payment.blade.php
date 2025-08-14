@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')
<div class="row">

    <div class="col-md-12">

        <h1 class="m-0 text-dark col-md-6 float-left">Edit Sales Payment</h1>
       

    </div>
</div>
@stop

@section('content')
<div class="row" >
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                 
                 

               <div id="payment">

                    <form action="/edit-sales-payment/{{ $payment->id }}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    

                    <div class="row">

                       


                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for=""> Customer Name</label>
                                <select name="customer_id" id="input" class="form-control" required="">
                                   @foreach($customers as $customer)
                                   <option @if($payment->customer_id == $customer->id) selected="" @endif  value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>

                                   @endforeach 
                               </select>

                               
                                

                            </div>

                          
                        </div>
                        {{-- <label>utuy</label> --}}
                       
                        
                       
                      </div>

                       
                     <div class="row">

                       


                       
                     
                        <div class="col-md-4">
                            <div class="form-group" >
                              
                                <br/>

                              
                                <div> <input type="checkbox" name="checkbox" @click="togglePayinFull" value="red" > Pay Full amount
                                
                                 <label> Rs.</label>
                                  <span>{{$total_amount - $paid_amount + $payment_item->amount }}</span>
                                  </div>
                              
                            
                               
                                

                            </div>
                       
                    </div>
                  </div>
                  
                            
                   
                        <div class="row">
                          <div class="col-md-4">

                    <div class="form-group ">
                            <label for=""> Payment Date</label>
                            <input type="text" name="payment_date" class="form-control date-picker "  required="" value="{{ $payment->payment_date }}"  >
                           
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-4">

                    <div class="form-group ">
                            <label for=""> Payment Mode</label>
                           <select  class="form-control"  id="payment_mode" name="payment_mode" required="" >
                               
                                <option  @if($payment->payment_mode == 'cash') selected="" @endif value="cash"  >Cash</option>
                               <option  @if($payment->payment_mode == 'bank_transfer') selected="" @endif value="bank_transfer"  >bank Transfer </option>
                           </select>
                           
                        </div>
                    </div>
                  </div>
                      <div class="row">

                    <div class="col-md-4">

                    <div class="form-group ">
                        <label for=""> Deposit to</label>
                           <select  class="form-control"  id="deposit_to" name="deposit_to" required="" >
                               
                            <option @if($payment->deposit_to == '3') selected="" @endif value="3">icici bank</option>
                            <option @if($payment->deposit_to == '4') selected="" @endif value="4">cash</option>
                        </select>
                           
                        </div>
                    </div>
                  </div>

                    <div class="row">
                    <div class="col-md-4">

                     <div class="form-group ">
                                <label for="">Status</label>
                                <select name="status" id="input" class="form-control" style="width: 198px" required="required">
                                    <option @if($payment->status == 'active') selected="" @endif value="active">Active</option>
                                    <option @if($payment->status == 'inactive') selected="" @endif value="inactive">Inactive</option>
                                </select>
                                
                            </div>
                          </div>
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
                      
                    <input type="hidden" name="invoices[]" :value="item.invoice_id">
                    
                       <td>@{{index + 1}}</td>
                      <td>@{{item.invoice_date}}</td>
                     <td><input type="hidden" name="invoice_id[]">@{{item.invoice_no}}</td>
                      <td>@{{item.total_amount}}</td>
                      <td>@{{item.balance_amount}}</td>

                       <td>
                        <div  v-if="checkbox === true">
                            <input type="text" name="" v-model="item.payment" disabled="">
                             <input type="hidden" name="paid_amount[]" v-model="item.payment" >
                        </div>
                        <div v-else>
                            <input type="number" name="paid_amount[]" v-model="item.amount" :max="item.total_amount" :min="0">
                        </div>  </td>
                      {{-- <td>{{$item->amount}}</td> --}}
                    </tr>
                   

                               
                              </tbody>
                            </table>
                             <div class="col-md-6 offset-md-5">

               <button type="submit" class="btn btn-primary btn-sm">Update</button>


               <a class="btn btn-danger btn-sm" href='/payment-sales-invoices/{{$payment->id}}'>Cancel </a>


           </div>
                        


                           
                             

                   
                    
                   
                </form>
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
    el : "#payment",
    data : {
      full_amount : {{$total_amount - $paid_amount}},
      items: [ 
       @foreach ($payment->paymentItems as $key => $item)
        {
            
          id: "{{$item->id}}",
          invoice_date: "{{$item->salesInvoice->invoice_date}}",
          invoice_id: "{{$item->invoice_id}}",
          invoice_no: "{{$item->salesInvoice->invoice_no}}",
          total_amount: "{{$item->salesInvoice->total_amount}}",
          balance_amount: "{{($item->salesInvoice->total_amount - $item->salesInvoice->paid_amount)}}",
          payin_full_balance: "{{($item->salesInvoice->total_amount - $item->salesInvoice->paid_amount) + $item ->amount}}",
          payment: 0,
          amount :{{$item ->amount}}
         
        },

        @endforeach
        ],
      checkbox : false
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
            this.items[i].payment = this.items[i].payin_full_balance;  
          } else {
            console.log('not checked');
            this.items[i].payment = this.items[i].amount; 
          }
          
        }
      }
    }

    
  })
</script>
@stop
