<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use Session;
use Validator;
use Carbon\Carbon;
use Image;


class SupplierContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alldata = Supplier::where('branch_id', Session::get('branch_id'))
                    ->orderBy('name', 'asc')->paginate(30);
        return view('supplier.supplierList', compact('alldata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.addSupplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'company_name' => 'required',
                    'name' => 'required',
                    'phn_number' => 'required|numeric',
                    'present_address' => 'required',
                    'mail_address' => 'email|required',
                ]);

        if($validator->fails())
        {
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');;
        }
                
        $input = $request->all();

        if ($request->hasFile('profile_image')) {
            $photo=$request->file('profile_image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            /*$fileName=$photo->getClientOriginalName();*/
            $input['profile_image']=$fileName;
        }else{
            $input['profile_image']="";
        }

        $input['branch_id'] = Session::get('branch_id');

        try{

            $bug=0;
            $insert= Supplier::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            if($request->hasFile('profile_image'))
            {
                $upload=$photo->move('storage/app/public/uploads/suppliers', $fileName );
            }
            Session::flash('flash_message','Supplier Successfully Added.');
            return redirect('supplier/create')->with('status_color','success');

        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('supplier/create')->with('status_color','danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $singleData = Supplier::findOrFail($id);
        return view("supplier.addSupplier", compact("singleData"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileName=null;
        $data=Supplier::findOrFail($id);

        $validator = Validator::make($request->all(), [
                    'company_name' => 'required',
                    'name' => 'required',
                    'phn_number' => 'required|numeric',
                    'present_address' => 'required',
                    'mail_address' => 'email|required',
                ]);

        if($validator->fails())
        {
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');;
        }
                
        $input = $request->all();

        if ($request->hasFile('profile_image')) 
        {
            $photo=$request->file('profile_image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            /*$fileName=$photo->getClientOriginalName();*/
            $input['profile_image']=$fileName;

        }
        else
        {
            $input['profile_image']=$data['profile_image'];

        }       

       /* echo "<pre>";
        print_r($input);
        die;*/

        $img_path='storage/app/public/uploads/suppliers/'.$data['profile_image'];
        if($data['profile_image']!=null and $fileName!=null and file_exists($img_path)){
           unlink($img_path);
        }

        try
        {
            $bug=0;
            $data->update($input);
        }
        catch(\Exception $e)
        {
            $bug=$e->errorInfo[1];
        }

        if($bug==0)
        {
            if($request->hasFile('profile_image'))
            {
                $upload=$photo->move('storage/app/public/uploads/suppliers', $fileName );
            }
            Session::flash('flash_message','Supplier Successfully Updated.');
            return redirect('supplier')->with('status_color','warning');

        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('supplier')->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);

        $img_path='storage/app/public/uploads/suppliers/'.$data['profile_image'];
        if($data['profile_image']!=null and file_exists($img_path)){
           unlink($img_path);
        }

        $action = $data->delete();

        if($action)
        {
            Session::flash('flash_message','Supplier Profile Successfully Deleted.');
            return redirect('supplier')->with('status_color','danger');
        }
        else
        {
            Session::flash('flash_message','Something Error Found.');
            return redirect('supplier')->with('status_color','danger');
        }
    }


    public function supplierFilter(Request $request)
    {
        if (!empty(trim($request->search_supplier))) 
        {
            $data['alldata'] = Supplier::orderBy('name', 'asc')
                               ->where('name', 'like', '%'.$request->search_supplier.'%')
                               ->where('branch_id', Session::get('branch_id'))
                               ->paginate(10);    
            $data['search_supplier'] = $request->search_supplier;      
                               
            return view('supplier.supplierList', $data);   
        }
        else
        {
            return redirect('supplier');
        }
        
    }
}
