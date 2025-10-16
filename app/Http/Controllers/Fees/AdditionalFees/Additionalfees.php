<?php

namespace App\Http\Controllers\Fees\AdditionalFees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Assign\FeesAssignStoreRequest;
use App\Http\Requests\Fees\Assign\FeesAssignUpdateRequest;
use App\Http\Requests\Fees\Assign\FeesImportRequest;
use App\Imports\FeesImport;
use App\Interfaces\Fees\FeesTypeInterface;
use App\Interfaces\Fees\FeesGroupInterface;
use App\Interfaces\Fees\FeesAssignInterface;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Fees\FeesMasterRepository;
use App\Repositories\GenderRepository;
use App\Repositories\StudentInfo\StudentCategoryRepository;
use App\Repositories\StudentInfo\StudentRepository;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\ImportValidationException;

class AdditionalFees extends Controller
{
    private $repo;
    private $typeRepo;
    private $groupRepo;
    private $feesMasterRepo;
    private $genderRepo;
    private $categoryRepo;
    private $classRepo;
    private $sectionRepo;
    private $classSetupRepo;
    private $studentRepo;

    function __construct(
        FeesAssignInterface $repo,
        FeesTypeInterface $typeRepo,
        FeesGroupInterface $groupRepo,
        FeesMasterRepository $feesMasterRepo,
        GenderRepository $genderRepo,
        StudentCategoryRepository $categoryRepo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        ClassSetupRepository $classSetupRepo,
        StudentRepository $studentRepo
    ) {
        $this->repo = $repo;
        $this->typeRepo = $typeRepo;
        $this->groupRepo = $groupRepo;
        $this->feesMasterRepo = $feesMasterRepo;
        $this->genderRepo = $genderRepo;
        $this->categoryRepo = $categoryRepo;
        $this->classRepo = $classRepo;
        $this->sectionRepo = $sectionRepo;
        $this->classSetupRepo = $classSetupRepo;
        $this->studentRepo = $studentRepo;
    }

    public function index()
    {

        return view('backend.fees.additional-fees.index');
    }

public function groupshow()
{
    $feesGroups = \App\Models\Fees\FeesGroup::all();

    return view('backend.fees.group.index', compact('feesGroups'));
}

// public function groupedit($id)
// {
//     $group = \App\Models\Fees\FeesGroup::findOrFail($id);

//     \Log::info('groupedit called', ['id' => $id, 'group' => $group]);

//     if (request()->ajax()) {
//         return response()->json($group);
//     }

//     return response()->json([
//         'error' => 'Not an AJAX request',
//         'group' => $group
//     ], 200);
// }


// public function groupupdate(Request $request, $id)
// {
//     \Log::info('groupupdate called', ['id' => $id, 'data' => $request->all()]);

//     $group = \App\Models\Fees\FeesGroup::findOrFail($id);
//     $group->update($request->only(['name', 'description']));

//     return redirect()->back()->with('success', 'Fees Group updated successfully!');
// }

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:500',
    ]);

    $group = \App\Models\Fees\FeesGroup::findOrFail($id);
    $group->name = $request->name;
    $group->description = $request->description;
    $group->save();

    return response()->json([
        'success' => true,
        'message' => 'Fees group updated successfully',
        'data' => $group
    ]);
}






    public function feestypeshow()
    {

        return view('backend.fees.type.index');
    }


    public function feesmastershow()
    {

        return view('backend.fees.master.index');
    }


    public function feesAssign()
    {

        return view('backend.fees.assign.index');
    }


    public function feesStatus()
    {

        return view('backend.fees.fees-status.index');
    }
    
 

       public function    installment()
    {

        return view('backend.fees.master.installment');
    }  
    
    
   


          public function     feesmasteredit()
    {

        return view('backend.fees.master.edit');
    }










}
