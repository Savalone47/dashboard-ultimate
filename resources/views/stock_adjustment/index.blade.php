@extends('layouts.app')
@section('title', __('stock_adjustment.stock_adjustments'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('stock_adjustment.stock_adjustments')
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang('stock_adjustment.all_stock_adjustments')</h3>
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('StockAdjustmentController@create')}}">
                <i class="fa fa-plus"></i> @lang('messages.add')</a>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="stock_adjustment_table">
        		<thead>
        			<tr>
        				<th>@lang('messages.date')</th>
                        <th>@lang('business.location')</th>
                        <th>@lang('stock_adjustment.adjustment_type')</th>
                        <th>@lang('stock_adjustment.total_amount')</th>
                        <th>@lang('stock_adjustment.total_amount_recovered')</th>
                        <th>@lang('stock_adjustment.reason_for_stock_adjustment')</th>
						<th>@lang('messages.action')</th>
        			</tr>
        		</thead>
        	</table>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
	<script src="{{ asset('js/stock_adjustment.js?v=' . $asset_v) }}"></script>
@endsection