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

    public function dashboard(){
        return view('backend.applicant.dashboard');
    }

    
    // public function student_application_form(Request $request)
    // {
    //     $query = Applicant::with(['parents','interview']);

    //     if ($request->has('search') && $request->search) {
    //         $query->where('first_name', 'like', "%{$request->search}%")
    //             ->orWhere('last_name', 'like', "%{$request->search}%");
    //     }

    //     $perPage = $request->get('per_page', 5);
    //     $applicants = $query->paginate($perPage);

    //     // Log::info('Applicants', ['applicants' => $applicants]);

    //     if ($request->ajax()) {
    //         $html = view('backend.applicant.partials.table', compact('applicants'))->render();
    //         return response()->json(['html' => $html]);
    //     }

    //     return view('backend.applicant.index', compact('applicants'));
    // }

    public function student_application_form(Request $request)
    {
        try{
                $search = $request->get('search');
                $perPage = $request->get('per_page', 5);

                $applicants = $this->applicantrepository->getAllApplicants($search, $perPage);

                Log::info('listing of Applicants', ['applicants' => $applicants]);

                if ($request->ajax()) {
                    $html = view('backend.applicant.partials.table', compact('applicants'))->render();
                    return response()->json(['html' => $html]);
                }

                return view('backend.applicant.index', compact('applicants'));
        } catch(\Exception $e){
            return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicants.');
        }
      
    }


   public function application_form(){
       return view('backend.applicant.application_form');
   }

   public function parent_contract(){
       return view('backend.applicant.parent_contract');
   }

   

    public function calender(){
        return view('backend.applicant.calender');
    }

    public function schedule_interview($id,Request $request)
    {
        try{ 
             $applicant = $this->applicantrepository->getApplicantById($id);

            //  Log::info('Applicant details for scheduling interview', ['applicant' => $applicant]);

             return view('backend.applicant.schedule_interview',compact('applicant'));
        } catch(\Exception $e){
           return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicant.');
        }
       
    }

    // public function fetch_interview_slots(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'interview_date' => 'required|date',
    //             'start_time' => 'required',
    //             'end_time' => 'required',
    //         ]);

    //         $slots = $this->applicantrepository->getSlotsBetween(
    //             $validated['interview_date'],
    //             $validated['start_time'],
    //             $validated['end_time']
    //         );

    //         Log::info('Available interview slots', ['slots' => $slots]);

    //         $html = view('backend.applicant.partials.available_slots', compact('slots'))->render();

    //         return response()->json([
    //             'success' => true,
    //             'html' => $html,
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('Failed to fetch interview slots', ['error' => $e->getMessage()]);
    //         return response()->json(['success' => false, 'message' => 'Something went wrong.']);
    //     }
    // }

    public function fetch_interview_slots(Request $request)
    {
        try {
            $validated = $request->validate([
                'interview_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            // Get booked slots
            $bookedSlots = $this->applicantrepository->getSlotsBetween(
                $validated['interview_date'],
                $validated['start_time'],
                $validated['end_time']
            );

            // Generate all possible time slots for the day
            $allSlots = $this->generateTimeSlots(
                $validated['start_time'],
                $validated['end_time']
            );

            // Create a map of booked slots for easy lookup
            $bookedSlotsMap = [];
            foreach ($bookedSlots as $slot) {
                $bookedSlotsMap[$slot->time_slot] = $slot;
            }

            // Separate available and booked slots
            $availableSlots = [];
            $scheduledSlots = [];

            foreach ($allSlots as $slotTime => $slotLabel) {
                if (isset($bookedSlotsMap[$slotTime])) {
                    $scheduledSlots[$slotTime] = $bookedSlotsMap[$slotTime];
                } else {
                    $availableSlots[$slotTime] = $slotLabel;
                }
            }

            Log::info('Interview slots processed', [
                'date' => $validated['interview_date'],
                'booked' => count($scheduledSlots),
                'available' => count($availableSlots)
            ]);

            $html = view('backend.applicant.partials.available_slots', [
                'scheduledSlots' => $scheduledSlots,
                'availableSlots' => $availableSlots,
                'selectedDate' => $validated['interview_date']
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch interview slots', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
    }

    private function generateTimeSlots($startTime, $endTime, $interval = '1 hour')
    {
        $slots = [];
        
        $start = \Carbon\Carbon::createFromFormat('H:i A', $startTime);
        $end = \Carbon\Carbon::createFromFormat('H:i A', $endTime);
        
        while ($start <= $end) {
            $slotTime = $start->format('h:i A');
            $slotEnd = $start->copy()->addHour()->format('h:i A');
            $slotLabel = $slotTime . ' - ' . $slotEnd;
            
            $slots[$slotTime] = $slotLabel;
            $start->addHour();
        }
        
        return $slots;
    }

    public function assign_interview_slot(Request $request)
    {
        
        try{

            Log::info('request for assign interview slot', ['request' => $request->all()]);

            $validated =  $request->validate([
                'applicant_id'  => 'required|exists:applicants,id',
                'interview_mode' => 'required|in:online,offline',
                'interview_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'interview_link' => 'nullable|required_if:interview_mode,online',
                'interview_location' => 'nullable|required_if:interview_mode,offline',
            ]);

            // Extra validation: meeting_link required if online, location if offline
            if ($validated['interview_mode'] === 'online' && empty($validated['interview_link'])) {
                return response()->json(['success' => false, 'message' => 'Meeting link is required for online mode.']);
            }

            if ($validated['interview_mode'] === 'offline' && empty($validated['interview_location'])) {
                return response()->json(['success' => false, 'message' => 'Interview location is required for offline mode.']);
            }

            $validated['interview_time'] = $request->start_time . ' - ' . $request->end_time;

            $this->applicantrepository->saveInterviewSchedule($validated);

            return response()->json([
                'success' => true,
                'message' => 'Interview slot assigned successfully!'
            ]);
        } catch(\Exception $e){
            Log::error('Failed to assign interview slot', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

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
                ->route('applicant.student_application_form')
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

        //    Log::info('Applicant info details', ['applicant' => $applicant]);

            return view('backend.applicant.view-applicant-info', compact('applicant'));
        }catch(\Exception $e){
            return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicant.');
        }
       
    }

    public function edit_applicant($id){

        try {
            $applicant = $this->applicantrepository->getApplicantById($id);
            if (!$applicant) {
                return redirect()->back()->with('error', 'Applicant not found');
            }

            Log::info("Editing applicant with ID: {$id}");
            Log::info('Applicant edit details', ['applicant' => $applicant]);

            return view('backend.applicant.edit-applicant', compact('applicant'));
        } catch (\Exception $e) {
            Log::error("Error editing applicant: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function update_applicant(ApplicantUpdateRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();

            $this->applicantrepository->updateApplicant($id, $validatedData);

            Log::info("Applicant updated successfully", ['applicant_id' => $id]);

            return redirect()->route('applicant.edit_applicant', $id)->with('success', 'Applicant updated successfully.');
        } catch (\Exception $e) {
            Log::error("Applicant update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update applicant.');
        }
    }

    public function custom_applicant_chart(){
        return view('backend.applicant.custom-applicant-chart');
    }

    public function contacts(){
        return view('backend.applicant.contacts');
    }

    public function contact_info(){
        return view('backend.applicant.contact-info');
    }

    public function high_school_contact(){
        return view('backend.applicant.high-school-contact');
    }
}
