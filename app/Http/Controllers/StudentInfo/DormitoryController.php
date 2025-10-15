<?php

namespace App\Http\Controllers\StudentInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\StudentInfo\ParentGuardianRepository;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianStoreRequest;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianUpdateRequest;
use  App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\DB;


class DormitoryController extends Controller
{
    private $repo;

    function __construct(ParentGuardianRepository $repo)
    {
        $this->repo       = $repo;
    }

  public function index()
{
       $it_assets = DB::table('it_assets')->get();
   

    return view('backend.dormitory.index', compact('it_assets'));
}
 
public function itassets(Request $request)
{
    $assetType = $request->input('asset_type'); // comes from dropdown

    // Start query
    $query = DB::table('it_assets');

    // Apply filter if selected
    if ($assetType && $assetType !== 'all') {
        $query->where('asset_type', $assetType);
    }

    // Execute query
    $it_assets = $query->get();

    // Handle AJAX request
    if ($request->ajax()) {
        return view('backend.dormitory.it-assets.it-assets-list', compact('it_assets'))->render();
    }

    // Normal page load
    return view('backend.dormitory.it-assets.index', compact('it_assets'));
}


   public function filterassettype(Request $request)
  {
    $type = $request->query('type');

    $query = DB::table('it_assets');
    if (!empty($type)) {
        $query->where('asset_type', $type);
    }

    $it_assets = $query->get();

    
    return view('backend.dormitory.It-assets.it-assets-list', compact('it_assets'));
}

public function requestedassets(){

     return view('backend.dormitory.requested_assets.index');

}
 public function assignedassets(){
       return view('backend.dormitory.assigned_assets.index');

 }

 public function issuereports(){
    return view('backend.dormitory.issue_report.index');
 }



  public function  returnassets(){
    return view('backend.dormitory.return-assets.index');
 }

 

  public function  procurement(){
    return view('backend.dormitory.procurement.index');
 }

}



