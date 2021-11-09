<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class GroupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return $this->sendResponse(GroupResource::collection($groups), 'Groups Retrieved Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:groups',
            'is_active' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input['slug'] = Str::slug($input['name']);
        $group = Group::create($input);
        return $this->sendResponse(GroupResource::make($group), 'Group created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        if (is_null($group)) {
            return $this->sendError('Group not found.');
        }
        return $this->sendResponse(GroupResource::make($group), 'Group retrieved successfully.');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Group $group)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:groups',
            'is_active' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $group->name = $input['name'];
        $group->is_active = $input['is_active'];
        $group->slug = Str::slug($input['name']);
        $group->save();
        return $this->sendResponse(GroupResource::make($group), 'Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        if (is_null($group)) {
            return $this->sendError('Group not found.');
        }
        $group->delete();
        return $this->sendResponse(GroupResource::make($group), 'Group deleted successfully.');
    }
}
