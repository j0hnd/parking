<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Carpark</a></li>
            <li class=""><a href="#tab_2" data-toggle="tab">Company</a></li>
        </ul>

        <div class="tab-content">
            {{-- carpark information --}}
            <div class="tab-pane active" id="tab_1">
                @include('app.Carpark.partials._carpark_form')
            </div>

            {{-- company --}}
            <div class="tab-pane" id="tab_2">
                @include('app.Carpark.partials._company_info')
            </div>
        </div>
    </div>
</div>
