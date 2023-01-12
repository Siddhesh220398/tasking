@extends('admin.main')
@section('header')
    <meta http-equiv="refresh" content="900">
@endsection

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <br>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="kt-portlet">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-body">
                                <h1 style="color: #040A82;">
                                    Total Shops
                                </h1>
                                <h3 class="mt-4" style="color: #040A82;">
                                {{\App\Shop::count()}}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="kt-portlet">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-body">
                                <h1 style="color: #040A82;">
                                    Total Products
                                </h1>
                                <h3 class="mt-4" style="color: #040A82;">
                                    {{\App\Models\Products::count()}}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="kt-portlet">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-body">
                                <h1 style="color: #040A82;">
                                    Pattern Output
                                </h1>
                                <h3 class="mt-4" style="color: #040A82;">
                                    @php
                                        $alpha = range('A', 'Z');
                                        $xy=1;
                                        for($i=0; $i<4; $i++){
                                        for($k=4-1; $k>=$i; $k--){
                                        echo " &nbsp; ";
                                        }
                                        for($j=0; $j<=$i; $j++){
                                        if($i%2 == 0){
                                        echo $alpha[$xy-1].' ';
                                        }else{
                                        echo $xy .' ';
                                        }
                                        $xy++;
                                        }
                                        echo "<br>";
                                        }
                                    @endphp
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
