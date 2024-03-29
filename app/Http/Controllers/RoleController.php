<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BusinessLocation;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $roles = Role::where('business_id', $business_id)
                        ->select(['name', 'id', 'is_default']);

            return DataTables::of($roles)
                ->addColumn('action', 
                    '@if(!$is_default)
                        <a href="{{action(\'RoleController@edit\', [$id])}}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a>
                        &nbsp;
                        <button data-href="{{action(\'RoleController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_role_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endif'
                )
                ->editColumn('name', function($row) use ($business_id) {
                    $role_name = str_replace('#'. $business_id , '', $row->name );
                    if(in_array($role_name, ['Admin', 'Cashier'])){
                       $role_name = __('lang_v1.' . $role_name); 
                    }
                    return $role_name;
                })
                ->removeColumn('id')
                ->removeColumn('is_default')
                ->escapeColumns(['action'])
                ->make(false);
        }

        return view ('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        //Get all locations
        $business_id = request()->session()->get('user.business_id');
        $locations = BusinessLocation::where('business_id', $business_id)
                                    ->get();

        return view ('role.create')
                ->with(compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $role_name = $request->input('name');
            $permissions = $request->input('permissions');
            $business_id = $request->session()->get('user.business_id');

            $count = Role::where('name', $role_name . '#' . $business_id)
                        ->where('business_id', $business_id)
                        ->count();
            if ($count == 0) {
                $role = Role::create([
                            'name' => $role_name . '#' . $business_id ,
                            'business_id' => $business_id
                        ]);

                //Include location permissions
                $location_permissions = $request->input('location_permissions');
                if(!in_array('access_all_locations', $permissions) && 
                    !empty($location_permissions)){
                    foreach ($location_permissions as $location_permission) {
                        $permissions[] = $location_permission;
                    }
                }
                if(!empty($permissions)){
                    $role->syncPermissions($permissions);
                }
                $output = array('success' => 1, 
                            'msg' => __("user.role_added")
                        );
            } else {
                $output = array('success' => 0, 
                            'msg' => __("user.role_already_exists")
                        );
            }
            

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __("messages.something_went_wrong")
                        );
        }
        return redirect('roles')->with('status', $output);
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
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $role = Role::where('business_id', $business_id)
                    ->with(['permissions'])
                    ->find($id);
        $role_permissions = array();
        foreach ($role->permissions as $role_perm) {
            $role_permissions[] = $role_perm->name;
        }

        $locations = BusinessLocation::where('business_id', $business_id)
                                    ->get();
        return view ('role.edit')
            ->with(compact('role', 'role_permissions', 'locations'));
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
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $role_name = $request->input('name');
            $permissions = $request->input('permissions');
            $business_id = $request->session()->get('user.business_id');

            $count = Role::where('name', $role_name . '#' . $business_id)
                        ->where('id', '!=', $id)
                        ->where('business_id', $business_id)
                        ->count();
            if ($count == 0) {

                $role = Role::findOrFail($id);

                if( !$role->is_default ){
                    $role->name = $role_name . '#' . $business_id;
                    $role->save();

                    //Include location permissions
                    $location_permissions = $request->input('location_permissions');
                    if(!in_array('access_all_locations', $permissions) && 
                        !empty($location_permissions)){
                        foreach ($location_permissions as $location_permission) {
                            $permissions[] = $location_permission;
                        }
                    }

                    if(!empty($permissions)){
                        $role->syncPermissions($permissions);
                    }

                    $output = array('success' => 1, 
                            'msg' => __("user.role_updated")
                        );
                } else {
                    $output = array('success' => 0, 
                            'msg' => __("user.role_is_default")
                        );
                }
                
            } else {
                $output = array('success' => 0, 
                            'msg' => __("user.role_already_exists")
                        );
            }
            

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => __("messages.something_went_wrong")
                        );
        }

        return redirect('roles')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('user.create') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            try {

                $business_id = request()->user()->business_id;

                $role = Role::where('business_id', $business_id)->find($id);

                if(!$role->is_default){
                    $role->delete();
                    $output = array('success' => true, 
                            'msg' => __("user.role_deleted")
                            );
                } else {
                    $output = array('success' => 0, 
                            'msg' => __("user.role_is_default")
                        );
                }
                

            } catch(\Exception $e){
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = array('success' => false, 
                            'msg' => __("messages.something_went_wrong")
                        );
            }

            return $output;
        }
    }
}
