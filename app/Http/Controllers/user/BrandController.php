<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ElectronicComponent;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function getBrandList(){
        $brands = Brand::where('status',1)->get(['id as value','name as display'])->toArray();
        $components = ElectronicComponent::where('electronics_components.status',1)
            ->leftjoin('component_details as cd', 'electronics_components.id','cd.component_id')
            ->get(['cd.*','electronics_components.component_name']);
//        dd($components);
        $allComponents = [];
        if(count($components)>0){
            foreach ($components as $component){
                $allComponents[$component->component_name][] = array('value'=>$component->id.'@'.$component->details,'display'=>$component->details);
            }
        }
    $allComponents['brands'] =$brands;
        return response()->json($allComponents);
    }
}
