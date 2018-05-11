<div id="prices-container" class="row">
    <div class="row margin-left10 margin-right10 margin-bottom15 padding-10 bg-info">
        <div class="col-md-12 padding-bottom10">
            <h4>Override Price Per Day</h4>
            <div class="col-md-3">

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right overrides" name="override['dates']">
                </div>
                <small>Date</small>
            </div>

            <div class="col-md-1">
                <div class="input-group">
                    <input type="text" class="form-control pull-right text-right" name="override['price']" value="0">
                </div>
                <small>Price Per Day</small>
            </div>
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
        @foreach($product->prices as $prices)
        <div id="first-row" class="row margin-bottom10 margin-left10">
            <div class="col-md-4">
                <select name="prices[category_id][0][]" class="form-control">
                    @if($priceCategories->count())
                        <option value="">-- Select Price Category --</option>
                        @foreach($priceCategories->get() as $price)
                            @if($price->id == $prices->id)
                            <option value="{{ $price->id }}" selected>{{ $price->category_name }}</option>
                            @else
                            <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="no_of_days">
                    <option value="" readonly>-- No. of days --</option>
                    @for($i=1; $i<=31; $i++)
                        @if($price->no_of_days == $i)
                        <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="prices[price_month][3][]" class="form-control price_month" id="">
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
                <select name="prices[price_year][4][]" class="form-control price_year" id="">
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
                <input type="text" name="prices[price_value][5][]"
                       class="form-control price-value"
                       placeholder="Price Value"
                       maxlength="4"
                       value="{{ $prices->price_value }}">
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
        @endforeach
    @else
        <div id="first-row" class="row margin-bottom10 margin-left10">
            <div class="col-md-4">
                <select name="prices[category_id][0][]" class="form-control">
                    @if($priceCategories->count())
                        <option value="">-- Category --</option>
                        @foreach($priceCategories->get() as $price)
                        <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" name="no_of_days">
                    <option value="" readonly>-- No. of days --</option>
                    @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <select name="prices[price_month][3][]" class="form-control price_month" id="">
                    <option value="" readonly>-- Months --</option>
                    @foreach ($months as $month)
                    <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <select name="prices[price_year][4][]" class="form-control price_year" id="">
                    <option value="" readonly>-- Years --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <input type="text" name="prices[price_value][5][]"
                       class="form-control price-value text-right"
                       placeholder="Price Value"
                       maxlength="4"
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


{{-- <div class="row">
    <div class="col-md-12">
        <table class="table table-primary">
            <thead>
                <tr>
                    <td colspan="5"></td>
                    <td class="text-center bg-teal" colspan="2"> <h4>Override Per Day</h4> </td>
                    <td></td>
                </tr>
                <tr>
                    <th style="width:30%">Price Category</th>
                    <th style="width:10%">No. Of Days</th>
                    <th style="width:10%">Price Month</th>
                    <th style="width:7%">Price Year</th>
                    <th style="width:7%">Price Value</th>
                    <th style="width:20%" class="text-center bg-teal">Date</th>
                    <th style="width:7%" class="text-center bg-teal">Price Value</th>
                    <th style="width:%"></th>
                </tr>
            </thead>
            <tbody id="price-form-wrapper">
                @if(isset($product->prices))
                    @foreach($product->prices as $prices)
                    <tr>
                        <td>
                            <select name="prices[category_id][0][]" class="form-control">
                                @if($priceCategories->count())
                                    <option value="">-- Select Price Category --</option>
                                    @foreach($priceCategories->get() as $price)
                                        @if($price->id == $prices->id)
                                        <option value="{{ $price->id }}" selected>{{ $price->category_name }}</option>
                                        @else
                                        <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="no_of_days">
                                <option value="" readonly>-- No. of days --</option>
                                @for($i=1; $i<=31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_month][3][]" class="form-control price_month" id="">
                                <option value="" readonly>-- Months --</option>
                                @foreach ($months as $month)
                                    @if($month == $prices->price_month)
                                    <option value="{{ $month }}" selected>{{ $month }}</option>
                                    @else
                                    <option value="{{ $month }}">{{ $month }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_year][4][]" class="form-control price_year" id="">
                                <option value="" readonly>-- Years --</option>
                                @foreach ($years as $year)
                                    @if($year == $prices->price_year)
                                    <option value="{{ $year }}" selected>{{ $year }}</option>
                                    @else
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="prices[price_value][5][]"
                                   class="form-control price-value"
                                   placeholder="Price Value"
                                   maxlength="4"
                                   value="{{ $prices->price_value }}">
                       </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-flat" id="toggle-create-row">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-flat" id="toggle-remove-row">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <select name="prices[category_id][0][]" class="form-control">
                                @if($priceCategories->count())
                                    <option value="">-- Category --</option>
                                    @foreach($priceCategories->get() as $price)
                                    <option value="{{ $price->id }}">{{ $price->category_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="prices[override][date]" class="override-dates">
                            <input type="hidden" name="prices[override][price]" class="override-price">
                        </td>
                        <td>
                            <select class="form-control" name="no_of_days">
                                <option value="" readonly>-- No. of days --</option>
                                @for($i=1; $i<=31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_month][3][]" class="form-control price_month" id="">
                                <option value="" readonly>-- Months --</option>
                                @foreach ($months as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_year][4][]" class="form-control price_year" id="">
                                <option value="" readonly>-- Years --</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="prices[price_value][5][]"
                                   class="form-control price-value"
                                   placeholder="Price Value"
                                   maxlength="4"
                                   value="0">
                        </td>
                        <td class="bg-teal">
                            <div class="col-md-12 col-xs-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right overrides" name="ovrride['dates']">
                                </div>
                            </div>
                        </td>
                        <td class="bg-teal">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="ovrride['price']" value="0">
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-flat" id="toggle-create-row">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-warning btn-flat" id="toggle-remove-row">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div> --}}
