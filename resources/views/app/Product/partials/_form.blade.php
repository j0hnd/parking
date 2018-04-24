<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">General Info</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab">Prices</a></li>
            <li class=""><a href="#tab_3" data-toggle="tab">Services</a></li>
        </ul>

        <div class="tab-content">
            {{-- general information --}}
            <div class="tab-pane active" id="tab_1">
                @include('app.Product.partials._general-info')
            </div>

            {{-- prices --}}
            <div class="tab-pane" id="tab_2">
                @include('app.Product.partials._prices')
            </div>

            {{-- services --}}
            <div class="tab-pane" id="tab_3">
                @include('app.Product.partials._services')
            </div>
        </div>
    </div>
</div>