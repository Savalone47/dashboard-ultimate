<?php

namespace App\Http\Controllers;

use App\Contact,
    App\CustomerGroup,
    App\Transaction;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = request()->get('type');

        if (request()->ajax()) {

            if($type == 'supplier'){
                return $this->indexSupplier();
            } elseif ($type == 'customer') {
                return $this->indexCustomer();
            } else{
                die("Not Found");
            }
        }

        return view ('contact.index')
            ->with(compact('type'));
    }

    /**
     * Returns the database object for supplier
     *
     * @return \Illuminate\Http\Response
     */
    private function indexSupplier(){

        if (!auth()->user()->can('supplier.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $contact = Contact::leftjoin('transactions AS t', 'contacts.id', '=', 't.contact_id')
                    ->where('contacts.business_id', $business_id)
                    ->onlySuppliers()
                    ->select(['supplier_business_name', 'name', 'mobile', 
                        'contacts.type', 'contacts.id', 
                        DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
                        DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid")
                        ])
                    ->groupBy('contacts.id');

        return Datatables::of($contact)
            ->addColumn('due', 
                    '<span class="display_currency" data-currency_symbol=true data-highlight=false>{{$total_purchase - $purchase_paid }}</span>'
                )
            ->addColumn('action', 
                '<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                        data-toggle="dropdown" aria-expanded="false">' . 
                        __("messages.actions") . 
                        '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                @if(($total_purchase - $purchase_paid)  > 0)
                    <li><a href="{{action(\'TransactionPaymentController@getPayContactDue\', [$id])}}" class="pay_purchase_due"><i class="fa fa-money" aria-hidden="true"></i>@lang("contact.pay_due_amount")</a></li>
                @endif
                @can("supplier.view")
                    <li><a href="{{action(\'ContactController@show\', [$id])}}"><i class="fa fa-external-link" aria-hidden="true"></i> @lang("messages.view")</a></li>
                @endcan
                @can("supplier.update")
                    <li><a href="{{action(\'ContactController@edit\', [$id])}}" class="edit_contact_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                @endcan
                @can("supplier.delete")
                    <li><a href="{{action(\'ContactController@destroy\', [$id])}}" class="delete_contact_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                @endcan </ul></div>'
            )
            ->removeColumn('type')
            ->removeColumn('id')
            ->removeColumn('total_purchase')
            ->removeColumn('purchase_paid')
            ->escapeColumns(['action', 'due'])
            ->make(false);
    }

    /**
     * Returns the database object for customer
     *
     * @return \Illuminate\Http\Response
     */
    private function indexCustomer(){

        if (!auth()->user()->can('customer.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $contact = Contact::where('contacts.business_id', $business_id)
                    ->leftjoin('customer_groups AS cg', 'contacts.customer_group_id', '=', 'cg.id')
                    ->onlyCustomers()
                    ->addSelect(['contacts.name', 'cg.name as customer_group', 'city', 'state', 'country', 'landmark', 'mobile', 'type', 'contacts.id', 'is_default']);

        return Datatables::of($contact)
            ->editColumn('landmark',
                    '{{implode(array_filter([$landmark, $city, $state, $country]), ", ")}}'
                    )
            ->addColumn('action', 
                '<div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                        data-toggle="dropdown" aria-expanded="false">' . 
                        __("messages.actions") . 
                        '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                @can("customer.view")
                    <li><a href="{{action(\'ContactController@show\', [$id])}}"><i class="fa fa-external-link" aria-hidden="true"></i> @lang("messages.view")</a></li>
                @endcan
                @can("customer.update")
                    <li><a href="{{action(\'ContactController@edit\', [$id])}}" class="edit_contact_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                @endcan
                @if(!$is_default)
                @can("customer.delete")
                    <li><a href="{{action(\'ContactController@destroy\', [$id])}}" class="delete_contact_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                @endcan
                @endif </ul></div>'
            )
            ->removeColumn('state')
            ->removeColumn('country')
            ->removeColumn('city')
            ->removeColumn('type')
            ->removeColumn('id')
            ->removeColumn('is_default')
            ->escapeColumns(['action'])
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create') ) {
            abort(403, 'Unauthorized action.');
        }

        $types = array();
        if( auth()->user()->can('supplier.create') ){
            $types['supplier'] = __('report.supplier');
        }
        if( auth()->user()->can('customer.create') ){
            $types['customer'] = __('report.customer');
        }
        if (auth()->user()->can('supplier.create') && auth()->user()->can('customer.create')) {
            $types['both'] = __('lang_v1.both_supplier_customer');
        }

        $business_id = request()->session()->get('user.business_id');
        $customer_groups = CustomerGroup::forDropdown($business_id);

        return view ('contact.create')
            ->with(compact('types', 'customer_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create') ) {
            abort(403, 'Unauthorized action.');
        }

        if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {

            $input = $request->only(['type', 'supplier_business_name', 
                'name', 'tax_number', 'pay_term_number', 'pay_term_type', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'customer_group_id', 'contact_id']);
            $input['business_id'] = $request->session()->get('user.business_id');
            $input['created_by'] = $request->session()->get('user.id');

            //Check Contact id
            $count = 0;
            if(!empty($input['contact_id'])){
                $count = Contact::where('business_id', $input['business_id'])
                                ->where('contact_id', $input['contact_id'])
                                ->count();
            }
            if($count == 0){
                $contact = Contact::create($input);
                $output = array('success' => true, 
                            'data' => $contact, 
                            'msg' => __("contact.added_success")
                        );
            }  else {
                throw new \Exception("Error Processing Request", 1);
            }           
            

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('supplier.view') && !auth()->user()->can('customer.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $contact = Contact::where('contacts.id', $id)
                            ->join('transactions AS t', 'contacts.id', '=', 't.contact_id')
                            ->select( 
                            DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
                            
                            DB::raw("SUM(IF(t.type = 'sell', final_total, 0)) as total_invoice"),

                            DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),

                            DB::raw("SUM(IF(t.type = 'sell', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                            'contacts.*'
                        )->first();
        return view ('contact.show')
             ->with(compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('supplier.update') && !auth()->user()->can('customer.update') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $contact = Contact::where('business_id', $business_id)->find($id);

            $types = array();
            if( auth()->user()->can('supplier.create') ){
                $types['supplier'] = __('report.supplier');
            }
            if( auth()->user()->can('customer.create') ){
                $types['customer'] = __('report.customer');
            }
            if (auth()->user()->can('supplier.create') && auth()->user()->can('customer.create')) {
                $types['both'] = __('lang_v1.both_supplier_customer');
            }

            $customer_groups = CustomerGroup::forDropdown($business_id);

            return view ('contact.edit')
                ->with(compact('contact', 'types', 'customer_groups'));
        }
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

        if (!auth()->user()->can('supplier.update') && !auth()->user()->can('customer.update') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            try {

                $input = $request->only(['type', 'supplier_business_name', 'name', 'tax_number', 'pay_term_number', 'pay_term_type', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'customer_group_id', 'contact_id']);
                $business_id = $request->session()->get('user.business_id');

                $count = 0;

                //Check Contact id
                if(!empty($input['contact_id'])){
                    $count = Contact::where('business_id', $business_id)
                            ->where('contact_id', $input['contact_id'])
                            ->where('id', '!=', $id)
                            ->count();
                }
                
                if($count == 0){
                    $contact = Contact::where('business_id', $business_id)->findOrFail($id);
                    foreach ($input as $key => $value) {
                        $contact->$key = $value;
                    }
                    $contact->save();

                    $output = array('success' => true, 
                                'msg' => __("contact.updated_success")
                                );
                }   else {
                    throw new \Exception("Error Processing Request", 1);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('supplier.delete') && !auth()->user()->can('customer.delete') ) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            try {

                $business_id = request()->user()->business_id;

                //Check if any transaction related to this contact exists
                $count = Transaction::where('business_id', $business_id)
                                    ->where('contact_id', $id)
                                    ->count();
                if($count == 0){
                    $contact = Contact::where('business_id', $business_id)->findOrFail($id);
                    if(!$contact->is_default){
                        $contact->delete();
                    }
                    $output = array('success' => true, 
                                'msg' => __("contact.deleted_success")
                                );
                } else {
                    $output = array('success' => false, 
                                'msg' => __("lang_v1.you_cannot_delete_this_contact")
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

    /**
     * Retrieves list of customers, if filter is passed then filter it accordingly.
     *
     * @param  string  $q
     * @return JSON
     */
    public function getCustomers()
    {
        if (request()->ajax()) {

            $term = request()->input('q', '');

            $business_id = request()->session()->get('user.business_id');
            $suppliers = Contact::where( 'business_id', $business_id);

            if(!empty($term)){
                $suppliers->where(function ($query) use ($term) {
                        $query->where('name', 'like', '%' . $term .'%')
                            ->orWhere('supplier_business_name', 'like', '%' . $term .'%')
                            ->orWhere('mobile', 'like', '%' . $term .'%');
                    });
            }

            $suppliers = $suppliers->select('contacts.id', 'contacts.name as text', 
                            'mobile', 'landmark', 'city', 'state')
                                ->onlyCustomers()
                                ->get();
            return json_encode($suppliers);
        }
    }

    /**
     * Checks if the given contact id already exist for the current business.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkContactId(Request $request){
        $contact_id = $request->input('contact_id');

        $valid = 'true';
        if(!empty($contact_id)){
            $business_id = $request->session()->get('user.business_id');
            $hidden_id = $request->input('hidden_id');

            $query = Contact::where('business_id', $business_id)
                            ->where('contact_id', $contact_id);
            if(!empty($hidden_id)){
                $query->where('id', '!=', $hidden_id);
            }
            $count = $query->count();
            if($count > 0){
                $valid = 'false';
            }
        }
        echo $valid;exit;
    }
}
