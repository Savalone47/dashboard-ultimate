<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('ContactController@update', [$contact->id]), 'method' => 'PUT', 'id' => 'contact_edit_form']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('contact.edit_contact')</h4>
    </div>

    <div class="modal-body">

      <div class="row">

      <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('type', __('contact.contact_type') . ':*' ) !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                {!! Form::select('type', $types, $contact->type, ['class' => 'form-control', 'id' => 'contact_type','placeholder' => __('messages.please_select'), 'required']); !!}
            </div>
        </div>
      </div>

      <div class="col-md-12 supplier_fields">
          <div class="form-group">
              {!! Form::label('supplier_business_name', __('business.business_name') . ':*') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-briefcase"></i>
                  </span>
                  {!! Form::text('supplier_business_name', 
                  $contact->supplier_business_name, ['class' => 'form-control', 'required', 'placeholder' => __('business.business_name')]); !!}
              </div>
          </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('name', __('contact.name') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                {!! Form::text('name', $contact->name, ['class' => 'form-control','placeholder' => __('contact.name'), 'required']); !!}
            </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('contact_id', __('lang_v1.contact_id') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-id-badge"></i>
                </span>
                <input type="hidden" id="hidden_id" value="{{$contact->id}}">
                {!! Form::text('contact_id', $contact->contact_id, ['class' => 'form-control','placeholder' => __('lang_v1.contact_id')]); !!}
            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-6 supplier_fields">
          <div class="form-group">
              {!! Form::label('tax_number', __('contact.tax_no') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-info"></i>
                  </span>
                  {!! Form::text('tax_number', $contact->tax_number, ['class' => 'form-control', 'placeholder' => __('contact.tax_no')]); !!}
              </div>
          </div>
        </div>

        <div class="col-md-3 supplier_fields">
          <div class="form-group">
              {!! Form::label('pay_term_number', __('contact.pay_term') . '*:') !!} @show_tooltip(__('tooltip.pay_term'))
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-handshake-o"></i>
                  </span>
                  {!! Form::number('pay_term_number', $contact->pay_term_number, ['class' => 'form-control', 'required', 'placeholder' => __('contact.pay_term') ]); !!}
              </div>
          </div>
        </div>

        <div class="col-md-3 supplier_fields">
          <div class="form-group">
              {!! Form::label('pay_term_type', __('contact.pay_term_period') . '*:') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                  </span>
                  {!! Form::select('pay_term_type', ['months' => __('lang_v1.months'), 'days' => __('lang_v1.days')], $contact->pay_term_type, ['class' => 'form-control','placeholder' => __('messages.please_select'), 'required']); !!}
              </div>
          </div>
        </div>

        <div class="col-md-6 customer_fields">
          <div class="form-group">
              {!! Form::label('customer_group_id', __('lang_v1.customer_group') . ':') !!}
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-users"></i>
                  </span>
                  {!! Form::select('customer_group_id', $customer_groups, $contact->customer_group_id, ['class' => 'form-control']); !!}
              </div>
          </div>
        </div>

      <div class="col-md-12">
        <hr/>
      </div>

      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('mobile', __('contact.mobile') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-mobile"></i>
                </span>
                {!! Form::text('mobile', $contact->mobile, ['class' => 'form-control', 'required', 'placeholder' => __('contact.mobile')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('landline', __('contact.landline') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('landline', $contact->landline, ['class' => 'form-control', 'placeholder' => __('contact.landline')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('alternate_number', __('contact.alternate_contact_number') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                {!! Form::text('alternate_number', $contact->alternate_number, ['class' => 'form-control', 'placeholder' => __('contact.alternate_contact_number')]); !!}
            </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('city', __('business.city') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('city', $contact->city, ['class' => 'form-control', 'placeholder' => __('business.city')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('state', __('business.state') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('state', $contact->state, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
            </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('country', __('business.country') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                {!! Form::text('country', $contact->country, ['class' => 'form-control', 'placeholder' => __('business.country')]); !!}
            </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('landmark', __('business.landmark') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                {!! Form::text('landmark', $contact->landmark, ['class' => 'form-control', 'placeholder' => __('business.landmark')]); !!}
            </div>
        </div>
      </div>

    </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->