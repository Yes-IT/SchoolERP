<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Group\FeesGroupStoreRequest;
use App\Http\Requests\Fees\Group\FeesGroupUpdateRequest;
use App\Interfaces\Fees\FeesGroupInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FeesGroupController extends Controller
{
    private $repo;

    function __construct(FeesGroupInterface $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        $data['title']              = ___('fees.fees_group');
        $data['fees_groups'] = $this->repo->getPaginateAll();
        #print_r($data['fees_groups']);die;
        return view('backend.fees.group.index', compact('data'));

    }

    public function create()
    {
        $data['title']              = ___('fees.fees_group');
        return view('backend.fees.group.create', compact('data'));

    }

    public function store(FeesGroupStoreRequest $request)
    {
       
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-group.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_group']        = $this->repo->show($id);
        $data['title']       = ___('fees.fees_group');
        return view('backend.fees.group.edit', compact('data'));
    }

   public function update(FeesGroupUpdateRequest $request, $id)
{
    try {
        // Log the incoming request data and ID
        Log::info('FeesGroup Update Request Received', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        // Call the repository update method
        $result = $this->repo->update($request, $id);

        // Log the result returned by repository
        Log::info('FeesGroup Update Result', [
            'id' => $id,
            'result' => $result
        ]);

        // Handle response
        if ($result['status']) {
            return redirect()->route('fees-group.index')->with('success', $result['message']);
        }

        // Log failure explicitly
        Log::warning('FeesGroup Update Failed', [
            'id' => $id,
            'message' => $result['message']
        ]);

        return back()->with('danger', $result['message']);

    } catch (\Throwable $e) {
        // Log any exceptions that may occur
        Log::error('FeesGroup Update Exception', [
            'id' => $id,
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()->with('danger', 'An error occurred: ' . $e->getMessage());
    }
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
    $query = $request->get('name');

    $groups = \App\Models\Fees\FeesGroup::query()
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->orderBy('id', 'desc')
        ->get(['id', 'name', 'description', 'status', 'online_admission_fees']); // only needed columns

    return response()->json($groups);
}
}
