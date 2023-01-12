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
                        Products
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{route('admin.products.create')}}"
                            class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            Add Products
                        </a>
                         <a class="btn btn-info " href="{{route('admin.products.exportData')}}">Export</a>
                         <a class="btn btn-info " href="{{route('admin.products.importData')}}">Import</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <form>
                <div class="row">
                    <div class="form-group col-4">
                        <label>Stock</label>
                        <select class="form-control" name="stock">
                            <option value="" @if($stock == "") selected @endif>Select</option>
                            <option value="stock" @if($stock == "stock") selected @endif>Stock</option>
                            <option value="outofstock" @if($stock == "outofstock") selected @endif>Out of Stock</option>

                        </select>
                    </div>

                    <div class="form-group col-4">
                        <label>Price</label>
                        <select class="form-control" name="price">
                            <option value="" @if($price == "") selected @endif>Select</option>
                            <option value="min" @if($price == "min") selected @endif>Min Price</option>
                            <option value="max" @if($price == "max") selected @endif>Max</option>

                        </select>
                    </div>
                    <div class="form-group col-4">
                        <button type="submit" class="btn btn-primary mt-4" >Filter</button>
                    </div>
                </div>
            </form>
            <div class="row mt-2">

                <div class="col-6">
                    <button class="btn btn-danger delete-all" data-token="{{csrf_token()}}">Delete</button>
                </div>

            </div>
            <br/>
            <div id="kt_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <table
                class="table producttable table-striped- table-bordered table-hover table-checkable datatable"
                id="products">
                @csrf
                <thead>
                    <tr>
                        <th><input type="checkbox" name="selectall"
                         class="form-control custom-checkbox selectall" style="height: 15px;"></th>
                         <th>ID</th>
                         <th>Name</th>
                         <th>Shop</th>
                         <th>Price</th>
                         <th>Stock</th>
                         <th>Image</th>
                         <th>Action</th>

                     </tr>
                 </thead>
                 <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td><input type="checkbox" name="single[{{$product->id}}]"
                         data-id="{{$product->id}}"
                         class="form-control custom-checkbox singleselect" style="height: 15px;">
                     </td>
                     <td>{{$product->id}}</td>
                     <td>{{$product->name}}</td>
                     <td>{{$product->shop->name}}</td>
                     <td>{{$product->price}}</td>
                     <td>{{$product->stock}}</td>
                     <td>@if($product->image)<img src="{{$product->image}}" width="200" height="200" > @endif</td>


                     <td>
                        <a class="btn waves-effect waves-light btn-primary"
                        href="{{route('admin.products.edit',$product->id)}}"><i
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

    $(document).ready(function () {


        $('#product').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });



        $('.delete-all').on('click', function (e) {
            var idsArr = [];
            $(".singleselect:checked").each(function () {
                idsArr.push($(this).attr('data-id'));

            });
            var strIds = idsArr.join(",");
            $.ajax({
                type: "POST",
                url: "{{route('admin.products.deleteall')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: 'ids=' + strIds,

                success: function (data) {
                    if (data.status === 'success') {
                        swal({
                            title: "Success",
                            text: "Product Deleted Successfully",
                            type: "success"
                        }, function () {
                            window.location = "{{route('admin.products.index')}}"
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



