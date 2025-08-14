<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\GstStateMaster;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  
    private $add_text = 'Customer';
    private $redirectUrl ='customers';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $customer_id = request()->customer_id;
        $state_id = request()->state_id;
        $gst_no = request()->gst_no;
        $phone = request()->phone;
       
         $customers = Customer::where('id', '!=', 0);

       

        if (empty($customer_id)) {
            $customers->get();
        }
        if (empty($state_id)) {
            $customers->get();
        }
        if (empty($gst_no)) {
            $customers->get();
        }
        if (empty($phone)) {
            $customers->get();
        }
        
        if (!empty($customer_id)) {
            $customers->where('name',$customer_id);
        }
        if (!empty($phone)) {
            $customers->where('phone',$phone);
        }
         if (!empty($state_id)) {
            $customers->where('state_id',$state_id);
        }
        if (!empty($gst_no)) {
            $customers->where('gst_no',$gst_no);
        }


        $customers = $customers->paginate(10);
        $states = GstStateMaster::all();
        $url = $this->redirectUrl;
        $title="All Customers";
        $add_text="Add " . $this->add_text;
        return view('customers.index')->with(compact(['customers', 'url','title','add_text','gst_no','state_id','customer_id','states','phone']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url = $this->redirectUrl;
        $title = "Create " . $this->add_text;
        $state = GstStateMaster::all();
        $customerTypes = CustomerType::all();
        return view('customers.create')->with(compact(['url','title','state','customerTypes']));
    }   
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

    //      $request->validate([
    //     // 'phone' => ['required','unique:customers' ],
    //     'gst_no' => ['required','unique:customers' ],
            
           
    //    ]);

        $gstState = GstStateMaster::find($request->gst_state_id);
        // dd($gstState);
        $gst_state_code = $gstState ? $gstState->tin : null;

        $item = new Customer();
        $item->name = $request->name;
        $item->customer_type = $request->customer_type;
        $item->phone = $request->phone;
        $item->alt_phone = $request->alt_phone;
        $item->address = $request->address;
        $item->shipping_address = $request->shipping_address;
        $item->gst_no = $request->gstin;
        $item->state_id = $request->gst_state_id;
        $item->gst_state_code = $gst_state_code;
        $item->credit_limit = $request->credit_limit;
        $item->city = $request->city;
        $item->status = 'active';
        $item->save();

        return redirect('/customers/' . $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $customer = Customer::find($id);
        $url = $this->redirectUrl;
        $title = "Edit ". $this->add_text;
        $state = GstStateMaster::all();
        return view('customers.show')->with(compact(['customer', 'url','title','state']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        $url = $this->redirectUrl;
        $title = "Edit ". $this->add_text;
        $state = GstStateMaster::all();
        $customerTypes = CustomerType::all();
        return view('customers.edit')->with(compact(['customer', 'url','title','state','customerTypes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
        // 'phone' => ['required','unique:customers' ],
        // 'gst_no' => ['required','unique:customers' ],
            
           
       ]);
        $gstState = GstStateMaster::find($request->gst_state_id);
        $gst_state_code = $gstState ? $gstState->tin : null;

        $item = Customer::findOrFail($id);
        $item->name = $request->name;
        $item->customer_type = $request->customer_type;
        $item->phone = $request->phone;
        $item->alt_phone = $request->alt_phone;
        $item->address = $request->address;
        $item->shipping_address = $request->shipping_address;
        $item->gst_no = $request->gstin;
        $item->state_id = $request->gst_state_id;
        $item->gst_state_code = $gst_state_code;
        $item->credit_limit = $request->credit_limit;
        $item->city = $request->city;
        $item->save();

        return redirect('/customers/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CurrencyCode  $CurrencyCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DB::table('items')->where('id',$id)->delete();
        Customer::find($id)->delete();
       return redirect('/customers');
    }
    public function changeStatus(Request $request)
    {
        $user = Customer::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
       return redirect('/customers');
    }
}
