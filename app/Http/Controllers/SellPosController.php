<?php

namespace App\Http\Controllers;

use App\TaxRate,
    App\Transaction,
    App\TransactionSellLine,
    App\BusinessLocation,
    App\Business,
    App\User,
    App\Category,
    App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Utils\ContactUtil,
    App\Utils\ProductUtil,
    App\Utils\BusinessUtil,
    App\Utils\TransactionUtil,
    App\Utils\CashRegisterUtil,
    App\Utils\ModuleUtil;

use Yajra\DataTables\Facades\DataTables;

class SellPosController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $contactUtil;
    protected $productUtil;
    protected $businessUtil;
    protected $transactionUtil;
    protected $cashRegisterUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ContactUtil $contactUtil,
        ProductUtil $productUtil, BusinessUtil $businessUtil, TransactionUtil $transactionUtil, CashRegisterUtil $cashRegisterUtil, ModuleUtil $moduleUtil)
    {
        $this->contactUtil = $contactUtil;
        $this->productUtil = $productUtil;
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;
        $this->moduleUtil = $moduleUtil;

        $this->dummyPaymentLine = ['method' => 'cash', 'amount' => 0, 'note' => '', 'card_transaction_number' => '', 'card_number' => '', 'card_type' => '', 'card_holder_name' => '', 'card_month' => '', 'card_year' => '', 'card_security' => '', 'cheque_number' => '', 'bank_account_number' => '', 
        'is_return' => 0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('sell.view') && !auth()->user()->can('sell.create') ) {
            abort(403, 'Unauthorized action.');
        }
        
        return view ('sale_pos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        //Check if there is a open register, if no then redirect to Create Register screen.
        if($this->cashRegisterUtil->countOpenedRegister() == 0){
            return redirect()->action('CashRegisterController@create');
        }

        $business_id = request()->session()->get('user.business_id');
        $walk_in_customer = $this->contactUtil->getWalkInCustomer($business_id);
        
        $business_details = $this->businessUtil->getDetails($business_id);
        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);
        $payment_types = $this->productUtil->payment_types();

        $payment_lines[] = $this->dummyPaymentLine;

        $business_locations = BusinessLocation::forDropdown($business_id, false, true);
        $bl_attributes = $business_locations['attributes'];
        $business_locations = $business_locations['locations'];

        $default_location = null;
        if(count($business_locations) == 1){
            foreach ($business_locations as $id => $name) {
                $default_location = $id;
            }
        }

        //Shortcuts
        $shortcuts = json_decode($business_details->keyboard_shortcuts, true);
        $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);
        
        $commsn_agnt_setting = $business_details->sales_cmsn_agnt;
        $commission_agent = array();
        if($commsn_agnt_setting == 'user'){
            $commission_agent = User::forDropdown($business_id, false);
        } elseif($commsn_agnt_setting == 'cmsn_agnt'){
            $commission_agent = User::saleCommissionAgentsDropdown($business_id, false);
        }

        $categories = Category::catAndSubCategories($business_id);
        $change_return = $this->dummyPaymentLine;

        return view ('sale_pos.create')
            ->with(compact('business_details', 'taxes', 'payment_types', 'walk_in_customer', 'payment_lines', 'business_locations', 'bl_attributes', 'default_location', 'shortcuts', 'commission_agent', 'categories', 
                'pos_settings', 'change_return'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('sell.create') && !auth()->user()->can('direct_sell.access')) {
            abort(403, 'Unauthorized action.');
        }

        $is_direct_sale = false;
        if(!empty($request->input('is_direct_sale'))){
          $is_direct_sale = true;
        }

        //Check if there is a open register, if no then redirect to Create Register screen.
        if(!$is_direct_sale && $this->cashRegisterUtil->countOpenedRegister() == 0){
            return redirect()->action('CashRegisterController@create');
        }

        try {

            $input = $request->except('_token');

            //status is send as quotation from Add sales screen.
            if($input['status'] == 'quotation'){
                $input['status'] = 'draft';
                $input['is_quotation'] = 1;
            }

            if(!empty($input['products'])){
                $business_id = $request->session()->get('user.business_id');
                $user_id = $request->session()->get('user.id');
                $commsn_agnt_setting = $request->session()->get('business.sales_cmsn_agnt');

                $discount = ['discount_type' => $input['discount_type'],
                                'discount_amount' => $input['discount_amount']
                            ];
                $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], $input['tax_rate_id'], $discount);

                DB::beginTransaction();

                if(empty($request->input('transaction_date'))){
                    $input['transaction_date'] =  \Carbon::now();
                } else {
                    $input['transaction_date'] = $this->productUtil->uf_date($request->input('transaction_date'));
                }
                if($is_direct_sale){
                    $input['is_direct_sale'] = 1;
                }

                $input['commission_agent'] = !empty($request->input('commission_agent')) ? $request->input('commission_agent') : null;
                if($commsn_agnt_setting == 'logged_in_user'){
                    $input['commission_agent'] = $user_id;
                }

                //Customer group details
                $contact_id = $request->get('contact_id', null);
                $cg = $this->contactUtil->getCustomerGroup($business_id, $contact_id);
                $input['customer_group_id'] = (empty($cg) || empty($cg->id)) ? null : $cg->id;

                $transaction = $this->transactionUtil->createSellTransaction($business_id, $input, $invoice_total, $user_id);

                $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id']);

                if(!$is_direct_sale){
                    //Add change return
                    $change_return = $this->dummyPaymentLine;
                    $change_return['amount'] = $input['change_return'];
                    $change_return['is_return'] = 1;
                    $input['payment'][] = $change_return;

                    $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment']);
                }

                //Send data to store in modules.
                $param = ['Restaurant' => ['business_id' => $business_id, 
                            'transaction_id' => $transaction->id]];
                $this->moduleUtil->storeModulesData('sellPosStore', $param);

                //Check for final and do some processing.
                if ($input['status'] == 'final') {

                    //update product stock
                    foreach ($input['products'] as $product) {
                        if($product['enable_stock']){
                            $this->productUtil->decreaseProductQuantity(
                                $product['product_id'],
                                $product['variation_id'],
                                $input['location_id'],
                                $this->productUtil->num_uf($product['quantity'])
                            );
                        }
                    }

                    //Add payments to Cash Register
                    if(!$is_direct_sale){
                        $this->cashRegisterUtil->addSellPayments($transaction, $input['payment']);
                    }

                    //Update payment status
                    $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);

                    //Allocate the quantity from purchase and add mapping of 
                    //purchase & sell lines in 
                    //transaction_sell_lines_purchase_lines table
                    $business = ['id' => $business_id, 
                                    'accounting_method' => $request->session()->get('business.accounting_method'),
                                    'location_id' => $input['location_id']
                                ];
                    $this->transactionUtil->mapPurchaseSell($business, $transaction->sell_lines, 'purchase');
                }

                DB::commit();
                
                $msg = '';
                $receipt = '';
                if($input['status'] == 'draft' && $input['is_quotation'] == 0){
                    $msg = trans("sale.draft_added");
                } elseif($input['status'] == 'draft' && $input['is_quotation'] == 1){
                    $msg = trans("lang_v1.quotation_added");
                    if(!$is_direct_sale){
                        $receipt = $this->receiptContent($business_id, $input['location_id'], $transaction->id);
                    } else {
                        $receipt = '';
                    }
                } elseif($input['status'] == 'final'){
                    $msg = trans("sale.pos_sale_added");
                    if(!$is_direct_sale){
                        $receipt = $this->receiptContent($business_id, $input['location_id'], $transaction->id);
                    } else {
                        $receipt = '';
                    }
                }

                $output = array('success' => 1, 'msg' => $msg, 'receipt' => $receipt );
            } else {
                $output = array('success' => 0, 
                            'msg' => trans("messages.something_went_wrong")
                        );
            }

        } catch(\Exception $e){
            DB::rollBack();

            if(get_class($e) == 'App\Exceptions\PurchaseSellMismatch'){
                $msg = $e->getMessage();
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                $msg = trans("messages.something_went_wrong");
            }

            $output = array('success' => 0, 
                            'msg' => $msg
                        );
        }

        if(!$is_direct_sale){
            return $output;
        } else {
            if($input['status'] == 'draft'){
                if(isset($input['is_quotation']) && $input['is_quotation'] == 1){
                    return redirect()
                        ->action('SellController@getQuotations')
                        ->with('status', $output);
                } else {
                    return redirect()
                        ->action('SellController@getDrafts')
                        ->with('status', $output);
                }
            } else {
                return redirect('sells')->with('status', $output);
            }
        }
    }

    /**
     * Returns the content for the receipt
     *
     * @param  int  $business_id
     * @param  int  $location_id
     * @param  int  $transaction_id
     * @param string $printer_type = null
     *
     * @return array
     */
    private function receiptContent($business_id, $location_id, 
        $transaction_id, $printer_type = null)
    {
        $output = ['is_enabled' => false, 
                    'print_type' => 'browser', 
                    'html_content' => null,
                    'printer_config' => [],
                    'data' => []
                ];

        $business_details = $this->businessUtil->getDetails($business_id);
        $location_details = BusinessLocation::find($location_id);

        //Check if printing of invoice is enabled or not.
        if($location_details->print_receipt_on_invoice == 1){

            //If enabled, get print type.
            $output['is_enabled'] = true;

            $invoice_layout = $this->businessUtil->invoiceLayout($business_id, $location_id, $location_details->invoice_layout_id);

            //Check if printer setting is provided.
            $receipt_printer_type = is_null($printer_type) ? $location_details->receipt_printer_type : $printer_type;

            $receipt_details = $this->transactionUtil->getReceiptDetails($transaction_id, $location_id, $invoice_layout, $business_details, $location_details, $receipt_printer_type);

            //If print type browser - return the content, printer - return printer config data, and invoice format config
            if($receipt_printer_type == 'printer'){
                $output['print_type'] = 'printer';
                $output['printer_config'] = $this->businessUtil->printerConfig($business_id, $location_details->printer_id);
                $output['data'] = $receipt_details;
            } else {

                $layout = !empty($receipt_details->design) ? 'sale_pos.receipts.' . $receipt_details->design: 'sale_pos.receipts.classic';
                $output['html_content'] = view($layout, compact('receipt_details'))->render();
            }
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
        if (!auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }

        //Check if the transaction can be edited or not.
        $edit_days = request()->session()->get('business.transaction_edit_days');
        if(!$this->transactionUtil->canBeEdited($id, $edit_days)){
            return back()
                ->with('status', ['success' => 0, 
                    'msg' => __('messages.transaction_edit_not_allowed', ['days' => $edit_days])]
                );
        }

        //Check if there is a open register, if no then redirect to Create Register screen.
        if($this->cashRegisterUtil->countOpenedRegister() == 0){
            return redirect()->action('CashRegisterController@create');
        }
        
        $business_id = request()->session()->get('user.business_id');
        $walk_in_customer = $this->contactUtil->getWalkInCustomer($business_id);
        
        $business_details = $this->businessUtil->getDetails($business_id);
        $taxes = TaxRate::forBusinessDropdown($business_id, true, true);
        $payment_types = $this->productUtil->payment_types();

        $transaction = Transaction::where('business_id', $business_id)
                            ->where('type', 'sell')
                            ->findorfail($id);

        $location_id = $transaction->location_id;
        $location_printer_type = BusinessLocation::find($location_id)->receipt_printer_type;

        $sell_details = TransactionSellLine::
                        join('products AS p', 
                            'transaction_sell_lines.product_id', '=', 'p.id')
                        ->join('variations AS variations', 
                            'transaction_sell_lines.variation_id', '=', 'variations.id')
                        ->join('product_variations AS pv', 
                            'variations.product_variation_id', '=', 'pv.id')
                        ->leftjoin('variation_location_details AS vld', function ($join) use ($location_id) {
                                $join->on('variations.id',  '=', 'vld.variation_id')
                                ->where('vld.location_id', '=', $location_id);
                        })
                        ->leftjoin('units', 'units.id', '=', 'p.unit_id')
                        ->where('transaction_sell_lines.transaction_id', $id)
                        ->select(DB::raw("IF(pv.is_dummy = 0, CONCAT(p.name, ' (', pv.name, ':',variations.name, ')'), p.name) AS product_name"), 
                            'p.id as product_id',
                            'p.enable_stock',
                            'p.name as product_actual_name',
                            'pv.name as product_variation_name',
                            'pv.is_dummy as is_dummy',
                            'variations.name as variation_name',
                            'variations.sub_sku',
                            'p.barcode_type',
                            'p.enable_sr_no',
                            'variations.id as variation_id',
                            'units.short_name as unit',
                            'units.allow_decimal as unit_allow_decimal',
                            'transaction_sell_lines.tax_id as tax_id',
                            'transaction_sell_lines.unit_price as default_sell_price', 
                            'transaction_sell_lines.unit_price_inc_tax as sell_price_inc_tax', 
                            'transaction_sell_lines.id as transaction_sell_lines_id',
                            'transaction_sell_lines.quantity as quantity_ordered',
                            'transaction_sell_lines.sell_line_note as sell_line_note',
                            DB::raw('vld.qty_available + transaction_sell_lines.quantity AS qty_available')
                        )
                        ->get();
        if(!empty($sell_details)){
            foreach ($sell_details as $key => $value) {
                $sell_details[$key]->formatted_qty_available = $this->productUtil->num_f($value->qty_available);
            }
        }

        $payment_lines = $this->transactionUtil->getPaymentDetails($id);
        //If no payment lines found then add dummy payment line.
        if(empty($payment_lines)){
            $payment_lines[] = $this->dummyPaymentLine;
        }

        $shortcuts = json_decode($business_details->keyboard_shortcuts, true);
        $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);

        $commsn_agnt_setting = $business_details->sales_cmsn_agnt;
        $commission_agent = array();
        if($commsn_agnt_setting == 'user'){
            $commission_agent = User::forDropdown($business_id, false);
        } elseif($commsn_agnt_setting == 'cmsn_agnt'){
            $commission_agent = User::saleCommissionAgentsDropdown($business_id, false);
        }

        $categories = Category::catAndSubCategories($business_id);

        $change_return = $this->dummyPaymentLine;
        return view ('sale_pos.edit')
            ->with(compact('business_details', 'taxes', 'payment_types', 'walk_in_customer', 'sell_details', 'transaction', 'payment_lines', 'location_printer_type', 'shortcuts', 'commission_agent', 'categories', 'pos_settings', 'change_return'));
    }

    /**
     * Update the specified resource in storage.
     * TODO: Add edit log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('sell.update') && !auth()->user()->can('direct_sell.access')) {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $input = $request->except('_token');

            //status is send as quotation from edit sales screen.
            if($input['status'] == 'quotation'){
                $input['status'] = 'draft';
                $input['is_quotation'] = 1;
            }

            if(!empty($input['products'])){
                //Get transaction value before updating.
                $transaction_before = Transaction::find($id);
                $status_before =  $transaction_before->status;

                $is_direct_sale = false;
                if($transaction_before->is_direct_sale == 1){
                    $is_direct_sale = true;
                }

                //Check if there is a open register, if no then redirect to Create Register screen.
                if(!$is_direct_sale && $this->cashRegisterUtil->countOpenedRegister() == 0){
                    return redirect()->action('CashRegisterController@create');
                }

                $business_id = $request->session()->get('user.business_id');
                $user_id = $request->session()->get('user.id');
                $commsn_agnt_setting = $request->session()->get('business.sales_cmsn_agnt');

                $discount = ['discount_type' => $input['discount_type'],
                                'discount_amount' => $input['discount_amount']
                            ];
                $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], $input['tax_rate_id'], $discount);

                if(!empty($request->input('transaction_date'))){
                    $input['transaction_date'] = $this->productUtil->uf_date($request->input('transaction_date'));
                }

                $input['commission_agent'] = !empty($request->input('commission_agent')) ? $request->input('commission_agent') : null;
                if($commsn_agnt_setting == 'logged_in_user'){
                    $input['commission_agent'] = $user_id;
                }

                //Customer group details
                $contact_id = $request->get('contact_id', null);
                $cg = $this->contactUtil->getCustomerGroup($business_id, $contact_id);
                $input['customer_group_id'] = (empty($cg) || empty($cg->id)) ? null : $cg->id;
                
                //Begin transaction
                DB::beginTransaction();

                $transaction = $this->transactionUtil->updateSellTransaction($id, $business_id, $input, $invoice_total, $user_id);

                //Update Sell lines
                $deleted_lines = $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id'], true);

                //Update update lines
                if(!$is_direct_sale){

                    //Add change return
                    $change_return = $this->dummyPaymentLine;
                    $change_return['amount'] = $input['change_return'];
                    $change_return['is_return'] = 1;
                    if(!empty($input['change_return_id'])){
                        $change_return['id'] = $input['change_return_id'];
                    }
                    $input['payment'][] = $change_return;

                    $this->transactionUtil->createOrUpdatePaymentLines($transaction, $input['payment']);

                    //Update cash register
                    $this->cashRegisterUtil->updateSellPayments($status_before, $transaction, $input['payment']);
                }

                //Update payment status
                $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);

                //Update product stock
                $this->productUtil->adjustProductStockForInvoice($status_before, $transaction, $input);

                //Allocate the quantity from purchase and add mapping of 
                //purchase & sell lines in 
                //transaction_sell_lines_purchase_lines table
                $business = ['id' => $business_id, 
                                'accounting_method' => $request->session()->get('business.accounting_method'),
                                'location_id' => $input['location_id']
                            ];
                $this->transactionUtil->adjustMappingPurchaseSell($status_before, $transaction, $business, $deleted_lines);
                
                //Send data to store in modules.
                $param = ['Restaurant' => ['business_id' => $business_id, 
                            'transaction_id' => $transaction->id]];
                $this->moduleUtil->storeModulesData('sellPosStore', $param);

                DB::commit();
                    
                $msg = '';
                $receipt = '';

                if($input['status'] == 'draft' && $input['is_quotation'] == 0){
                    $msg = trans("sale.draft_added");
                } elseif($input['status'] == 'draft' && $input['is_quotation'] == 1){
                    $msg = trans("lang_v1.quotation_updated");
                    if(!$is_direct_sale){
                        $receipt = $this->receiptContent($business_id, $input['location_id'], $transaction->id);
                    } else {
                        $receipt = '';
                    }
                } elseif($input['status'] == 'final'){
                    $msg = trans("sale.pos_sale_updated");
                    if(!$is_direct_sale){
                        $receipt = $this->receiptContent($business_id, $input['location_id'], $transaction->id);
                    } else {
                        $receipt = '';
                    }
                }

                $output = array('success' => 1, 'msg' => $msg, 'receipt' => $receipt );
            } else {
                $output = array('success' => 0, 
                            'msg' => trans("messages.something_went_wrong")
                        );
            }

        } catch(\Exception $e){
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = array('success' => 0, 
                            'msg' => trans("messages.something_went_wrong")
                        );
        }

        if(!$is_direct_sale){
            return $output;
        } else {
            if($input['status'] == 'draft'){
                if(isset($input['is_quotation']) && $input['is_quotation'] == 1){
                    return redirect()
                        ->action('SellController@getQuotations')
                        ->with('status', $output);
                } else {
                    return redirect()
                        ->action('SellController@getDrafts')
                        ->with('status', $output);
                }
            } else {
                return redirect('sells')->with('status', $output);
            }
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
        if (!auth()->user()->can('sell.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try{
                $business_id = request()->session()->get('user.business_id');
                $transaction = Transaction::where('id', $id)
                                        ->where('business_id', $business_id)
                                        ->where('type', 'sell')
                                        ->with(['sell_lines'])
                                        ->first();
                //Begin transaction
                DB::beginTransaction();

                if(!empty($transaction)){
                    //If status is draft direct delete transaction
                    if($transaction->status == 'draft'){
                        $transaction->delete();
                    } else {
                        $deleted_sell_lines = $transaction->sell_lines;
                        $deleted_sell_lines_ids = $deleted_sell_lines->pluck('id')->toArray();
                        $this->transactionUtil->deleteSellLines($deleted_sell_lines_ids, 
                            $transaction->location_id);

                        $transaction->status = 'draft';
                        $business = ['id' => $business_id, 
                                'accounting_method' => request()->session()->get('business.accounting_method'),
                                'location_id' => $transaction->location_id
                            ];

                        $this->transactionUtil->adjustMappingPurchaseSell('final', $transaction, $business, $deleted_sell_lines_ids);

                        $transaction->delete();
                    }

                }
                DB::commit();
                $output = array(
                    'success' => true,
                    'msg' => __('lang_v1.sale_delete_success')
                );

            } catch(\Exception $e){
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output['success'] = false;
                $output['msg'] = trans("messages.something_went_wrong");
            }

        return $output;

        }
        
    }

    /**
     * Returns the HTML row for a product in POS
     *
     * @param  int  $variation_id
     * @param  int  $location_id
     * @return \Illuminate\Http\Response
     */
    public function getProductRow($variation_id, $location_id)
    {
        $output = [];

        try{
            $row_count = request()->get('product_row');
            $row_count = $row_count + 1;

            $business_id = request()->session()->get('user.business_id');

            $product = $this->productUtil->getDetailsFromVariation($variation_id, $business_id, $location_id);
            $product->formatted_qty_available = $this->productUtil->num_f($product->qty_available);

            //Get customer group and change the price accordingly
            $customer_id = request()->get('customer_id', null);
            $cg = $this->contactUtil->getCustomerGroup($business_id, $customer_id);
            $percent = (empty($cg) || empty($cg->amount)) ? 0 : $cg->amount;
            $product->default_sell_price = $product->default_sell_price + ($percent * $product->default_sell_price / 100);
            $product->sell_price_inc_tax = $product->sell_price_inc_tax + ($percent * $product->sell_price_inc_tax / 100);

            $tax_dropdown = TaxRate::forBusinessDropdown($business_id, true, true);

            $output['success'] = true;
            $output['html_content'] =  view('sale_pos.product_row')
                                ->with(compact('product', 'row_count', 'tax_dropdown'))
                                ->render();
            $output['enable_sr_no'] = $product->enable_sr_no;

        } catch(\Exception $e){

            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output['success'] = false;
            $output['msg'] = __("lang_v1.item_out_of_stock");
        }

        return $output;
    }

    /**
     * Returns the HTML row for a payment in POS
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPaymentRow(Request $request)
    {
        $row_index = $request->input('row_index');
        $removable = true;
        $payment_types = $this->productUtil->payment_types();

        $payment_line = $this->dummyPaymentLine;

        return view('sale_pos.partials.payment_row')
            ->with(compact('payment_types', 'row_index', 'removable', 'payment_line'));
    }

    /**
     * Returns recent transactions
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getRecentTransactions(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $user_id = $request->session()->get('user.id');
        $transaction_status = $request->get('status');

        $query = Transaction::where('business_id', $business_id)
                            ->where('created_by', $user_id)
                            ->where('type', 'sell')
                            ->where('is_direct_sale', 0);

        if($transaction_status == 'quotation'){
            $query->where('status', 'draft')
                ->where('is_quotation', 1);
        } elseif($transaction_status == 'draft') {
            $query->where('status', 'draft')
                ->where('is_quotation', 0);
        } else {
            $query->where('status', $transaction_status);
        }

        $transactions = $query->latest()
                            ->limit(10)
                            ->get();

        return view('sale_pos.partials.recent_transactions')
            ->with(compact('transactions'));
    }

    /**
     * Prints invoice for sell
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function printInvoice(Request $request, $transaction_id)
    {
        if (request()->ajax()) {

            try {

                $output = array('success' => 0, 
                        'msg' => trans("messages.something_went_wrong")
                        );

                $business_id = $request->session()->get('user.business_id');
            
                $transaction = Transaction::where('business_id', $business_id)
                                ->where('id', $transaction_id)
                                ->first();

                if(empty($transaction)){
                    return $output;
                }

                $receipt = $this->receiptContent($business_id, $transaction->location_id, $transaction_id, 'browser');

                if(!empty($receipt)){
                    $output = array('success' => 1, 'receipt' => $receipt);
                }

            } catch (\Exception $e){
                $output = array('success' => 0, 
                        'msg' => trans("messages.something_went_wrong")
                        );
            }

            return $output;
        }
    }

    /**
     * Gives suggetion for product based on category
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getProductSuggestion(Request $request)
    {
        if ($request->ajax()) {
            $category_id = $request->get('category_id');
            $location_id = $request->get('location_id');
            $term = $request->get('term');

            $check_qty = false;
            $business_id = $request->session()->get('user.business_id');

            $products = Product::join('variations', 'products.id',  '=', 
                            'variations.product_id')
                        ->leftjoin('variation_location_details AS VLD', 
                            function ($join) use ($location_id) {
                                $join->on('variations.id',  '=', 'VLD.variation_id');

                        //Include Location
                        if(!empty($location_id)){
                            $join->where(function($query) use ($location_id)
                                {
                                    $query->where('VLD.location_id', '=', $location_id);
                                    //Check null to show products even if no quantity is available in a location.
                                    //TODO: Maybe add a settings to show product not available at a location or not.
                                    $query->orWhereNull('VLD.location_id');
                                });
                            ;
                        }
                })
                ->where('products.business_id', $business_id);

            //Include search
            if(!empty($term)){
                $products->where(function($query) use ($term)
                    {
                        $query->where('products.name', 'like', '%' . $term .'%');
                        $query->orWhere('sku', 'like', '%' . $term .'%');
                        $query->orWhere('sub_sku', 'like', '%' . $term .'%');
                    });
            }

            //Include check for quantity
            if($check_qty){
                $products->where('VLD.qty_available', '>', 0);
            }
            
            if($category_id == 'uncategorised'){
                $products->whereNull('products.category_id');
            } else {
                $products->where(function($query) use ($category_id)
                {
                    $query->where('products.category_id', $category_id);
                    $query->orWhere('products.sub_category_id', $category_id);
                });
            }

            $products = $products->select('products.id as product_id', 
                            'products.name', 'products.type', 'products.enable_stock', 'variations.id as variation_id', 'variations.name as variation', 'VLD.qty_available', 'variations.default_sell_price as selling_price', 'variations.sub_sku')
                        ->orderBy('products.name', 'asc')
                        ->paginate(20);

            return view('sale_pos.partials.product_list')
                    ->with(compact('products'));
        }
    }

}