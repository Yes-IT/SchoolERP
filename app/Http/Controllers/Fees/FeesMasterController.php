<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Master\FeesMasterStoreRequest;
use App\Http\Requests\Fees\Master\FeesMasterUpdateRequest;
use App\Interfaces\Fees\FeesGroupInterface;
use App\Interfaces\Fees\FeesMasterInterface;
use App\Interfaces\Fees\FeesTypeInterface;
use App\Repositories\Academic\ClassesRepository;
use Illuminate\Http\Request;

class FeesMasterController extends Controller
{
    private $repo;
    private $type;
    private $group;
    private $classRepo;

    function __construct(FeesMasterInterface $repo,FeesTypeInterface $type,FeesGroupInterface $group, ClassesRepository $classRepo)
    {
        $this->repo       = $repo; 
        $this->type       = $type; 
        $this->group      = $group; 
        $this->classRepo  = $classRepo; 
    }
    
    public function index()
    {
        $data['title']        = ___('fees.fees_master');
         $fees_types   = \App\Models\Fees\FeesType::all();
           $fees_groups = \App\Models\Fees\FeesGroup::all();
            
         
        
        $data['fees_masters'] = $this->repo->getPaginateAll();
        return view('backend.fees.master.index', compact('data','fees_types','fees_groups'));
    }
    
    public function getAllTypes(Request $request)
    {
        $types = $this->repo->groupTypes($request);
        return view('backend.fees.master.fees-types', compact('types'))->render();
    }

    public function create()
    {
        $data['title']        = ___('fees.fees_master');
          $fees_types   = $this->type->all();
          $fees_groups  = $this->group->all();
        return view('backend.fees.master.create', compact('data','fees_types','fees_groups'));
    }

    public function store(FeesMasterStoreRequest $request)
    {
        // dd($request->all());
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-master.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_masters'] = \App\Models\Fees\FeesMaster::findOrFail($id);
        $data['title']        = ___('fees.fees_master');
           $fees_types   = \App\Models\Fees\FeesType::all();
           $fees_groups = \App\Models\Fees\FeesGroup::all();
        $data['fees_groups']  = $this->group->all();
        // dd($data);
        return view('backend.fees.master.edit', compact('data','fees_types','fees_groups'));
    }
    

    public function update(FeesMasterUpdateRequest $request, $id)
    {
          $data['fees_masters'] = \App\Models\Fees\FeesMaster::findOrFail($id);
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-master.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        
        $result = $this->repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;      
    }
    public function search(Request $request)
{
    $query = $request->input('query');

    $data['fees_masters'] = \App\Models\Fees\FeesMaster::with(['group', 'type'])
        ->when($query, function ($q) use ($query) {
            $q->whereHas('group', function ($q2) use ($query) {
                $q2->where('name', 'like', "%{$query}%");
            })->orWhereHas('type', function ($q3) use ($query) {
                $q3->where('name', 'like', "%{$query}%");
            });
        })
        ->orderBy('id', 'desc')
        ->get();

    // Return partial HTML for table rows
    $html = view('backend.fees.master.master-list', compact('data'))->render();

    return response()->json(['html' => $html]);
}
}
