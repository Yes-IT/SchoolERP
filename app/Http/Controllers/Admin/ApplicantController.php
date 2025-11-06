<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Applicant\ApplicantInterface;
use App\Http\Requests\Applicant\{ApplicantStoreRequest,ApplicantUpdateRequest};
use Illuminate\Support\Facades\{DB,Log};
use App\Models\Applicant\{Applicant,ApplicantParent,ApplicationProcessing,ApplicantCamps,ApplicantCheckList};
use Carbon\Carbon;
use App\Enums\ApplicantStatus;
use App\Traits\ReturnFormatTrait;




class ApplicantController extends Controller
{
    use ReturnFormatTrait;
    protected $applicantrepository;

    public function __construct(ApplicantInterface $applicantrepository){
        $this->applicantrepository = $applicantrepository;
    }

    public function dashboard(){
        return view('backend.applicant.dashboard');
    }

    public function student_application_form(Request $request)
    {
        try{
                $search = $request->get('search');
                $perPage = $request->get('per_page', 5);

                $applicants = $this->applicantrepository->getAllApplicants($search, $perPage);

                Log::info('listing of Applicants', ['applicants' => $applicants]);

               if ($request->ajax() || $request->wantsJson()) {
                    $html = view('backend.applicant.partials.applicant_list', compact('applicants'))->render();
                    return response()->json(['html' => $html]);
                }


                return view('backend.applicant.index', compact('applicants'));
        } catch(\Exception $e){
            return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicants.');
        }
      
    }

    public function applicant_update_status(Request $request)
    {
        try {
            $validated = $request->validate([
                'applicant_id' => 'required|integer|exists:applicants,id',
                'status' => 'required|string',
            ]);

            // Map frontend status to your Enum
            $statusMap = [
                'approved' => ApplicantStatus::Accept,
                'rejected' => ApplicantStatus::NotAccepted,
                'priority_pending' => ApplicantStatus::PriorityPending,
                'pending' => ApplicantStatus::Pending,
            ];

            $mappedStatus = $statusMap[$validated['status']] ?? ApplicantStatus::Pending;

            Log::info('Updating applicant status', [
                'request' => $validated,
                'mapped_to' => $mappedStatus,
            ]);

            $applicant = Applicant::findOrFail($validated['applicant_id']);
            
            // Use the enum instance directly
            $applicant->update([
                'applicant_status' => $mappedStatus,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Applicant status updated successfully!',
                'new_status' => $mappedStatus->value, 
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating applicant status', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the status.',
            ], 500);
        }
    }


   public function application_form(){
       return view('backend.applicant.application_form');
   }

   public function parent_contract(){
       return view('backend.applicant.parent_contract');
   }

   

    // public function calender()
    // {
    //     $slots = ApplicationProcessing::select(
    //         'interview_date', 'start_time', 'end_time', 'interview_location', 'interview_mode'
    //     )->get();

    //     // Remove empty ones
    //     $slots = $slots->filter(function ($slot) {
    //         return $slot->interview_date && $slot->start_time && $slot->end_time;
    //     });

    //     Log::info('Cleaned interview slots', ['slots' => $slots]);;

    //     return view('backend.applicant.calender',compact('slots'));
    // }


    public function calender(Request $request)
    {
        try{
                $startOfWeek = now()->startOfWeek();
                $endOfWeek   = now()->endOfWeek();

                // Fetch all booked slots within this week
                $slots = ApplicationProcessing::whereBetween('interview_date', [$startOfWeek, $endOfWeek])
                    ->get();

                
                $timeSlots = [
                    ['start' => '10:00:00', 'end' => '10:59:59'],
                    ['start' => '11:00:00', 'end' => '11:59:59'],
                    ['start' => '12:00:00', 'end' => '12:59:59'],
                    ['start' => '13:00:00', 'end' => '13:59:59'],
                    ['start' => '14:00:00', 'end' => '14:59:59'],
                    ['start' => '15:00:00', 'end' => '15:59:59'],
                    ['start' => '16:00:00', 'end' => '16:59:59'],
                    ['start' => '17:00:00', 'end' => '17:59:59'],
                ];

                Log::info('Weekly calendar view slots', [
                    'range' => [$startOfWeek->toDateString(), $endOfWeek->toDateString()],
                    'slots' => $slots,
                    'count' => $slots->count(),
                ]);

            return view('backend.applicant.calender', compact('slots', 'timeSlots', 'startOfWeek', 'endOfWeek'));
        }   
        catch(\Exception $e){
            Log::error('Error in calender: ' . $e->getMessage());
            return redirect()->route('applicant.dashboard')->with('error', 'Failed to get interview slots.');
        }
    }

