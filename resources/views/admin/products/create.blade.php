@extends('admin.main')
@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <br>
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Add Product
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <div class="kt-portlet__head-actions">
                                    <a href="{{route('admin.products.index')}}"
                                    class="btn btn-success">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="productsFrm">
                        @method('POST')
                        @csrf
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name">

                                    </div>


                                    <div class="form-group col-4">
                                        <label>Price</label>
                                        <input type="text" class="form-control numbersOnly" id="price" name="price"
                                        maxlength="10"
                                        onkeypress="return isNumber(event)"/>
                                        @foreach($errors->get('price') as $eroor)
                                        <span class="help-block">{{ $error}}</span>
                                        @endforeach
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>


                                    <div class="form-group col-4">
                                        <label>Stock</label>
                                         <select class="form-control" name="stock">
                                            <option value="stock">Stock</option>
                                            <option value="outofstock">Out of Stock</option>
                                            
                                        </select>
                                    </div>




                                    <div class="form-group col-4">
                                        <label>Product Image </label>
                                        <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*">
                                    </div>


                                    <div class="form-group col-3">
                                        <label>Shop Name </label>
                                        <!--end::Label-->
                                        <select class="form-control" name="shop_id">
                                            <option value="">--Select Shop --</option>
                                            @if(!empty($shops))
                                            @foreach($shops as $shop)
                                            <option
                                            value="{{ $shop->id }}">{{ $shop->name   }}</option>
                                            @endforeach
                                            @endif
                                        </select>

                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12  text-center form-group">
                                    <button type="submit" class="btn btn-primary submit">Save</button>

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

    $(document).ready(function () {
        $(".productsFrm").validate({
            rules:
            {
                name:
                {
                    required: true
                },
                price:
                {
                    required: true
                },
                stock:
                {
                    required: true
                },
                shop_id:
                {
                    required: true
                },

            },
            messages:
            {
                name:
                {
                    required: "Name is required"
                },
                stock:
                {
                    required: 'Stock is required'
                },

                price:
                {
                    required: 'Price is required'
                },
                shop_id:
                {
                    required: 'Select Shop'
                },


            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
                $('.help-block').css('color', 'red');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $(".submit").click(function (event) {
                // alert('he');
                event.preventDefault();
                if ($(".productsFrm").valid()) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.products.store')}}",
                        data: new FormData($('.productsFrm')[0]),
                        processData: false,
                        contentType: false,
                        cache: false,

                        success: function (data) {
                            if (data.status === 'success') {
                                swal({
                                    title: "Success",
                                    text: "Product Created Successfully",
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

                            }else if (data.status === 'productExists') {
                                swal({
                                    title: "Error",
                                    text: "Opps..! Product is already exists.",
                                    type: "error"
                                });

                            }


                        }
                    });
                } else {
                    event.preventDefault();
                }
            });

    });
</script>
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
@stop

