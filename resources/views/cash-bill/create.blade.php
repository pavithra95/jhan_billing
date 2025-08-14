@extends('layout.master')

@section('title', 'ZetBooks')

@section('content_header')

@stop

@section('content')
<div class="row" id="invoice-app">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12">

                        <h4 class="m-0 text-dark col-md-6 float-left">{{$title}}</h4>

                    </div>
                </div>
                <br>


                <form ref="form" action="/{{$url}}" method="POST" role="form" class="col-md-12 " autocomplete="off">
                    {{ csrf_field() }}


                    
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer Name</label>

                               <input type="text" name="customer_name" class="form-control" required="">
                                
                              
                           </div>
                       </div> 
                       <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer Phone</label>

                               <input type="text" name="customer_phone" class="form-control" >
                                
                              
                           </div>
                       </div> 
                       <div class="col-md-4">
                            <div class="form-group @if($errors->has('customer_id')) text-danger @endif">
                                <label>Customer Address</label>

                              <textarea name="customer_address" id="" class="form-control" required=""></textarea>
                                
                              
                           </div>
                       </div>
                       <div class="col-md-4">

                        <div class="form-group @if($errors->has('invoice_no')) text-danger @endif">
                            <label for=""> Invoice No</label>
                            <input type="text" name="invoice_no" class="form-control" id="invoice_no" required="required" value="{{generateCashBillInvoiceNo()}}" disabled="">
                            @if($errors->has('invoice_no'))
                            <div class="error text-danger">{{ $errors->first('invoice_no') }}</div>
                            @endif

                        </div>
                    </div>


                    <div class="col-md-4">

                        <div class="form-group @if($errors->has('invoice_date')) text-danger @endif">
                            <label for=""> Invoice Date</label>
                            <input type="text" name="invoice_date" class="form-control date-picker " required="" value="{{date('Y-m-d')}}" >
                            @if($errors->has('invoice_date'))
                            <div class="error text-danger">{{ $errors->first('invoice_date') }}</div>
                            @endif

                        </div>
                    </div> 
                    <div class="col-md-4">

                        <div class="form-group @if($errors->has('invoice_date')) text-danger @endif">
                            <label for=""> Customer State</label>
                            <select name="state_id" id="inputState" class="form-control" required="required" disabled="">
                                @foreach ($states as $state)
                                    {{-- expr --}}
                                <option @if ($state->id == "27") selected=""
                                   
                                @endif value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class=row>
                   
                   
                    <div class="col-md-4">

                        <div class="form-group @if($errors->has('due_date')) text-danger @endif">
                            <label for="">Payment Method</label>
                            <select name="payment_method_id" id="inputPayment_method_id" class="form-control" required="required">
                                @foreach ($payment as $item)
                                {{-- expr --}}
                                <option @if ($item->name == "Cash" || $item->name == "cash" ) selected="" 

                                    @endif value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div> 
                        <div class="col-md-4">

                            <div class="form-group @if($errors->has('due_date')) text-danger @endif">
                                <label for="">Invoice Notes</label>
                                <textarea name="notes" id="" class="form-control"></textarea>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">




                                    <ul v-if="errors.length > 0">
                                        <div class="alert alert-danger" role="alert">

                                            <li v-for="(error, index) in errors">@{{error.name}}: @{{error.message}}</li>
                                        </div>

                                    </ul>


                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                               
                                                    <th>GST Tax</th>
                                                    <th>CESS Tax</th>
                                                
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in invoice_items">




                                                <td style="width: 300px;">
                                                   

                                                        <v-select  :options="items" label="name" v-model="item.item_id" @input="setItem(index, item)" :reduce="item => item.id" 
                                                            >
                                                            <template #search="{attributes, events}">
                                                                <input
                                                                class="vs__search"
                                                                :required="!item.item_id"
                                                                v-bind="attributes"
                                                                v-on="events"
                                                                />
                                                            </template>
                                                        </v-select>
                                                        <div v-if="isError && index == errorIndex">
                                                            <p class="text-danger">@{{message}}</p>
                                                        </div>

                                                   

                                                    

                                            </td>


                                            <td style="width: 150px;"><input  class="form-control amount" type="number" :min="1" v-model="item.quantity" @input="setRecalculatedamount(index)">
                                            </td>

                                            <td style="width: 160px;"><input class="form-control amount" placeholder="0" v-model="item.price" :min="1" @input="setRecalculatedamount(index)" id="test" onkeypress="return myfunction(event);" ></td>

                                           

                                                    <td>
                                                        <v-select  :options="taxes" label="g_name" v-model="item.group_type_name"   @input="setRecalculatedamount(index)">
                                                        </v-select>

                                                    </td>
                                                    <td>
                                                     <v-select  :options="cess_taxes" label="c_name" v-model="item.cess_group_type_name"  @input="setRecalculatedamount(index)"  >
                                                     </v-select>
                                                 </td>

                                            

                                     <td style="width: 200px;">

                                        <input class="form-control amount" type="text" v-model="item.total_amount" disabled="">

                                    </td>
                                    <td  style="color: red" v-if="index != 0" @click="removeRow(index)">X</td>
                                    <td v-else></td>
                                </tr>



                                <tr>
                                    <td><a v-if="!isError && invoice_items[invoice_items.length-1].price > 0 && errors.length == 0" href="" @click.prevent="addItem" class="btn btn-primary ">Add Row</a>

                                    </td>  
                                     


                                  
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>

                            </tbody>
                        </table>

                        <table class="table table-hover">
                            <tbody>


                                <tr>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amount">Sub total</td>
                                    <td class="amount">@{{taxSubTotalNew()}}</td>
                                    <input type="hidden" name="sub_total" :value="taxSubTotalNew()">
                                </tr>


                                <template v-for="item in taxes">

                                    <template v-for="tax in item.items">
                                        <tr v-if="getGstamountInclusive(tax.id, item.items.length) > 0">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="amount">@{{tax.name}}
                                             <input type="hidden" name="gst_id[]" :value="tax.id">
                                             <input type="hidden" name="gst_name[]" :value="tax.name">
                                             <input type="hidden" name="gst_percentage[]" :value="tax.percent">
                                             <input type="hidden" name="gst_amount[]" :value="getGstamountInclusive(tax.id, item.items.length)">
                                         </td>
                                         <td class="amount">@{{getGstamountInclusive(tax.id, item.items.length)}}</td>

                                     </tr>
                                 </template>
                             </template>



                             <template v-for="item in taxes_out">

                                <template v-for="tax in item.items">
                                    <tr v-if="getGstamountInclusive(tax.id, item.items.length) > 0">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="amount">@{{tax.name}}
                                         <input type="hidden" name="gst_id[]" :value="tax.id">
                                         <input type="hidden" name="gst_name[]" :value="tax.name">
                                         <input type="hidden" name="gst_percentage[]" :value="tax.percent">
                                         <input type="hidden" name="gst_amount[]" :value="getGstamountInclusive(tax.id, item.items.length)">
                                     </td>
                                     <td class="amount">@{{getGstamountInclusive(tax.id, item.items.length)}}</td>
                                 </tr>
                             </template>
                         </template>


                         <template v-for="item in cess_taxes">

                            <template v-for="tax in item.items">
                                <tr v-if="getCessAmountInclusive(tax.id, item.items.length) > 0">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amount">@{{tax.name}}
                                     <input type="hidden" name="cess_id[]" :value="tax.id">
                                     <input type="hidden" name="cess_name[]" :value="tax.name">
                                     <input type="hidden" name="cess_percentage[]" :value="tax.percent">
                                     <input type="hidden" name="cess_amount[]" :value="getCessAmountInclusive(tax.id, item.items.length)">
                                 </td>
                                 <td class="amount">@{{getCessAmountInclusive(tax.id, item.items.length)}}</td>
                             </tr>
                         </template>
                     </template>




                     <tr>


                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="amount">Round Off</td>
                        <td class="amount">@{{originalRoundOff}}</td>
                                    <input type="hidden" name="roundoff" :value="originalRoundOff">
                    </tr>
                    <tr>


                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="amount">Total</td>
                        <td class="amount">@{{totalRounded}}</td>
                                    <input type="hidden" name="final_amount" :value="totalRounded">
                    </tr>
                    <tr>


                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="amount">Paid Amount</td>
                        <td class="amount" style="width: 120px;"><input type="number" name="paid_amount" class="form-control" v-model="paid" ></td>
                 </tr> 
                 <tr>


                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="amount">Balance Amount</td>

                    <template v-if="paid == 0">
                        <td class="amount">0</td>
                    </template>

                    <template v-else>

                        <td class="amount">@{{getPaidAmount}}</td>
                    </template>



                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>


