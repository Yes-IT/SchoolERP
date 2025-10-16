<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Type\FeesTypeStoreRequest;
use App\Http\Requests\Fees\Type\FeesTypeUpdateRequest;
use App\Interfaces\Fees\FeesTypeInterface;
use Illuminate\Http\Request;

class FeesTypeController extends Controller
{
    private $repo;

    function __construct(FeesTypeInterface $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        $data['title']              = ___('fees.fees_type');
        $data['fees_types'] = $this->repo->getPaginateAll();

        return view('backend.fees.type.index', compact('data'));

    }

    public function create()
    {
        $data['title']              = ___('fees.fees_type');
        return view('backend.fees.type.create', compact('data'));

    }

    public function store(FeesTypeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-type.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_type']        = $this->repo->show($id);
        $data['title']       = ___('fees.fees_type');
        return view('backend.fees.type.edit', compact('data'));
    }

    public function update(FeesTypeUpdateRequest $request)
    {
        #print_r($request->all());die;
        $id = $request->edit_fee_id;
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-type.index')->with('success', $result['message']);
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

    public function filter(Request $request)
{
    $category = $request->input('category');

    $query = \App\Models\Fees\FeesType::query();

    if (!empty($category)) {
        $query->where('category', $category);
    }

    $feesTypes = $query->get();

    // Return JSON so JS can re-render table
    return response()->json($feesTypes);
}
public function search(Request $request)
{
    $query = $request->get('query');

    $feesTypes = \App\Models\Fees\FeesType::when($query, function ($q) use ($query) {
        $q->where('name', 'like', "%{$query}%");
    })->get();

    // Build $data so the view's $data['fees_types'] works
    $data = ['fees_types' => $feesTypes];

    return response()->json([
        'html' => view('backend.fees.type.fees-type-table', compact('data'))->render()
    ]);
}

}
