<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Product Information</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab">Contact Details</a></li>
            <li class=""><a href="#tab_3" data-toggle="tab">Prices</a></li>
            <li class=""><a href="#tab_4" data-toggle="tab">Closure Dates</a></li>
            <li class=""><a href="#tab_5" data-toggle="tab">Services</a></li>
        </ul>

        <div class="tab-content">
            {{-- general information --}}
            <div class="tab-pane active" id="tab_1">
                @include('app.Product.partials._general-info')
            </div>

            {{-- contact details --}}
            <div class="tab-pane" id="tab_2">
                @include('app.Product.partials._contact-details')
            </div>

            {{-- prices --}}
            <div class="tab-pane" id="tab_3">
                @include('app.Product.partials._prices')
            </div>

            {{-- closure dates --}}
            <div class="tab-pane" id="tab_4">
                @include('app.Product.partials._closure')
            </div>

            {{-- services --}}
            <div class="tab-pane" id="tab_5">
                @include('app.Product.partials._services')
            </div>
        </div>
    </div>
</div>
