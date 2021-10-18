<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;

class ShippingController extends Controller
{

    // methods for division section start
    public function DivisionView(){
        $divisions=ShipDivision::all();
        return view('backend.shipping.division.division_view',compact('divisions'));
    }

    public function DivisionStore(Request $request){

        $request->validate([
            'division_name' => 'required',
        ]);

        $division =new ShipDivision();
        $division->division_name = $request->division_name;
        $division->created_at=Carbon::now();
        $division->save();

        $notification = array(
            'message' => 'Division Add Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function DivisionEdit($id){
        $division = ShipDivision::find($id);
        return view('backend.shipping.division.division_edit',compact('division'));
    }

    public function DivisionUpdate(Request $request){

        $request->validate([
            'division_name' => 'required',
        ]);

        $division =ShipDivision::find($request->id);
        $division->division_name = $request->division_name;
        $division->updated_at=Carbon::now();
        $division->save();

        $notification = array(
            'message' => 'Division Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('manage.division')->with($notification);
    }

    public function DivisionDelete($id){

        ShipDivision::find($id)->delete();

        $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // methods for division section ends here

    public function DistrictView(){
        $divisions =ShipDivision::all();
        $districts= ShipDistrict::with('ShipDivision')->get();
        return view('backend.shipping.district.district_view',compact('districts','divisions'));
    }

    public function DistrictStore(Request $request){

        $request->validate([
             'division_id' => 'required',
             'district_name' => 'required'
         ]);
 
         ShipDistrict::insert([
         'division_id' => $request->division_id,
         'district' => $request->district_name,	
         ]);
 
         $notification = array(
             'message' => 'District Inserted Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->back()->with($notification);
 
     } // end method 
}
