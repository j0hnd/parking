<div class="row">
    <div class="col-md-12">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th>Price Category</th>
                    <th>Price Start Day</th>
                    <th>Price End Day</th>
                    <th>Price Month</th>
                    <th>Price Year</th>
                    <th style="width: 100px;">Price Value</th>
                    <th></th>
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
                            <select name="prices[price_start_day][1][]" class="form-control price_start_day" id="">
                                <option value="" readonly>-- Days --</option>
                                @foreach ($days as $day)
                                    @if($day == $prices->price_start_day)
                                    <option value="{{ $day }}" selected>{{ $day }}</option>
                                    @else
                                    <option value="{{ $day }}">{{ $day }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_end_day][2][]" class="form-control price_end_day" id="">
                                <option value="" readonly>-- Days --</option>
                                @foreach ($days as $day)
                                    @if($day == $prices->price_end_day)
                                    <option value="{{ $day }}" selected>{{ $day }}</option>
                                    @else
                                    <option value="{{ $day }}">{{ $day }}</option>
                                    @endif
                                @endforeach
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
                        <td><input type="number" name="prices[price_value][5][]" class="form-control" placeholder="Price Value" value="{{ $prices->price_value }}"></td>
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
                        </td>
                        <td>
                            <select name="prices[price_start_day][1][]" class="form-control price_start_day" id="">
                                <option value="" readonly>-- Days --</option>
                                @foreach ($days as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="prices[price_end_day][2][]" class="form-control price_end_day" id="">
                                <option value="" readonly>-- Days --</option>
                                @foreach ($days as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
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
                        <td><input type="number" name="prices[price_value][5][]" class="form-control" placeholder="Price Value" value="0"></td>
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
</div>