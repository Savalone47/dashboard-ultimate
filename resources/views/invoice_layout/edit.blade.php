@extends('layouts.app')
@section('title',  __('invoice.edit_invoice_layout'))

@section('content')
<style type="text/css">



</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('invoice.edit_invoice_layout')</h1>
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['url' => action('InvoiceLayoutController@update', [$invoice_layout->id]), 'method' => 'put', 
  'id' => 'add_invoice_layout_form', 'files' => true]) !!}
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">

        <div class="col-sm-6">
         <div class="form-group">
            {!! Form::label('name', __('invoice.layout_name') . ':*') !!}
              {!! Form::text('name', $invoice_layout->name, ['class' => 'form-control', 'required',
              'placeholder' => __('invoice.layout_name')]); !!}
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('design', __('lang_v1.design') . ':*') !!}
              {!! Form::select('design', $designs, $invoice_layout->design, ['class' => 'form-control']); !!}
              <span class="help-block">Used for browser based printing</span>
          </div>
        </div>

        <!-- Logo -->
        <div class="col-sm-6">
          <div class="form-group">
            {!! Form::label('logo', __('invoice.invoice_logo') . ':') !!}
            {!! Form::file('logo'); !!}
            <span class="help-block">@lang('lang_v1.invoice_logo_help', ['max_size' => '1 MB'])<br> @lang('lang_v1.invoice_logo_help2')</span>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_logo', 1, $invoice_layout->show_logo, ['class' => 'input-icheck']); !!} @lang('invoice.show_logo')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('header_text', __('invoice.header_text') . ':' ) !!}
              {!! Form::textarea('header_text', $invoice_layout->header_text, ['class' => 'form-control',
              'placeholder' => __('invoice.header_text'), 'rows' => 3]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_heading_line1', __('lang_v1.sub_heading_line', ['_number_' => 1]) . ':' ) !!}
            {!! Form::text('sub_heading_line1', $invoice_layout->sub_heading_line1, ['class' => 'form-control',
              'placeholder' => __('lang_v1.sub_heading_line', ['_number_' => 1]) ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_heading_line2', __('lang_v1.sub_heading_line', ['_number_' => 2]) . ':' ) !!}
            {!! Form::text('sub_heading_line2', $invoice_layout->sub_heading_line2, ['class' => 'form-control',
              'placeholder' => __('lang_v1.sub_heading_line', ['_number_' => 2]) ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_heading_line3', __('lang_v1.sub_heading_line', ['_number_' => 3]) . ':' ) !!}
            {!! Form::text('sub_heading_line3', $invoice_layout->sub_heading_line3, ['class' => 'form-control',
              'placeholder' => __('lang_v1.sub_heading_line', ['_number_' => 3]) ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_heading_line4', __('lang_v1.sub_heading_line', ['_number_' => 4]) . ':' ) !!}
            {!! Form::text('sub_heading_line4', $invoice_layout->sub_heading_line4, ['class' => 'form-control',
              'placeholder' => __('lang_v1.sub_heading_line', ['_number_' => 4]) ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_heading_line5', __('lang_v1.sub_heading_line', ['_number_' => 5]) . ':' ) !!}
            {!! Form::text('sub_heading_line5', $invoice_layout->sub_heading_line5, ['class' => 'form-control',
              'placeholder' => __('lang_v1.sub_heading_line', ['_number_' => 5]) ]); !!}
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('invoice_heading', __('invoice.invoice_heading') . ':' ) !!}
            {!! Form::text('invoice_heading', $invoice_layout->invoice_heading, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('invoice_heading_not_paid', __('invoice.invoice_heading_not_paid') . ':' ) !!}
            {!! Form::text('invoice_heading_not_paid', $invoice_layout->invoice_heading_not_paid, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading_not_paid') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('invoice_heading_paid', __('invoice.invoice_heading_paid') . ':' ) !!}
            {!! Form::text('invoice_heading_paid', $invoice_layout->invoice_heading_paid, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_heading_paid') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('quotation_heading', __('lang_v1.quotation_heading') . ':' ) !!}@show_tooltip(__('lang_v1.tooltip_quotation_heading'))
            {!! Form::text('quotation_heading', $invoice_layout->quotation_heading, ['class' => 'form-control', 'placeholder' => __('lang_v1.quotation_heading') ]); !!}
          </div>
        </div>

        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('invoice_no_prefix', __('invoice.invoice_no_prefix') . ':' ) !!}
            {!! Form::text('invoice_no_prefix', $invoice_layout->invoice_no_prefix, ['class' => 'form-control',
              'placeholder' => __('invoice.invoice_no_prefix') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('quotation_no_prefix', __('lang_v1.quotation_no_prefix') . ':' ) !!}
            {!! Form::text('quotation_no_prefix', $invoice_layout->quotation_no_prefix, ['class' => 'form-control',
              'placeholder' => __('lang_v1.quotation_no_prefix') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('customer_label', __('invoice.customer_label') . ':' ) !!}
            {!! Form::text('customer_label', $invoice_layout->customer_label, ['class' => 'form-control',
              'placeholder' => __('invoice.customer_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('date_label', __('lang_v1.date_label') . ':' ) !!}
            {!! Form::text('date_label', $invoice_layout->date_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.date_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('client_id_label', __('lang_v1.client_id_label') . ':' ) !!}
            {!! Form::text('client_id_label', $invoice_layout->client_id_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.client_id_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('client_tax_label', __('lang_v1.client_tax_label') . ':' ) !!}
            {!! Form::text('client_tax_label', $invoice_layout->client_tax_label, ['class' => 'form-control',
            'placeholder' => __('lang_v1.client_tax_label') ]); !!}
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_client_id', 1, $invoice_layout->show_client_id, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_client_id')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_customer', 1, $invoice_layout->show_customer, ['class' => 'input-icheck']); !!} @lang('invoice.show_customer')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_business_name', 1, $invoice_layout->show_business_name, ['class' => 'input-icheck']); !!} @lang('invoice.show_business_name')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_location_name', 1, $invoice_layout->show_location_name, ['class' => 'input-icheck']); !!} @lang('invoice.show_location_name')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_time', 1, $invoice_layout->show_time, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_time_with_date')</label>
              </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-12">
            <h4>@lang('invoice.fields_to_be_shown_in_address'):</h4>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_landmark', 1, $invoice_layout->show_landmark, ['class' => 'input-icheck']); !!} @lang('business.landmark')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_city', 1, $invoice_layout->show_city, ['class' => 'input-icheck']); !!} @lang('business.city')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_state', 1, $invoice_layout->show_state, ['class' => 'input-icheck']); !!} @lang('business.state')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_country', 1, $invoice_layout->show_country, ['class' => 'input-icheck']); !!} @lang('business.country')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_zip_code', 1, $invoice_layout->show_zip_code, ['class' => 'input-icheck']); !!} @lang('business.zip_code')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label>@lang('invoice.fields_to_shown_for_communication'):</label>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_mobile_number', 1, $invoice_layout->show_mobile_number, ['class' => 'input-icheck']); !!} @lang('invoice.show_mobile_number')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_alternate_number', 1, $invoice_layout->show_alternate_number, ['class' => 'input-icheck']); !!} @lang('invoice.show_alternate_number')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_email', 1, $invoice_layout->show_email, ['class' => 'input-icheck']); !!} @lang('invoice.show_email')</label>
              </div>
          </div>
        </div>
        
        <div class="col-sm-12">
          <div class="form-group">
            <label>@lang('invoice.fields_to_shown_for_tax'):</label>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_tax_1', 1, $invoice_layout->show_tax_1, ['class' => 'input-icheck']); !!} @lang('invoice.show_tax_1')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_tax_2', 1, $invoice_layout->show_tax_2, ['class' => 'input-icheck']); !!} @lang('invoice.show_tax_2')</label>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('table_product_label', __('lang_v1.product_label') . ':' ) !!}
            {!! Form::text('table_product_label', $invoice_layout->table_product_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.product_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('table_qty_label', __('lang_v1.qty_label') . ':' ) !!}
            {!! Form::text('table_qty_label', $invoice_layout->table_qty_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.qty_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('table_unit_price_label', __('lang_v1.unit_price_label') . ':' ) !!}
            {!! Form::text('table_unit_price_label', $invoice_layout->table_unit_price_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.unit_price_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('table_subtotal_label', __('lang_v1.subtotal_label') . ':' ) !!}
            {!! Form::text('table_subtotal_label', $invoice_layout->table_subtotal_label, ['class' => 'form-control',
              'placeholder' => __('lang_v1.subtotal_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('cat_code_label', __('lang_v1.cat_code_label') . ':' ) !!}
            {!! Form::text('cat_code_label', $invoice_layout->cat_code_label, ['class' => 'form-control', 'placeholder' => 'HSN or Category Code' ]); !!}
          </div>
        </div>
        
        <div class="col-sm-12">
          <h4>@lang('lang_v1.product_details_to_be_shown'):</h4>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_brand', 1, $invoice_layout->show_brand, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_brand')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_sku', 1, $invoice_layout->show_sku, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_sku')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_cat_code', 1, $invoice_layout->show_cat_code, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_cat_code')</label>
              </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
              {!! Form::checkbox('show_sale_description', 1, $invoice_layout->show_sale_description, ['class' => 'input-icheck']); !!} @lang('lang_v1.show_sale_description')</label>
            </div>
            <p class="help-block">@lang('lang_v1.product_imei_or_sn')</p>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('sub_total_label', __('invoice.sub_total_label') . ':' ) !!}
            {!! Form::text('sub_total_label', $invoice_layout->sub_total_label, ['class' => 'form-control',
              'placeholder' => __('invoice.sub_total_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('discount_label', __('invoice.discount_label') . ':' ) !!}
            {!! Form::text('discount_label', $invoice_layout->discount_label, ['class' => 'form-control',
              'placeholder' => __('invoice.discount_label') ]); !!}
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('tax_label', __('invoice.tax_label') . ':' ) !!}
            {!! Form::text('tax_label', $invoice_layout->tax_label, ['class' => 'form-control',
              'placeholder' => __('invoice.tax_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('total_label', __('invoice.total_label') . ':' ) !!}
            {!! Form::text('total_label', $invoice_layout->total_label, ['class' => 'form-control',
              'placeholder' => __('invoice.total_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('total_due_label', __('invoice.total_due_label') . ':' ) !!}
            {!! Form::text('total_due_label', $invoice_layout->total_due_label, ['class' => 'form-control',
              'placeholder' => __('invoice.total_due_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            {!! Form::label('paid_label', __('invoice.paid_label') . ':' ) !!}
            {!! Form::text('paid_label', $invoice_layout->paid_label, ['class' => 'form-control',
              'placeholder' => __('invoice.paid_label') ]); !!}
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_payments', 1, $invoice_layout->show_payments, ['class' => 'input-icheck']); !!} @lang('invoice.show_payments')</label>
              </div>
          </div>
        </div>

        <!-- Barcode -->
        <div class="col-sm-3">
          <div class="form-group">
            <div class="checkbox">
              <label>
                {!! Form::checkbox('show_barcode', 1, $invoice_layout->show_barcode, ['class' => 'input-icheck']); !!} @lang('invoice.show_barcode')</label>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
        
        <div class="col-sm-6 hide">
          <div class="form-group">
            {!! Form::label('highlight_color', __('invoice.highlight_color') . ':' ) !!}
            {!! Form::text('highlight_color', $invoice_layout->highlight_color, ['class' => 'form-control',
              'placeholder' => __('invoice.highlight_color') ]); !!}
          </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-12 hide">
          <hr/>
        </div>
        
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('footer_text', __('invoice.footer_text') . ':' ) !!}
              {!! Form::textarea('footer_text', $invoice_layout->footer_text, ['class' => 'form-control',
              'placeholder' => __('invoice.footer_text'), 'rows' => 3]); !!}
          </div>
        </div>
        @if(empty($invoice_layout->is_default))
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <div class="checkbox">
              <label>
                {!! Form::checkbox('is_default', 1, $invoice_layout->is_default, ['class' => 'input-icheck']); !!} @lang('barcode.set_as_default')</label>
            </div>
          </div>
        </div>
        @endif
        
      </div>
    </div>
  </div>
</div>

<!-- Call restaurant module if defined -->
@if(in_array('Restaurant', $enabled_modules))
  @include('restaurant::partials.invoice_layout', ['module_info' => $invoice_layout->module_info])
@endif

<div class="row">
  <div class="col-sm-12">
    <button type="submit" class="btn btn-primary pull-right">@lang('messages.update')</button>
  </div>
</div>

  {!! Form::close() !!}
</section>
<!-- /.content -->
@stop
@section('javascript')
<script src="{{ asset('AdminLTE/plugins/ckeditor/ckeditor.js?v=' . $asset_v) }}"></script>
@endsection