    // public function calendar_filter_slots(Request $request)
    // {
    //     $validated = $request->validate([
    //         'year' => 'required|integer',
    //         'month' => 'required|integer',
    //         'week' => 'required|string', 
    //     ]);

    //     try {
    //         // Split week range
    //         [$startDay, $endDay] = explode('-', $validated['week']);
    //         $startDay = (int) $startDay;
    //         $endDay = (int) $endDay;

    //         // Generate date range
    //         $startDate = Carbon::createFromDate($validated['year'], $validated['month'], $startDay);
    //         $endDate   = Carbon::createFromDate($validated['year'], $validated['month'], $endDay);

    //         Log::info('Filtering calendar slots', [
    //             'range' => [$startDate->toDateString(), $endDate->toDateString()],
    //         ]);

    //         // Fetch slots from repository
    //         $slots = $this->applicantrepository->getSlotsForWeek($startDate, $endDate);
    //         Log::info('Filtered slots in calendar filter slots', ['slots' => $slots]);

    //         $html = view('backend.applicant.partials.calendar-slots', [
    //             'slots' => $slots,
    //             'startOfWeek' => $startDate,
    //             'endOfWeek' => $endDate,
    //         ])->render();

    //         return response()->json(['html' => $html]);

    //     } catch (\Throwable $e) {
    //         Log::error('Error in calendar_filter_slots: ' . $e->getMessage());
    //         return response()->json(['error' => 'Invalid week range format.'], 400);
    //     }
    // }

