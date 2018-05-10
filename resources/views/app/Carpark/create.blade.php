@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up Carpark Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="carpark-form" class="form-horizontal" method="post" action="{{ url('/admin/carpark') }}" enctype="multipart/form-data">
                    @include('app.Carpark.partials._form')

                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right toggle-cancel" data-back="{{ url('/admin/carpark') }}" style="margin-left: 7px;">Cancel</button>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            var searchRequest = null;

            $('#countries').select2({ placeholder: '-- Country --' });

            $('#company-name').autocomplete({
                maxLength: 5,
                source: function(request, response) {
                    if (searchRequest !== null) {
                        searchRequest.abort();
                    }
                    searchRequest = $.ajax({
                        url: '{{ url('/autocomplete/company') }}',
                        method: 'post',
                        dataType: "json",
                        data: { term: request.term, _token: '{{ csrf_token() }}' },
                        success: function(data) {
                            searchRequest = null;
                            response($.map(data.items, function(item) {
                                return {
                                    value: item.name,
                                    label: item.name
                                };
                            }));
                        }
                    }).fail(function() {
                        searchRequest = null;
                    });
                },
                appendTo: '#company-name-wrapper'
            });
        });
    </script>
@stop