{{-- save code --}}

                                     <template v-for="item in invoice_items">
                                        <input type="hidden" name="item_id[]" :value="item.item_id">
                                        <input type="hidden" name="iitem[]" :value="JSON.stringify(item)">
                                        <input type="hidden" name="price[]" :value="item.price">
                                        <input type="hidden" name="price_without_tax[]" :value="item.price_without_tax">
                                        <template v-if="item.group_type_name != null">
                                            
                                        <input type="hidden" name="gst_group_id[]" :value="item.group_type_name.id">
                                        </template>
                                        <input type="hidden" name="total_gst_amount[]" :value="item.gst_amount">
                                        <template v-if="item.cess_group_type_name != null">
                                            
                                        <input v-if="item.cess_group_type_name != null" type="hidden" name="cess_group_id[]" :value="item.cess_group_type_name.id">
                                        </template>
                                        <input type="hidden" name="total_cess_amount[]" :value="item.cess_amount">
                                        <input type="hidden" name="quantity[]" :value="item.quantity">
                                         
                                        <input type="hidden" name="total_amount[]" :value="item.total_amount">
                                        
                                    </template>



<div class="col-md-6 offset-md-5">

 <button type="submit" class="btn btn-primary btn-sm" v-if="isError == false" >Submit</button>



 <a class="btn btn-danger btn-sm" href='/cash-bills'>Cancel </a>


