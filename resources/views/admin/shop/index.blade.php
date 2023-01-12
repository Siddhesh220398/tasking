@extends('admin.main')
@section('content')
    {{--    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <br>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Shop
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{route('admin.shop.create')}}"
                                   class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add Shop
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-danger delete-all" data-token="{{csrf_token()}}">Delete</button>
                        </div>

                    </div>
                    <div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <table class="table shop table-striped- table-bordered table-hover table-checkable datatable"
                               id="shop">
                            @csrf
                            <thead>
                            <tr>
                                <th><input type="checkbox" name="selectall"
                                           class="form-control custom-checkbox selectall" style="height: 15px;"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td><input type="checkbox" name="single[{{$shop->id}}]" data-id="{{$shop->id}}"
                                               class="form-control custom-checkbox singleselect" style="height: 15px;">
                                    </td>
                                    <td>{{$shop->id}}</td>
                                    <td>{{$shop->name}}</td>
                                    <td>@if($shop->image)<img src="{{$shop->image}}" width="200" height="200" > @endif</td>
                                    <td>{{$shop->email}}</td>
                                    <td>{{$shop->address}}</td>
                                    
                                    <td><a class="btn waves-effect waves-light btn-primary"
                                           href="{{route('admin.shop.edit',$shop->id)}}"><i
                                                class="fa fa-pen   "></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.assign').click(function () {

            var shop_id = $(this).attr('uid');
            var url = $(this).attr('url');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: shop_id,
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    $('#assign_remove_' + shop_id).show();
                    $('#assign_add_' + shop_id).hide();
                }
            });
        });
        $('.unassign').click(function () {
            var shop_id = $(this).attr('ruid');
            var url = $(this).attr('url');


            $.ajax({
                url: url,
                type: "PUT",
                data: {
                    id: shop_id,
                    _token: '{{ csrf_token() }}'
                },
                cache: false,
                dataType: 'json',
                success: function (data) {
                    $('#assign_remove_' + shop_id).hide();
                    $('#assign_add_' + shop_id).show();
                }
            });
        });


        $(document).ready(function () {

            $('#shop').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $(document).on('click', '.selectall', function () {

                if ($(this).prop("checked") == true) {
                    console.log("Checkbox is checked.");
                    $('.singleselect').prop("checked", true);
                } else if ($(this).prop("checked") == false) {
                    $('.singleselect').prop("checked", false);
                }
            });
            $('.delete-all').on('click', function (e) {
                var idsArr = [];
                $(".singleselect:checked").each(function () {
                    idsArr.push($(this).attr('data-id'));

                });
                var strIds = idsArr.join(",");
                // alert($(this).data('token'))
                $.ajax({
                    type: "POST",
                    url: "{{route('admin.shop.deleteall')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'ids=' + strIds,

                    success: function (data) {
                        if (data.status === 'success') {
                            swal({
                                title: "Success",
                                text: "Shops Deleted Successfully",
                                type: "success"
                            }, function () {
                                window.location = "{{route('admin.shop.index')}}"
                            });

                        } else if (data.status === 'error') {
                            swal({
                                title: "Error",
                                text: "Opps..! Something Went to Wrong.",
                                type: "error"
                            });

                        }


                    }
                });
            });

        });
    </script>
@stop



@push('custom-scripts')

@endpush
