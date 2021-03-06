<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view()
    {
        $user     = new User();
        $response = $user->paginate(1);

        return $response;
    }

    public function create(Request $request)
    {
        $response = array(
            'status'  => false,
            'message' => "Failed",
        );

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:user',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['error'] = $validator->errors();

            return $response;
        }

        $user            = new User();
        $user->username  = $request->username;
        $user->password  = app('hash')->make($request->password);
        $user->api_token = '-';
        $user->save();

        return $user;
    }

    public function delete(Request $request)
    {
        $user  = new User();
        $found = $user->where('id', $request->id)->first();

        if ($found) {
            $found->delete();
        }

        $response = array(
            'status'  => true,
            'message' => 'Success Delete',
        );

        return $response;
    }

    public function update(Request $request)
    {
        $user     = new User();
        $found    = $user->where('id', $request->id)->first();
        $response = array(
            'status'  => false,
            'message' => 'Failed Update',
        );

        if ($found) {
            $found->username  = $request->username;
            $found->password  = $request->password;
            $found->api_token = '-';
            $found->save();

            $response['status']  = true;
            $response['message'] = 'Success Update';
        }

        return $response;

    }

    //
}
