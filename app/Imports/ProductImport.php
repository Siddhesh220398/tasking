<?php

namespace App\Imports;

use App\Shop;
use App\Models\Products;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{

 public function collection(Collection $rows)
 {
   foreach($rows as $row){
      $shop_name= Shop::where('name',$row['shop'])->first();
      if($shop_name){
         Products::updateOrCreate(['name'=>$row['name'],'shop_id'=>$shop_name->id],['name'=>$row['name'],'price'=>$row['price'],'stock'=>$row['stock'],'shop_id'=>$shop_name->id]);
      }
   }
}
}
