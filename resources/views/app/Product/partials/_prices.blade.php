<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            <label class="col-sm-3 control-label">Price Category</label>

            <div class="col-sm-8">
                <select name="category_id" id="category-id" class="form-control">
                    @if($priceCategories->count())
                        @foreach($priceCategories->get() as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Price Start Day</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="price_start_day">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Price End Day</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="price_start_end">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Price Month</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="price_month">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Price Year</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="price_year">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Price Value</label>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="price_value">
            </div>
        </div>

    </div>
</div>