</div>
</form>



</div>
</div>
</div>
</div>
<style>
    .amount {
        text-align: right;
    }
</style>


@endsection

@section("js")
<style>
    button.vs__clear {
        display: none;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>

<!-- use the latest vue-select release -->
<script src="https://unpkg.com/vue-select@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
<script>
function myfunction(e) {
  return e.charCode === 0 || ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 46 && document.getElementById("test").value.indexOf('.') < 0));
}
</script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
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
    $(document).ready(
        function() { 


          $('#datepicker').datepicker({
           startDate: new Date()
       })


      });



    var app = new Vue({
      el: '#invoice-app',
      data: {
        tds: [],
        originalRoundOff:0,

        total:0,
        totalRounded:0,
        cess:0,
        errors: [],
        gst:9,
        isError : false,
        error : [],
        errorIndex:null,
        errorQty:null,
        itemQuantityTotal: [],
        selectedCustomer: null,
        gsts: [],
        paid : 0,
        pay : 2, 
        message: 'Product Should be Unique',
        

        items: [
        @foreach ($items as $invoice_item)
        {
            id: "{{$invoice_item->id}}",
            name: "{{$invoice_item->name}}",
            price:null,
            pricep:"{{$invoice_item->ProductTax->group_type_name}}",
            pricep_id:"{{$invoice_item->ProductTax->id}}",

            pricec:"{{$invoice_item->CessProductTax->group_type_name}}",
            pricec_id:"{{$invoice_item->CessProductTax->id}}",
            tax_items: [
            @foreach ($invoice_item->taxGroup as $i)
            {   
                id: "{{$i->Tax->id}}",
                name: "{{$i->Tax->name}}",
                percent: "{{$i->tax_percentage}}",
            },
            @endforeach
            ],  
            cess_tax_items: [
            @foreach ($invoice_item->cesstaxGroup as $i)
            {   
                id: "{{$i->Tax->id}}",
                name: "{{$i->Tax->name}}",
                percent: "{{$i->tax_percentage}}",
            },
            @endforeach
            ], 
            

            

        },
        @endforeach
        ],

       
        taxes:[
        @foreach ($taxes as $gst)
        {
            id: "{{$gst->id}}",
            g_name: "{{$gst->group_type_name}}",
            items: [
            @foreach ($gst->taxGroup as $i)
            {
               id :"{{$i->Tax->id}}",
               name : "{{$i->Tax->name ?? ''}}",
               percent : "{{$i->tax_percentage}}",
           },
           @endforeach
           ]


       },
       @endforeach
       ],
      
    cess_taxes:[
    @foreach ($cess_taxes as $cess)
    {
        id: "{{$cess->id}}",
        c_name: "{{$cess->group_type_name}}",
        items: [
        @foreach ($cess->taxGroup as $i)
        {
           id :"{{$i->Tax->id}}",
           name : "{{$i->Tax->name ?? ''}}",
           percent : "{{$i->tax_percentage}}",
       },
       @endforeach
       ]


   },
   @endforeach
   ],
  
invoice_items: [
{
    item_id: 0,
    quantity: 1,
    price: null,
    cgst: 0,
    sgst: 0,
    igst: 0,
    gst_tax:0,
    cess_tax:0,
    price_without_tax:0,
    selectedItem: null,
    taxItems: [],
    group_type_name: {
        id: 0,
        g_name: "",
        items: [
        {
            id: 0,
            name: "",
            percent: 0,
        }
        ]
    }, 
    cess_group_type_name: {
        id: 0,
        c_name: "",
        items: [
        {
            id: 0,
            name: "",
            percent: 0,
        }
        ]
    },
    gst_amount: 0,
    cess_amt: 0,
    cess_tax:0,
    total_amount: 0,
    pricep : 0,
}
],
},

computed: {
    calculateQuantity: function () {
      return _(this.invoice_items)
      .groupBy('item_id')
      .map((objs, key) => ({

        'item_id': key,
            // 'quantity': _.sumBy(objs, 'quantity')
            'quantity': _.sumBy(objs, item => Number(item.quantity))
            

        }))
      .value();  
  },
  checkCustomerGst: function () {

    for (var i = this.customers.length - 1; i >= 0; i--) {
      if(this.customers[i].id == this.selectedCustomer) {
        return this.customers[i].state_id == 27;
    }
}

},



getPaidAmount:function(){
    var paid = this.paid;
    var amt = paid - (this.totalRounded) ;
    return parseFloat(amt).toFixed(2);
},




},
methods: {

    getRoundOffNew: function () {

        var normal_total = 0;

        for (var i = 0; i < this.invoice_items.length; i++) {
            normal_total = parseFloat(normal_total) + parseFloat(this.invoice_items[i].total_amount);
        }

        // var rounded_value = Math.round(this.total);
        this.totalRounded = normal_total;


        if(this.total != normal_total) {
            var roundoff = parseFloat(normal_total) - parseFloat(this.total);
        }
        else{
           var roundoff = 0; 
        }



        this.originalRoundOff = parseFloat(roundoff).toFixed(2);

       

    },

    getTotalAmountNew:function(){

        var tax = 0;
        var tot = 0;


        this.invoice_items.forEach(function(entry) {
            tax += parseFloat(entry.gst_amount);
            tax += parseFloat(entry.cess_amount);
            console.log("tax " + tax);
        });


        tot = parseFloat(this.taxSubTotalNew()) + parseFloat(tax);
        console.log("tax " + tax);
        this.total = parseFloat(tot).toFixed(2);
        this.getRoundOffNew();
    },



    taxSubTotalNew:function(){

        var sum = 0;

        this.invoice_items.forEach(function(entry) {
            sum += entry.price_without_tax * entry.quantity;
        });


        return parseFloat(sum).toFixed(2);
    },
    checkDuplicate: function (new_item_id,index) {


     var count = this.invoice_items.filter((obj) => obj.item_id === new_item_id.item_id).length;

     if (count >= 2) {
        this.isError = true;
        this.errorIndex = index;
    } else {
        this.isError = false;
        this.errorIndex = null;
    }

},



getCessAmountInclusive: function (id, length) {
    var self = this;
    var amount = 0;

    this.invoice_items.forEach(function(entry) {

        if(entry.cess_group_type_name != null) {

            entry.cess_group_type_name.items.forEach(function(tax) {
                if(tax.id == id && entry.item_id && entry.cess_amount > 0) {
                        // console.log("old gst amount " + entry.cess_amount);
                        amount += parseFloat(entry.cess_amount);
                    }
                });
        }
    });

    amount = amount / length;

        // console.log("total gst " + amount);

        return parseFloat(amount).toFixed(2);

    },   
    getGstamountInclusive: function (id, length) {
        var self = this;
        var amount = 0;
        this.invoice_items.forEach(function(entry) {

            if(entry.group_type_name != null) {

                entry.group_type_name.items.forEach(function(tax) {
                    if(tax.id == id && entry.item_id && entry.gst_amount > 0) {
                        // console.log("old gst amount " + entry.gst_amount);
                        amount += parseFloat(entry.gst_amount);
                    }
                });
            }
        });

        amount = amount / length;

        // console.log("total gst " + amount);

        return parseFloat(amount).toFixed(2);

    },  


    getGstAmountCustom: function (index) {
        console.log("selected item" + index);
        var item = this.invoice_items[index];
        console.log(item);
        var percentage = 0;
        item.group_type_name.items.forEach(function(entry) {
            percentage += parseFloat(entry.percent);
        });
        console.log("percent" + percentage);

        var newp = parseFloat(percentage);
        item.cess_group_type_name.items.forEach(function(entry) {
            newp += parseFloat(entry.percent);
        });



        var decimalp = (newp / 100) + 1;
        console.log("percentage" + decimalp);
        console.log("real percentage" + percentage);

        var price = this.invoice_items[index].price;

        var price_without_tax = price / decimalp;

        this.invoice_items[index].price_without_tax =  parseFloat(price_without_tax).toFixed(2);
        this.invoice_items[index].gst_amount =  (price_without_tax * (1+(percentage/ 100))) - price_without_tax;
        this.invoice_items[index].gst_amount = parseFloat(this.invoice_items[index].gst_amount).toFixed(2);

        this.invoice_items[index].gst_amount = this.invoice_items[index].gst_amount * this.invoice_items[index].quantity;

        console.log("original price " + price_without_tax);

    },

    getCessAmountCustom: function (index) {
        console.log("selected item" + index);
        var item = this.invoice_items[index];
        console.log(item);
        var percentage = 0;
        item.cess_group_type_name.items.forEach(function(entry) {
            percentage += parseFloat(entry.percent);
        });
        console.log("percent" + percentage);


        var newp = percentage;
        item.group_type_name.items.forEach(function(entry) {
            newp += parseFloat(entry.percent);
        });

        var decimalp = (newp / 100) + 1;
        console.log("percentage" + decimalp);

        var price = this.invoice_items[index].price;

        var price_without_tax = price / decimalp;

        this.invoice_items[index].cess_amount =  (price_without_tax * (1+(percentage/ 100))) - price_without_tax;
        this.invoice_items[index].cess_amount = parseFloat(this.invoice_items[index].cess_amount).toFixed(2);
 this.invoice_items[index].cess_amount = this.invoice_items[index].cess_amount * this.invoice_items[index].quantity;

        console.log("original price " + price_without_tax);

    },
    totalItemAmount: function (index) {
        // for (var i = 0; i < this.invoice_items.length; i++) {
            this.invoice_items[index].total_amount = this.invoice_items[index].price * this.invoice_items[index].quantity;

            this.invoice_items[index].total_amount = parseFloat(this.invoice_items[index].total_amount).toFixed(2);

        // }
    },

    setRecalculatedamount: function (index) {
        this.totalItemAmount(index);
        this.checkQuantity(index);

        this.getGstAmountCustom(index);
        this.getCessAmountCustom(index);

        this.getTotalAmountNew();

           
        },



       

   addItem: function () {
   
    this.invoice_items.push({
         item_id: 0,
    quantity: 1,
    price: null,
    cgst: 0,
    sgst: 0,
    igst: 0,
    gst_tax:0,
    cess_tax:0,
    price_without_tax:0,
    selectedItem: null,
    taxItems: [],
    
    gst_amount: 0,
    cess_amt: 0,
    cess_tax:0,
    total_amount: 0,
    pricep : 0,
    });
},

setItem: function (index, item_new) {
    // console.log(index);
    this.checkDuplicate(item_new,index);
    // this.checkQuantity(index);
    var select_item = this.items.find(x => x.id === item_new.item_id);
    console.log(select_item);
    console.log(select_item.tax_items);
    this.invoice_items[index].price = null;
    this.invoice_items[index].group_type_name = {
        id: select_item.pricep_id,
        g_name: select_item.pricep,
        items: select_item.tax_items,
    }; 
    this.invoice_items[index].cess_group_type_name = {
        id: select_item.pricec_id,
        c_name: select_item.pricec,
        items: select_item.cess_tax_items,
    }; 
    // this.invoice_items[index].cess_group_type_name = {
    //     id: select_item.pricec_id,
    //     c_name: select_item.pricec,
    //     items: select_item.cess_tax_items,
    // };
    // this.invoice_items[index].total_amount = this.calculateTotalamount(index);

},
setOutItem: function (index, item_new) {
    // console.log(index);
    this.checkDuplicate(item_new,index);
    // this.checkQuantity(index);
    var select_item = this.items_out.find(x => x.id === item_new.item_id);
    console.log(select_item);
    console.log(select_item.tax_items);
    this.invoice_items[index].price = null;
    this.invoice_items[index].group_type_name = {
        id: select_item.pricep_id,
        g_name: select_item.pricep,
        items: select_item.tax_items,
    }; 
    this.invoice_items[index].cess_group_type_name = {
        id: select_item.pricec_id,
        c_name: select_item.pricec,
        items: select_item.cess_tax_items,
    }; 
    // this.invoice_items[index].cess_group_type_name = {
    //     id: select_item.pricec_id,
    //     c_name: select_item.pricec,
    //     items: select_item.cess_tax_items,
    // };
    // this.invoice_items[index].total_amount = this.calculateTotalamount(index);
},

removeRow: function(index) {
    // console.log("Removing", index);
   
    this.invoice_items.splice(index, 1);
    if (index == this.errorIndex) {

        this.isError = false;
        this.errorIndex  = null;
    }
     for (var i = 0; i < this.invoice_items.length; i++) {
        
    this.setRecalculatedamount(i);
    }
     this.getTotalAmountNew();
},
refreshCustomer: function(){
   this.invoice_items= [
   {
    item_id: 0,
    quantity: 1,
    price: null,
    cgst: 0,
    sgst: 0,
    igst: 0,
    gst_tax:0,
    cess_tax:0,
    selectedItem: null,
     price_without_tax:0,
    taxItems: [],
    group_type_name: {
        id: 0,
        g_name: "",
        items: [
        {
            id: 0,
            name: "",
            percent: 0,
        }
        ]
    }, 
    cess_group_type_name: {
        id: 0,
        c_name: "",
        items: [
        {
            id: 0,
            name: "",
            percent: 0,
        }
        ]
    },
    gst_amount: 0,
    cess_amt: 0,
    cess_tax:0,
    total_amount: 0,
    pricep : 0,
}
]


},

checkQuantity:function(index){
    var self = this;
    // if (!self.$refs.form.checkValidity()) {
    //     // Try focus on the error 
    //     self.$refs.form.reportValidity()
    //     return
    // }
    // var token = document.head.querySelector('meta[name="csrf-token"]');
    // window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    console.log("quantity");
    console.log(this.calculateQuantity);

    axios.post('/check-quantity', {items: this.calculateQuantity} )
    .then(function (response) {
        self.errors = response.data;
        console.log(response);
        if(self.errors.length > 0) {
            this.quantityError = true;
            this.errorQty = index;
        }else{
           this.errorQty = true;   
       }

// }else {

//                  self.$refs.form.submit();
//     }
})
    .catch(function (error) {
        // console.log(error);
           // self.errors = response.data;
       });

},
}
})

</script>

@stop
