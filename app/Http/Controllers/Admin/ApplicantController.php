<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Applicant\ApplicantInterface;
use App\Http\Requests\Applicant\{ApplicantStoreRequest,ApplicantUpdateRequest};
use Illuminate\Support\Facades\{DB,Log};
use App\Models\Applicant\{Applicant,ApplicantParent,ApplicationProcessing,ApplicantCamps,ApplicantCheckList};

class ApplicantController extends Controller
{
    protected $applicantrepository;

    public function __construct(ApplicantInterface $applicantrepository){
        $this->applicantrepository = $applicantrepository;
    }

    // public function index(){
    //     $applicants = $this->applicantrepository->getAllApplicants();
    //     return view('backend.applicant.index', compact('applicants'));
    // }

    
    public function index(Request $request)
    {
        $query = Applicant::with('parents');

        if ($request->has('search') && $request->search) {
            $query->where('first_name', 'like', "%{$request->search}%")
                ->orWhere('last_name', 'like', "%{$request->search}%");
        }

        $perPage = $request->get('per_page', 10);
        $applicants = $query->paginate($perPage);

        // Log::info('Applicants', ['applicants' => $applicants]);

        if ($request->ajax()) {
            $html = view('backend.applicant.partials.table', compact('applicants'))->render();
            return response()->json(['html' => $html]);
        }

        return view('backend.applicant.index', compact('applicants'));
    }



    public function dashboard(){
        return view('backend.applicant.dashboard');
    }

    public function calender(){
        return view('backend.applicant.calender');
    }

    public function schedule_interview(){
        return view('backend.applicant.schedule_interview');
    }

    public function profile(){
        return view('backend.applicant.profile');
    }

    public function add_new_applicant()
    {
        $lastApplicant = Applicant::orderBy('id', 'desc')->first();
        // Generate next custom_id
        if (!$lastApplicant || !$lastApplicant->custom_id) {
            $nextId = 'APPLI0001';
        } else {
            // Extract the number part and increment
            $number = (int) filter_var($lastApplicant->custom_id, FILTER_SANITIZE_NUMBER_INT);
            $nextId = 'APPLI' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
        }

        // Log::info('Next custom_id: ' . $nextId);

        return view('backend.applicant.add-new-applicant', compact('nextId'));
    }

    public function store_applicant(ApplicantStoreRequest $request)
    {
        // Log::info('request for store applicant', ['request' => $request->all()]);
        try {
            $applicant = $this->applicantrepository->createApplicant($request->validated());
            return redirect()
                ->route('applicant.index')
                ->with('success', 'Applicant created successfully.');
        } catch (\Throwable $e) {
            Log::error('Error in store_applicant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('applicant.add_new_applicant')
                ->with('error', 'Failed to create applicant.');
        }
    }

    public function view_applicant_info($id){
        try{
            $applicant = $this->applicantrepository->getApplicantById($id);

           Log::info('Applicant info details', ['applicant' => $applicant]);

            return view('backend.applicant.view-applicant-info', compact('applicant'));
        }catch(\Exception $e){
            return redirect()->route('applicant.index')->with('error', 'Failed to get applicant.');
        }
       
    }

    public function edit_applicant(){
        return view('backend.applicant.edit-applicant');
    }

    public function custom_applicant_chart(){
        return view('backend.applicant.custom-applicant-chart');
    }

    public function contacts(){
        return view('backend.applicant.contacts');
    }
}
