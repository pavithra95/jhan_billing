<?php

namespace App\Http\Controllers;

use App\Models\Vendors;
use Illuminate\Http\Request;
use App\Models\GstStateMaster;

class VendorsController extends Controller
{
     private $add_text = 'Vendor';
    private $redirectUrl ='vendors';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $supplier_id = request()->supplier_id;
        $state_id = request()->state_id;
        $gst_no = request()->gst_no;
        $phone = request()->phone;
       
         $vendor = Vendors::where('id', '!=', 0);

       

        if (empty($supplier_id)) {
            $vendor->get();
        }
        if (empty($state_id)) {
            $vendor->get();
        } 
        if (empty($phone)) {
            $vendor->get();
        }
        if (empty($gst_no)) {
            $vendor->get();
        }
        
        if (!empty($supplier_id)) {
            $vendor->where('name',$supplier_id);
        }
         if (!empty($state_id)) {
            $vendor->where('state_id',$state_id);
        }
        if (!empty($gst_no)) {
            $vendor->where('gst_no',$gst_no);
        } 
        if (!empty($phone)) {
            $vendor->where('phone',$phone);
        }


        $vendor = $vendor->paginate(10);
        $states = GstStateMaster::all();
       
        $url = $this->redirectUrl;
        $title="All Vendors";
        $add_text="Add " . $this->add_text;
        return view('vendors.index')->with(compact(['vendor', 'url','title','add_text','supplier_id','gst_no','state_id','states','phone']));
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
        return view('vendors.create')->with(compact(['url','title','state']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //      $request->validate([
    //     // 'phone' => ['required','unique:customers' ],
    //     'gst_no' => ['required','unique:customers' ],
            
           
    //    ]);

        $gstState = GstStateMaster::find($request->gst_state_id);
        $gst_state_code = $gstState ? $gstState->tin : null;

        $vendor = new Vendors();
    $vendor->name = $request->name;
    $vendor->supplier_type = $request->supplier_type;
    $vendor->company_name = $request->company_name;
    $vendor->phone = $request->phone;
    $vendor->alt_phone = $request->alt_phone;
    $vendor->address = $request->address;
    $vendor->city = $request->city;
    $vendor->gst_no = $request->gst_no;
    $vendor->state_id = $request->gst_state_id;
    $vendor->gst_state_code = $gst_state_code;
    $vendor->status = 'active';

    $vendor->save();


        return redirect('/vendors/' . $vendor->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendors::find($id);
        $url = $this->redirectUrl;
        $title = "Edit ". $this->add_text;
        $state = GstStateMaster::all();
        return view('vendors.show')->with(compact(['vendor', 'url','title','state']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Itemn  $Itemn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor = Vendors::find($id);
        $url = $this->redirectUrl;
        $title = "Edit ". $this->add_text;
        $state = GstStateMaster::all();
        return view('vendors.edit')->with(compact(['vendor', 'url','title','state']));
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

        $vendor = Vendors::find($id);
    $vendor->name = $request->name;
    $vendor->supplier_type = $request->supplier_type;
    $vendor->company_name = $request->company_name;
    $vendor->phone = $request->phone;
    $vendor->alt_phone = $request->alt_phone;
    $vendor->address = $request->address;
    $vendor->city = $request->city;
    $vendor->gst_no = $request->gst_no;
    $vendor->state_id = $request->gst_state_id;
    $vendor->gst_state_code = $gst_state_code;
    $vendor->status = 'active';

    $vendor->save();


        return redirect($this->redirectUrl);
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
        Vendors::find($id)->delete();
       return redirect('/vendors');
    }
     public function changeStatus(Request $request)
    {
        $user = Vendors::find($request->user_id);
        $user->status = $request->status;
        $user->save();
  
       return redirect('/vendors');
    }
}
