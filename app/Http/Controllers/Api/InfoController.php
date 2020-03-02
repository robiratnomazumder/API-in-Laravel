<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Address;

class InfoController extends BaseController
{
   
    public function index()
    {
        $data = User::with('address')->get();
        return $this->sendResponse($data->toArray(), 'Info retrieved successfully.');
        //return $data;
    }

    public function show($id)
    {
        $data = User::where('id', $id)->first();
        return $this->sendResponse($data->toArray(), $data->name.' retrieved successfully.');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address_id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $insert = new User();
        $insert->name = $request->name;
        $insert->address_id = $request->address_id;
        $insert->email = $request->email;
        $insert->password = Hash::make($request->password);
        $insert->created_at = now();
        $insert->updated_at = now();
        $insert->save();

        return $this->sendResponse($insert->toArray(), 'New info added successfully.');


    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $update = User::find($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->updated_at = now();
        $update->save();

        return $this->sendResponse($update->toArray(), 'New info updated successfully.');
    }

    public function destroy($id)
    {
        $value = User::where('id', $id)->delete();
        if(!empty($value)) return $this->sendResponse($id, 'Info deleted successfully.');
        else return $this->sendResponse($id, 'Id not found!');
    }
}
