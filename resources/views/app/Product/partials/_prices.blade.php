<div id="prices-container" class="row">
    <div class="row margin-left10 margin-right10 margin-bottom15 padding-10 bg-info">
        <div id="override-container">
            <h4>Override Price Per Day</h4>
            @if(isset($product->overrides) and count($product->overrides))
                @foreach($product->overrides as $override)
                <div id="override-wrapper" class="col-md-12 padding-bottom10">
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right overrides override-date" name="overrides[override_dates][0][]" value="{{ $override->override_dates }}" readonly>
                        </div>
                        <small>Date</small>
                    </div>

                    <div class="col-md-1">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right text-right overrid-price" name="overrides[override_price][1][]" value="{{ $override->override_price }}">
                        </div>
                        <small>Price Per Day</small>
                    </div>

                    <div class="col-md-1">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-flat toggle-create-override-row">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-flat toggle-remove-override-row">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @elseif(!is_null(old('overrides')))
                @php($old_overrides = old('overrides'))

                @for ($idx = 0; $idx < count($old_overrides['override_dates'][0]); $idx++)
                <div id="override-wrapper" class="col-md-12 padding-bottom10">
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right overrides override-date" name="overrides[override_dates][0][]" value="{{ $old_overrides['override_dates'][0][$idx] }}" readonly>
                        </div>
                        <small>Date</small>
                    </div>

                    <div class="col-md-1">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right text-right overrid-price" name="overrides[override_price][1][]" value="{{ $old_overrides['override_price'][1][$idx] }}">
                        </div>
                        <small>Price Per Day</small>
                    </div>

                    <div class="col-md-1">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-flat toggle-create-override-row">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-flat toggle-remove-override-row">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
            @else
            <div id="override-wrapper" class="col-md-12 padding-bottom10">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right overrides override-date" name="overrides[override_dates][0][]" readonly>
                    </div>
                    <small>Date</small>
                </div>

                <div class="col-md-1">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right text-right override-price" name="overrides[override_price][1][]" value="0">
                    </div>
                    <small>Price Per Day</small>
                </div>

                <div class="col-md-1">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-flat toggle-create-override-row">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-flat toggle-remove-override-row">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row margin-left10">
        <div class="col-md-4"> <h4>Price Category</h4> </div>
        <div class="col-md-2"> <h4>No. Of Days</h4> </div>
        <div class="col-md-2"> <h4>Month</h4> </div>
        <div class="col-md-1"> <h4>Year</h4> </div>
        <div class="col-md-1"> <h4>Price Value</h4> </div>
        <div class="col-md-1"> </div>
    </div>

    @if(isset($product->prices))
        @foreach($product->prices as $i => $prices)
        <div id="first-row" class="row margin-bottom10 margin-left10">
            <div class="col-md-4">
				@if($i > 0)
					@php($disabled = "disabled=disabled")
				@else
					@php($disabled = "")
				@endif
                <select name="prices[category_id][0][]" class="form-control price-category" {{ $disabled }}>
                    @if($priceCategories->count())
                        <option value="">-- Select Price Category --</option>
                        @foreach($priceCategories->get() as $price)
                            @if($price->id == $prices->category_id)
                            <option value="{{ $price->id }}" selected>{{ $price->category_name }}</option>
                            @else
                            <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="prices[no_of_days][1][]">
                    <option value="" readonly>-- No. of days --</option>
                    @for($i=1; $i<=31; $i++)
                        @if($prices->no_of_days == $i)
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="prices[price_month][2][]" class="form-control price_month" id="">
                    <option value="" readonly>-- Months --</option>
                    @foreach ($months as $month)
                        @if($month == $prices->price_month)
                        <option value="{{ $month }}" selected>{{ $month }}</option>
                        @else
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <select name="prices[price_year][3][]" class="form-control price_year" id="">
                    <option value="" readonly>-- Years --</option>
                    @foreach ($years as $year)
                        @if($year == $prices->price_year)
                        <option value="{{ $year }}" selected>{{ $year }}</option>
                        @else
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="text" name="prices[price_value][4][]"
                       class="form-control price-value"
                       placeholder="Price Value"
                       maxlength="6"
                       value="{{ $prices->price_value }}">
            </div>
            <div class="col-md-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-flat" id="toggle-create-row">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-flat" id="toggle-remove-row" data-price-id="{{ $prices->id }}">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    @elseif(!is_null(old('prices')))
        @php($old_prices = old('prices'))

        @for ($idx=0; $idx < count($old_prices['price_value'][4]); $idx++)
        <div id="first-row" class="row margin-bottom10 margin-left10">
            <div class="col-md-4">
                <select name="prices[category_id][0][]" class="form-control price-category">
                    @if($priceCategories->count())
                        <option value="">-- Category --</option>
                        @foreach($priceCategories->get() as $price)
                            @if($price->id == $old_prices['category_id'][0][0])
                            <option value="{{ $price->id }}" selected>{{ $price->category_name }}</option>
                            @else
                            <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="prices[no_of_days][1][]">
                    <option value="" readonly>-- No. of days --</option>
                    @for($i=1; $i<=31; $i++)
                        @if($i == $old_prices['no_of_days'][1][$idx])
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="prices[price_month][2][]" class="form-control price_month" id="">
                    <option value="" readonly>-- Months --</option>
                    @foreach ($months as $month)
                        @if($month == $old_prices['price_month'][2][$idx])
                        <option value="{{ $month }}" selected>{{ $month }}</option>
                        @else
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <select name="prices[price_year][3][]" class="form-control price_year" id="">
                    <option value="" readonly>-- Years --</option>
                    @foreach ($years as $year)
                        @if($year == $old_prices['price_year'][3][$idx])
                        <option value="{{ $year }}" selected>{{ $year }}</option>
                        @else
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="text" name="prices[price_value][4][]"
                       class="form-control price-value text-right"
                       placeholder="Price Value"
                       maxlength="6"
                       value="{{ $old_prices['price_value'][4][$idx] }}">
            </div>
            <div class="col-md-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-flat" id="toggle-create-row">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-flat" id="toggle-remove-row">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
        @endfor
    @else
        <div id="first-row" class="row margin-bottom10 margin-left10">
            <div class="col-md-4">
                <select name="prices[category_id][0][]" class="form-control price-category">
                    @if($priceCategories->count())
                        <option value="">-- Category --</option>
                        @foreach($priceCategories->get() as $price)
                        <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="prices[no_of_days][1][]">
                    <option value="" readonly>-- No. of days --</option>
                    @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="prices[price_month][2][]" class="form-control price_month" id="">
                    <option value="" readonly>-- Months --</option>
                    @foreach ($months as $month)
                    <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <select name="prices[price_year][3][]" class="form-control price_year" id="">
                    <option value="" readonly>-- Years --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="text" name="prices[price_value][4][]"
                       class="form-control price-value text-right"
                       placeholder="Price Value"
                       maxlength="6"
                       value="0">
            </div>
            <div class="col-md-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-flat" id="toggle-create-row">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-flat" id="toggle-remove-row">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
