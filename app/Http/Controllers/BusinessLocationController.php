<?php

namespace App\Http\Controllers;

use App\BusinessLocation, 
    App\InvoiceLayout, 
    App\InvoiceScheme;
    
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class BusinessLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('business_settings.access') ) {
            abort(403, 'Unauthorized action.');
        } 

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $locations = BusinessLocation::where('business_locations.business_id', $business_id)
                ->leftjoin('invoice_schemes as ic', 
                    'business_locations.invoice_scheme_id', '=', 'ic.id')
                ->leftjoin('invoice_layouts as il', 
                    'business_locations.invoice_layout_id', '=', 'il.id')
                ->select(['business_locations.name', 'landmark', 'city', 'zip_code', 'state', 
                    'country', 'business_locations.id', 'ic.name as invoice_scheme', 'il.name as invoice_layout']);

            $permitted_locations = auth()->user()->permitted_locations();
            if($permitted_locations != 'all'){
                $locations->whereIn('business_locations.id', $permitted_locations);
            }

            return Datatables::of($locations)
                ->addColumn('action', 
                    '<button type="button" data-href="{{action(\'BusinessLocationController@edit\', [$id])}}" class="btn btn-xs btn-primary btn-modal" data-container=".location_edit_modal"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>

                    <a href="{{route(\'location.settings\', [$id])}}" class="btn btn-success btn-xs"><i class="fa fa-wrench"></i> @lang("messages.settings")</a>
                    '
                )
                ->removeColumn('id')
                ->escapeColumns(['action'])
                ->make(false);
        }

        return view ('business_location.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('business_settings.access') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $invoice_layouts = InvoiceLayout::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');

        $invoice_schemes = InvoiceScheme::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');
        return view ('business_location.create')
                    ->with(compact('invoice_layouts', 'invoice_schemes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('business_settings.access') ) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'landmark', 'city', 'state', 'country', 'zip_code', 'invoice_scheme_id', 
                'invoice_layout_id', 'mobile', 'alternate_number', 'email']);

            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] = $business_id;

            $location = BusinessLocation::create($input);

            //Create a new permission related to the created location
            Permission::create(['name' => 'location.' . $location->id ]);

            $output = array('success' => true, 
                            'msg' => __("business.business_location_added_success")
                        );

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => false, 
                            'msg' => __("messages.something_went_wrong")
                        );
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoreFront  $storeFront
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoreFront  $storeFront
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('business_settings.access') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $location = BusinessLocation::where('business_id', $business_id)
                                    ->find($id);
        $invoice_layouts = InvoiceLayout::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');
        $invoice_schemes = InvoiceScheme::where('business_id', $business_id)
                            ->get()
                            ->pluck('name', 'id');

        return view ('business_location.edit')
                ->with(compact('location', 'invoice_layouts', 'invoice_schemes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoreFront  $storeFront
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('business_settings.access') ) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'landmark', 'city', 'state', 'country', 'zip_code', 'invoice_scheme_id', 
                'invoice_layout_id', 'mobile', 'alternate_number', 'email']);
            
            $business_id = $request->session()->get('user.business_id');

            BusinessLocation::where('business_id', $business_id)
                            ->where('id', $id)
                            ->update($input);

            $output = array('success' => true, 
                            'msg' => __('business.business_location_updated_success')
                        );

        } catch(\Exception $e){
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => false, 
                            'msg' => __("messages.something_went_wrong")
                        );
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoreFront  $storeFront
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
