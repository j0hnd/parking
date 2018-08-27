@php
    if (isset($mode)) {
        $mode = $mode;
    } else {
        $mode = '';
    }
@endphp

@if($mode == 'edit')
<div class="form-group margin-top20">
    <label class="col-sm-2 control-label">Coupon Code </label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="no_coupons"
               placeholder="Number of Coupon"
               value="{{ $coupon->code }}"
               autocomplete="off">
    </div>
</div>
@else
<div class="form-group">
    <label class="col-sm-2 control-label">Number of Coupons </label>

    <div class="col-sm-9">
        <input type="number" class="form-control" name="no_coupons"
               placeholder="Number of Coupon"
               value="10"
               autocomplete="off">
    </div>
</div>
@endif

<div class="form-group">
    <label class="col-sm-2 control-label">Percent Discount </label>

    @php
        $discount = "";

        if ($mode == 'edit') {
            $discount = $coupon->reward * 100;
        }
    @endphp

    <div class="col-sm-9">
        <input type="text" class="form-control" name="reward"
               placeholder="Percent Discount"
               value="{{ $discount }}"
               autocomplete="off">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Expiration Date </label>

    @php
        $expiration_date = "";

        if ($mode == 'edit') {
            $expiration_date = date('d/m/Y', strtotime($coupon->expiry_date));
        }
    @endphp

    <div class="col-sm-9">
        <input type="text" id="expiry-date" class="form-control" name="expiry_date"
               placeholder="Expiration Date"
               value="{{ $expiration_date }}"
               autocomplete="off">
    </div>
</div>

@if($mode == 'edit')
<input type="hidden" name="id" value="{{ $coupon->id }}">
@endif

{{ csrf_field() }}
