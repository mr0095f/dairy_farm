<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Calf;
use App\Models\Color;
use App\Models\AnimalType;
use App\Models\Shed;
use App\Models\Vaccines;
use App\Models\Animal;
use Validator;
use Session;

class CalfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['all_animals'] = Calf::leftJoin('users', 'users.id','calf.user_id')
								->leftJoin('users_type', 'users_type.id','users.user_type')
								->where('calf.branch_id', Session::get('branch_id'))
								->select('calf.*','users.name','users_type.user_type')
								->paginate(50);
        return view('calf.calfList', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_colors'] = Color::all();
        $data['all_animal_type'] = AnimalType::all();
        $data['all_vaccines'] = Vaccines::all();
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['mother_animals'] = Animal::where('branch_id', Session::get('branch_id'))->get();
        return view('calf.calfForm', $data);
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
                    'age' => 'required',
                    'weight' => 'required',
                    'height' => 'required',
                    'gender' => 'required',
                    'color' => 'required',
                    'animal_type' => 'required',
                    'shade_no' => 'required',
                    'previous_vaccine_done' => 'required',
                ]);

        if($validator->fails()){
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input = $request->all();
        $input['buy_date'] = null;
        if(!empty($input['buy_date'])){
          $input['buy_date'] = date('Y-m-d', strtotime($input['buy_date']));
        }
		
		if(!empty($input['DOB'])){
          $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));
        }

        
        $input['branch_id'] = Session::get('branch_id');
        $input['vaccines'] = isset($input['vaccines'])?json_encode($input['vaccines']):'';

        if($request->hasfile('animal_image')) {
            $all_images = "";
            foreach($request->file('animal_image') as $image){
                $name=$image->getClientOriginalExtension();
                $fileName=rand(1,1000).date('dmyhis').".".$name;
                $all_images .=$fileName."_";  
            }
            $input['pictures'] = chop($all_images, '_');
        }

        try {
            $bug = 0;
            
            $insert = Calf::create($input);
			
			//booked selected stall
			Shed::where('id', $request->shade_no)->update(['status' => 1]);

            if($request->hasfile('animal_image')){
                $index = 0;
                $imageArr = explode('_', $insert->pictures);
                foreach($request->file('animal_image') as $image){
                    $image->move('storage/app/public/uploads/animal/', $imageArr[$index]);
                    $index++;
                }
            }
        }
        catch (\Exception $e) {
            $bug=$e->errorInfo[1];
            echo $bug; die;
        }

        if($bug==0){
            Session::flash('flash_message','Calf Successfully Saved !');
            return redirect('calf')->with('status_color','success');

        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('calf/create')->with('status_color','danger');

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
        $data['all_colors'] = Color::all();
        $data['all_animal_type'] = AnimalType::all();
        $data['all_sheds'] = Shed::all();
        $data['all_vaccines'] = Vaccines::all();
        $data['single_data'] = Calf::findOrFail($id);
        $data['mother_animals'] = Animal::where('branch_id', Session::get('branch_id'))->get();
        return view('calf.calfForm', $data);
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
        $data = Calf::findOrFail($id);

        $validator = Validator::make($request->all(), [
                    'age' => 'required',
                    'weight' => 'required',
                    'height' => 'required',
                    'gender' => 'required',
                    'color' => 'required',
                    'animal_type' => 'required',
                    'shade_no' => 'required',
                    'previous_vaccine_done' => 'required',
                ]);

        if($validator->fails()){
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input = $request->all();
        $input['buy_date'] = null;
        if(!empty($request->buy_date)){
          $input['buy_date'] = date('Y-m-d', strtotime($request->buy_date));
        }
		
		if(!empty($input['DOB'])){
          $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));
        }

        $input['vaccines'] = isset($input['vaccines'])?json_encode($input['vaccines']):'';

        $newImages = [];
        if($request->hasfile('animal_image')){
            $all_images = "";
            foreach($request->file('animal_image') as $image){
                $name=$image->getClientOriginalExtension();
                $fileName=rand(1,1000).date('dmyhis').".".$name;
                $newImages[] = $fileName;
                $all_images .=$fileName."_";  
            }
            $input['pictures'] = chop($all_images, '_');
        }else{
            $input['pictures']="";
        }

        $needDeleteImages = [];
        if($data->pictures){
            if(isset($input['exitesPreviousImage'])){
                $needDeleteImages = array_diff(explode('_', $data->pictures),$input['exitesPreviousImage']);
                $input['pictures']= implode('_', $input['exitesPreviousImage'])."_".$input['pictures'];
                $input['pictures'] = chop($input['pictures'], '_');
            }else{
                $needDeleteImages = explode('_', $data->pictures);
            }
        }

        try {
            $bug = 0;
            
			if($request->shade_no != $data->shade_no){
				Shed::where('id', $data->shade_no)->update(['status' => 0]); //make previouse stall fee
				Shed::where('id', $request->shade_no)->update(['status' => 1]); //booked
			}
			
			$data->update($input);

            if($request->hasfile('animal_image')){
                $index = 0;
                foreach($request->file('animal_image') as $image){
                    $image->move('storage/app/public/uploads/animal/', $newImages[$index]);
                    $index++;
                }
            }

            if(count($needDeleteImages)>0){
                foreach ($needDeleteImages as $deleteImage) {
                $img_path='storage/app/public/uploads/animal/'.$deleteImage;
                    if(file_exists($img_path)){
                    unlink($img_path);
                    } 
                }
            }
        }
        catch (\Exception $e) {
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Calf Successfully Updated !');
            return redirect('calf')->with('status_color','success');

        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('calf')->with('status_color','danger');

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
        $data = Calf::findOrFail($id);
        try {
          $bug = 0;
          if(!empty($data->shade_no)){
		  	Shed::where('id', $data->shade_no)->update(['status' => 0]); //make stall fee
		  }
		  $data->delete();
        }
        catch (\Exception $e) {
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message_delete','Calf Successfully Deleted !');
            return redirect('calf')->with('status_color','success');

        }else{
            Session::flash('flash_message_delete','Something Error Found !');
            return redirect('calf')->with('status_color','danger');

        }
    }
}