    public function calendar_filter_slots(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer',
            'week' => 'required|string', 
        ]);

        try {
           
            [$startDay, $endDay] = explode('-', $validated['week']);
            $startDay = (int) $startDay;
            $endDay = (int) $endDay;

            $carbonMonth = $validated['month'] + 1;

            Log::info('Month conversion', [
                'received_month' => $validated['month'],
                'carbon_month' => $carbonMonth
            ]);

           
            $startDate = Carbon::createFromDate($validated['year'], $carbonMonth, $startDay)->startOfDay();
            $endDate   = Carbon::createFromDate($validated['year'], $carbonMonth, $endDay)->endOfDay();

            Log::info('Filtering calendar slots', [
                'year' => $validated['year'],
                'frontend_month' => $validated['month'],
                'backend_month' => $carbonMonth,
                'week' => $validated['week'],
                'range' => [$startDate->toDateString(), $endDate->toDateString()],
            ]);

            $slots = $this->applicantrepository->getSlotsForWeek($startDate, $endDate);
            
            Log::info('Final filtered slots', [
                'slots_count' => $slots->count(),
                'slots_dates' => $slots->pluck('interview_date')->toArray()
            ]);

            $timeSlots = [
                ['start' => '10:00:00', 'end' => '10:59:59'],
                ['start' => '11:00:00', 'end' => '11:59:59'],
                ['start' => '12:00:00', 'end' => '12:59:59'],
                ['start' => '13:00:00', 'end' => '13:59:59'],
                ['start' => '14:00:00', 'end' => '14:59:59'],
                ['start' => '15:00:00', 'end' => '15:59:59'],
                ['start' => '16:00:00', 'end' => '16:59:59'],
                ['start' => '17:00:00', 'end' => '17:59:59'],
            ];

            $html = view('backend.applicant.partials.calendar-slots', [
                'slots' => $slots,
                'startOfWeek' => $startDate,
                'endOfWeek' => $endDate,
                'timeSlots' => $timeSlots
            ])->render();

            return response()->json(['html' => $html]);

        } catch (\Throwable $e) {
            Log::error('Error in calendar_filter_slots: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid week range format.'], 400);
        }
    }

    public function schedule_interview($id,Request $request)
    {
        try{ 
             $applicant = $this->applicantrepository->getApplicantById($id);
             $isReschedule = false;
             $existingInterview = null;


             Log::info('Applicant details for scheduling interview', ['applicant' => $applicant]);

             return view('backend.applicant.schedule_interview',compact('applicant', 'isReschedule', 'existingInterview'));
        } catch(\Exception $e){
           return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicant.');
        }
       
    }

    public function fetch_interview_slots(Request $request)
    {
        try {
            $validated = $request->validate([
                'interview_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'interview_mode' => 'sometimes|string'
            ]);

            // Validate 1-hour duration for search as well
            $start = strtotime($validated['start_time']);
            $end = strtotime($validated['end_time']);
            $duration = ($end - $start) / 3600;

            if ($duration != 1) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Please select a time range of exactly 1 hour.'
                ]);
            }

            $slots = $this->applicantrepository->getSlotsBetween(
                $validated['interview_date'],
                $validated['start_time'],
                $validated['end_time'],
                $validated['interview_mode'] ?? null
            );

            // Log::info('Available interview slots', ['slots' => $slots]);

            $html = view('backend.applicant.partials.booked_slots', compact('slots'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to fetch interview slots', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
    }

    public function assign_interview_slot(Request $request)
    {
        try {
            Log::info('request for assign interview slot', ['request' => $request->all()]);

            $validated = $request->validate([
                'applicant_id' => 'required|exists:applicants,id',
                'interview_mode' => 'required|in:online,offline',
                'interview_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'interview_link' => 'nullable|required_if:interview_mode,online',
                'interview_location' => 'nullable|required_if:interview_mode,offline',
            ]);

            // Validate 1-hour duration
            $start = strtotime($validated['start_time']);
            $end = strtotime($validated['end_time']);
            $duration = ($end - $start) / 3600;

            if ($duration != 1) {
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Interview slot must be exactly 1 hour long.'
                // ]);
                return response()->json($this->responseWithError('Interview slot must be exactly 1 hour long.'));

            }

            if ($validated['interview_mode'] === 'online' && empty($validated['interview_link'])) {
                // return response()->json(['success' => false, 'message' => 'Meeting link is required for online mode.']);
                return response()->json($this->responseWithError('Meeting link is required for online mode.'));

            }

            if ($validated['interview_mode'] === 'offline' && empty($validated['interview_location'])) {
                // return response()->json(['success' => false, 'message' => 'Interview location is required for offline mode.']);
                return response()->json($this->responseWithError('Interview location is required for offline mode.'));

            }

            $validated['interview_time'] = $request->start_time . ' - ' . $request->end_time;

            $this->applicantrepository->saveInterviewSchedule($validated);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Interview slot assigned successfully!'
            // ]);

            return response()->json($this->responseWithSuccess('Interview slot assigned successfully!'));

        } catch (\Exception $e) {
            Log::error('Failed to assign interview slot', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // return response()->json(['success' => false, 'message' => $e->getMessage()]);
            return response()->json($this->responseWithError($e->getMessage()));

        }
    }


    public function reschedule_interview($id, Request $request)
    {
        try {
            $applicant = $this->applicantrepository->getApplicantById($id);
            $isReschedule = true;
            $existingInterview = $applicant->interview;

            Log::info('Applicant details for rescheduling interview', [
                'applicant' => $applicant,
                'existing_interview' => $existingInterview
            ]);

            return view('backend.applicant.schedule_interview', compact('applicant', 'isReschedule', 'existingInterview'));
        } catch (\Exception $e) {
            return redirect()->route('applicant.dashboard')->with('error', 'Failed to get applicant.');
        }
    }

    public function update_interview_slot(Request $request)
    {
        try {
            Log::info('request for update interview slot', ['request' => $request->all()]);

            $validated = $request->validate([
                'applicant_id' => 'required|exists:applicants,id',
                'interview_mode' => 'required|in:online,offline',
                'interview_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'interview_link' => 'nullable|required_if:interview_mode,online',
                'interview_location' => 'nullable|required_if:interview_mode,offline',
            ]);

            // Validate 1-hour duration (same as your existing validation)
            $start = strtotime($validated['start_time']);
            $end = strtotime($validated['end_time']);
            $duration = ($end - $start) / 3600;

            if ($duration != 1) {
                return response()->json($this->responseWithError('Interview slot must be exactly 1 hour long.'));
            }

            if ($validated['interview_mode'] === 'online' && empty($validated['interview_link'])) {
                return response()->json($this->responseWithError('Meeting link is required for online mode.'));
            }

            if ($validated['interview_mode'] === 'offline' && empty($validated['interview_location'])) {
                return response()->json($this->responseWithError('Interview location is required for offline mode.'));
            }

            $validated['interview_time'] = $request->start_time . ' - ' . $request->end_time;

            // Use repository to update interview with reschedule status
            $this->applicantrepository->updateInterviewSchedule($validated);

            return response()->json($this->responseWithSuccess('Interview rescheduled successfully!'));

        } catch (\Exception $e) {
            Log::error('Failed to update interview slot', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json($this->responseWithError($e->getMessage()));
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
