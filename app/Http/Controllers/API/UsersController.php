<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        return $this->sendResponsePaginate(UserResource::collection($users), 'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $password = bcrypt($request->password);
        $data = array_merge($request->except('password', 'confirm_password'), compact('password'));

        User::create($data);

        return $this->sendResponse('', 'Adding user successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFailToJson('Tag not found.');

        return $this->sendResponse(new UserResource($user), 'Get user successfully.');   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->firstOrFailToJson('User not found.');

        $password = bcrypt($request->password);
        $data = array_merge($request->except('password', 'confirm_password'), compact('password'));

        $user->update($data);

        return $this->sendResponse('', 'Update user successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->firstOrFailToJson('Tag not found.');

        $user->delete();

        return $this->sendResponse('', 'Delete user successfully.');
    }
}
