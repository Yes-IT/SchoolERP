<?php

namespace App\Http\Controllers\StudentInfo;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\StudentInfo\ParentGuardianRepository;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianStoreRequest;
use App\Http\Requests\StudentInfo\ParentGuardian\ParentGuardianUpdateRequest;
use  App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\Student;
use App\Models\Dormitory\ProcurementEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Imports\ProcurementImport;
use Maatwebsite\Excel\Facades\Excel;



class DormitoryController extends Controller
{
    private $repo;

    function __construct(ParentGuardianRepository $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        // Fetch all assets
        $it_assets = DB::table('assets_list')->get();

        return view('backend.dormitory.index', compact('it_assets'));
    }

    public function itassets(Request $request)
    {
        $assetType = $request->input('asset_type'); // from dropdown

        // Build query joining both tables
        $query = DB::table('it_assets_request as r')
            ->join('assets_list as a', 'r.asset_id', '=', 'a.id') // join by asset_id
            ->select(
                'r.id as request_id',       // request table id
                'r.asset_id',
                'r.quantity',
                'r.reason',
                'r.status as request_status',
                'r.assign_status',
                'r.assign_id',
                'r.created_at as request_created_at',
                'r.updated_at as request_updated_at',
                'a.model',
                'a.name',
                'a.status as asset_status', // status from assets_list
                'a.created_at as asset_created_at'
            );


        if ($assetType && $assetType !== 'all') {
            $query->where('a.name', $assetType);
        }

        // Get all joined data
        $it_assets = $query->get();

        // AJAX request
        if ($request->ajax()) {
            return view('backend.dormitory.it-assets.it-assets-list', compact('it_assets'))->render();
        }

        // Normal page load
        return view('backend.dormitory.it-assets.index', compact('it_assets'));
    }


    public function filterassettype(Request $request)
    {
        $type = $request->query('type');

        // Start query on assets_list table
        $query = DB::table('assets_list');

        if (!empty($type)) {
            $query->where('name', $type);  // changed asset_type → name
        }

        $it_assets = $query->get();

        return view('backend.dormitory.it-assets.it-assets-list', compact('it_assets'));
    }


    public function requestedassets()
    {
        $requests = DB::table('it_assets_request')->get();


        return view('backend.dormitory.requested_assets.index',  compact('requests'));
    }
    public function filterRequests(Request $request)
    {
        $status = $request->query('status'); // get from dropdown
        $query = DB::table('it_assets_request');

        if (!empty($status) && $status !== 'select-year') {
            // Map dropdown values to DB status codes
            if ($status === 'approve') {
                $query->where('status', 3);
            } elseif ($status === 'rejected') {
                $query->where('status', 4);
            }
        }

        $requests = $query->get();

        if ($requests->isEmpty()) {
            // Return a "No data found" row
            return '<tr><td colspan="5" style="text-align:center;">No data found</td></tr>';
        }

        // Return only the rows partial to update the table
        return view('backend.dormitory.requested_assets.requested_assets-list', compact('requests'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:it_assets_request,id',
            'status' => 'required|in:3,4', // 0 = Rejected, 1 = Approved
        ]);

        // Update the record
        DB::table('it_assets_request')
            ->where('id', $request->id)
            ->update([
                'status'     => $request->status,
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
    }

    public function assignedassets()
    {
        // Fetch only assigned records
        $assignedAssets = \DB::table('it_assets_request as r')
            ->join('it_assets as a', 'r.asset_id', '=', 'a.id')
            ->select(
                'r.id as request_id',
                'r.assign_id',
                'r.assign_status',
                'r.status as request_status',
                'r.created_at',
                'a.id as asset_id',
                'a.asset_type',
                'a.asset_model',
                // if exists in your it_assets table
            )
            ->where('r.assign_status', 1) // Only assigned assets
            ->get();

        return view('backend.dormitory.assigned_assets.index', compact('assignedAssets'));
    }


    // app/Http/Controllers/IssueReportController.php

    public function issuereports()
    {
        $issueReports = \DB::table('issue_report')->get(); // or use IssueReport::all() if you have a model
        return view('backend.dormitory.issue_report.index', compact('issueReports'));
    }





    public function  returnassets()
    {
        $returnAssets = \DB::table('return_it_assets')->get();
        return view('backend.dormitory.return-assets.index', compact('returnAssets'));
    }


    public function procurement()
    {
        $categories = \DB::table('category_list')->get();
        $staff = \DB::table('staff')->select('id', 'first_name', 'last_name')->get();
        $requests = \DB::table('it_assets_request as r')
            ->leftJoin('assets_list as a', 'r.asset_id', '=', 'a.id')
            ->leftJoin('staff as s', 'r.assign_id', '=', 's.id') // join staff
            ->select(
                'r.id',
                'r.asset_id',
                'r.quantity',
                'r.reason',
                'r.status',
                'r.assign_status',
                'r.assign_id',
                'r.created_at',
                'a.name as asset_name',
                'a.model as asset_model',
                's.staff_id as staff_id',
                \DB::raw("CONCAT(s.first_name, ' ', s.last_name) as staff_name") // concatenate name
            )
            ->get();

        return view('backend.dormitory.procurement.index', compact('requests', 'categories', 'staff'));
    }

    public function searchProcurement(Request $request)
    {
        $search = $request->input('q');   // changed from 'search' to 'q'

        $requests = DB::table('it_assets_request as r')
            ->leftJoin('staff as s', 'r.assign_id', '=', 's.id')
            ->leftJoin('assets_list as a', 'r.asset_id', '=', 'a.id')
            ->select(
                'r.id',
                DB::raw("CONCAT(s.first_name, ' ', s.last_name) as staff_name"),
                's.id as staff_id',
                'a.name as asset_name',
                'a.model as asset_model',
                'r.quantity',
                'r.created_at'
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(s.first_name, ' ', s.last_name)"), 'LIKE', "%{$search}%")
                        ->orWhere('a.name', 'LIKE', "%{$search}%")
                        ->orWhere('a.model', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        // build table rows
        $html = '';

        if ($requests->isEmpty()) {
            // If no rows found
            $html = '
            <tr>
                <td colspan="9" style="text-align:center; color:#999;">
                    No data found
                </td>
            </tr>
        ';
        } else {
            foreach ($requests as $index => $req) {
                $html .= '
                <tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . $req->id . '</td>
                    <td>' . ($req->staff_name ?? '—') . '</td>
                    <td>' . ($req->staff_id ?? '—') . '</td>
                    <td>' . ($req->asset_name ?? 'Unknown') . '</td>
                    <td>' . ($req->asset_model ?? 'N/A') . '</td>
                    <td>' . $req->quantity . '</td>
                    <td>' . $req->quantity . '</td>
                    <td>' . \Carbon\Carbon::parse($req->created_at)->format('d-m-Y') . '</td>
                </tr>
            ';
            }
        }

        return $html;
    }
    public function storeProcurement(Request $request)
    {
        // Log that we entered the method
        Log::info('storeProcurement() called', [
            'request_data' => $request->all()
        ]);

        try {
            // Validate the request
            $request->validate([
                'category_id'     => 'required|exists:category_list,id',
                'item_name'       => 'required|string|max:255',
                'qty'             => 'required|integer|min:1',
                'amount_per_qty'  => 'required|numeric|min:0',
                'supplier_name'   => 'required|string|max:255',
                'delivery_date'   => 'required|date',
            ]);

            // Save to DB
            $entry = ProcurementEntry::create([
                'category_id'    => $request->category_id,
                'item_name'      => $request->item_name,
                'qty'            => $request->qty,
                'amount_per_qty' => $request->amount_per_qty,
                'supplier_name'  => $request->supplier_name,
                'delivery_date'  => $request->delivery_date,
                'status'         => 1, // default active
            ]);

            // Log success
            Log::info('Procurement entry created successfully', [
                'entry' => $entry->toArray()
            ]);

            return redirect()->back()->with('success', 'Procurement entry added successfully!');
        } catch (Exception $e) {
            // Log error details
            Log::error('Failed to store procurement entry', [
                'error_message' => $e->getMessage(),
                'stack_trace'   => $e->getTraceAsString(),
                'request_data'  => $request->all()
            ]);

            // Return with error message
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function importProcurement(Request $request)
    {
        Log::info('--- [IMPORT STARTED] importProcurement() called ---');

        // Log incoming request data (excluding file binary content)
        Log::info('Request Data Received', [
            'inputs' => $request->except('file'),
            'has_file' => $request->hasFile('file'),
        ]);

        try {
            // ✅ Validation
            Log::info('Validating uploaded file...');
            $request->validate([
                'file' => 'required|mimes:csv,xlsx,xls|max:2048',
            ]);
            Log::info('File validation passed.');

            // ✅ Log file details
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                Log::info('Uploaded File Details', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type'     => $file->getMimeType(),
                    'extension'     => $file->getClientOriginalExtension(),
                    'size_kb'       => round($file->getSize() / 1024, 2) . ' KB',
                    'path'          => $file->getRealPath(),
                ]);
            } else {
                Log::warning('No file found in request despite validation.');
            }

            // ✅ Begin Import
            Log::info('Starting Excel import process...');
            #print_r($request->file('file'));die;
            #Excel::import(new ProcurementImport, $request->file('file'));
            Log::info('Excel import completed successfully.');

            Log::info('--- [IMPORT COMPLETED SUCCESSFULLY] ---');

            return redirect()->back()->with('success', 'Procurement data imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // ✅ Catch Excel validation errors
            Log::error('Excel Validation Exception', [
                'failures' => $e->failures(),
            ]);

            return redirect()->back()->with('error', 'Excel validation failed: Check your file format.');
        } catch (\Throwable $e) {
            // ✅ Catch all other exceptions
            Log::error('Procurement import failed due to an unexpected error.', [
                'error_message' => $e->getMessage(),
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    public function filterByUser(Request $request)
    {
        $staffId = $request->input('staff_id');

        $query = \DB::table('it_assets_request as r')
            ->leftJoin('staff as s', 'r.assign_id', '=', 's.id')
            ->leftJoin('assets_list as a', 'r.asset_id', '=', 'a.id')
            ->select(
                'r.id',
                'r.assign_id as staff_id',
                \DB::raw("CONCAT(s.first_name, ' ', s.last_name) as staff_name"),
                'a.name as asset_name',
                'r.quantity',
                'r.status',
                'r.assign_status',
                'r.created_at'
            );

        if (!empty($staffId)) {
            $query->where('r.assign_id', $staffId);
        }

        $requests = $query->get();

        return response()->json(['requests' => $requests]);
    }




    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $filtered = \DB::table('it_assets_request as r')
            ->leftJoin('assets_list as a', 'r.asset_id', '=', 'a.id')
            ->leftJoin('staff as s', 'r.assign_id', '=', 's.id')
            ->select(
                'r.id',
                'r.asset_id',
                'r.quantity',
                'r.reason',
                'r.created_at',
                'a.name',
                'a.model',
                's.id as staff_id',
                \DB::raw("CONCAT(s.first_name, ' ', s.last_name) as staff_name")
            )
            ->when($date, function ($query, $date) {
                $query->whereDate('r.created_at', $date);
            })
            ->orderBy('r.created_at', 'desc')
            ->get();

        // Return partial HTML (only tbody rows)
        $html = view('backend.dormitory.procurement.fullfillment-history-list', ['requests' => $filtered])->render();

        return response()->json(['html' => $html]);
    }








    public function maintainenceRequest()
    {
        // Fetch all maintenance requests
        $requests = \DB::table('maintenance_request')
            ->orderBy('created_at', direction: 'desc')
            ->get();

        // Fetch all unique rooms
        $rooms = \DB::table('maintenance_request')
            ->select('room_no')
            ->distinct()
            ->orderBy('room_no')
            ->pluck('room_no'); // Returns an array of room numbers

        return view('backend.dormitory.maintenance_request.index', compact('requests', 'rooms'));
    }


    public function markAsDone($id)
    {
        $updated = \DB::table('maintenance_request')
            ->where('id', $id)
            ->update([
                'status' => 1,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'problem'    => 'required|string|max:500',
            'room_no'    => 'required|string|max:50',
            'due_date'   => 'nullable|date|after_or_equal:issue_date',
        ]);

        \DB::table('maintenance_request')->insert([
            'issue_date' => $request->issue_date,
            'problem'    => $request->problem,
            'room_no'    => $request->room_no,
            'due_date'   => $request->due_date,
            'status'     => 0, // default pending
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Maintenance request added successfully!');
    }


    public function filterByRoom(Request $request)
    {
        // Get all unique rooms for dropdown
        $rooms = \DB::table('maintenance_request')
            ->select('room_no')
            ->distinct()
            ->orderBy('room_no')
            ->pluck('room_no');

        // Query maintenance requests
        $query = \DB::table('maintenance_request')->orderBy('created_at', 'desc');

        // Apply search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room_no', 'like', "%{$search}%")
                    ->orWhere('problem', 'like', "%{$search}%")
                    ->orWhere('issue_date', 'like', "%{$search}%")
                    ->orWhere('due_date', 'like', "%{$search}%");
            });
        }

        // Apply room filter
        if ($request->filled('room_no')) {  // <-- use 'room_no' to match select name
            $query->where('room_no', $request->room_no);
        }

        $requests = $query->get();

        return view('backend.dormitory.maintenance_request.index', compact('requests', 'rooms'));
    }

    public function filterByIssueDate(Request $request)
    {
        $issueDate = $request->input('issue_date');
        $status = $request->input('status', 0);

        // Fetch matching records
        $requests = \DB::table('maintenance_request')
            ->whereDate('issue_date', $issueDate)
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        // Build HTML for each status
        $pendingHtml = '';
        $resolvedHtml = '';

        foreach ($requests as $index => $req) {
            $row = "
            <tr>
                <td>" . ($index + 1) . "</td>
                <td>" . \Carbon\Carbon::parse($req->issue_date)->format('d-m-Y') . "</td>
                <td>$req->room_no</td>
                <td>" . \Carbon\Carbon::parse($req->due_date)->format('d-m-Y') . "</td>
                <td>$req->problem</td>";

            if ($status == 0) {
                $row .= "
                <td><button style='background-color:#ffc107; padding:4px; font-size:14px;'>Pending</button></td>
                <td><button onclick='markAsDone($req->id)' style='background: var(--primary-clr); color: white; padding:9px;'>Mark as Done</button></td>";
                $pendingHtml .= $row . "</tr>";
            } else {
                $row .= "
                <td><button style='background-color:green; color:white; padding:4px; font-size:14px;'>Resolved</button></td>";
                $resolvedHtml .= $row . "</tr>";
            }
        }

        if ($status == 0 && $pendingHtml == '') {
            $pendingHtml = "<tr><td colspan='7' style='text-align:center;'>No pending requests found</td></tr>";
        }
        if ($status == 1 && $resolvedHtml == '') {
            $resolvedHtml = "<tr><td colspan='7' style='text-align:center;'>No resolved requests found</td></tr>";
        }

        return response()->json([
            'pendingHtml' => $pendingHtml,
            'resolvedHtml' => $resolvedHtml
        ]);
    }






    public function lateEntry(Request $request)
    {
        $roomFilter = $request->get('room_id');
        $studentFilter = $request->get('student_id');

        $query = \DB::table('late_curfew as l')
            ->leftJoin('students as s', 'l.student_id', '=', 's.id')
            ->select(
                'l.id',
                'l.date',
                'l.time',
                's.first_name as student_name',
                'l.room',
                'l.reason',
                'l.status'
            )
            ->orderBy('l.date', 'desc');

        // Apply filter if a specific room is selected
        if (!empty($roomFilter)) {
            $query->where('l.room', $roomFilter);
        }
        if (!empty($studentFilter)) {
            $query->where('l.student_id', $studentFilter);
        }

        $entries = $query->get();

        $rooms = \DB::table('school_details')
            ->select('room')
            ->distinct()
            ->orderBy('room')
            ->pluck('room');

        $students = \DB::table('students')
            ->select('id', 'first_name')
            ->orderBy('first_name')
            ->get();

        // If it's an AJAX request, return only table rows
        if ($request->ajax()) {
            return response()->json(['entries' => $entries]);
        }

        return view('backend.dormitory.late_entry.index', compact('entries', 'students', 'rooms'));
    }


    public function getStudentRoom(Request $request)
    {
        $studentId = $request->student_id;

        $room = \DB::table('school_details')
            ->where('student_id', $studentId)
            ->value('room');

        return response()->json(['room' => $room]);
    }

    public function latecurfewstore(Request $request)
    {

        // Log incoming request data


        // Validate request
        $request->validate([

            'room'         => 'nullable|string',
            'date'         => 'required|date',
            'time'  => 'nullable',
            'reason'       => 'nullable|string',
        ]);



        // Insert into database
        DB::table('late_curfew')->insert([


            'room'         => $request->room,
            'date'         => $request->date,
            'time'  => $request->time,
            'reason'       => $request->reason,
        ]);



        return redirect()->back()->with(['success' => true, 'message' => 'Late curfew record saved successfully!']);
    }

    public function latecurfewfilterByroom(Request $request)
    {
        // Get all unique rooms for dropdown
        $rooms = \DB::table('school_details')
            ->select('room')
            ->distinct()
            ->orderBy('room')
            ->pluck('room');

        // Query maintenance requests
        $query = \DB::table('school_details')->orderBy('created_at', 'desc');

        // Apply search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room', 'like', "%{$search}%")
                    ->orWhere('problem', 'like', "%{$search}%")
                    ->orWhere('issue_date', 'like', "%{$search}%")
                    ->orWhere('due_date', 'like', "%{$search}%");
            });
        }

        // Apply room filter
        if ($request->filled('room_no')) {  // <-- use 'room_no' to match select name
            $query->where('room_no', $request->room_no);
        }

        $requests = $query->get();

        return view('backend.dormitory.maintenance_request.index', compact('requests', 'rooms'));
    }


    public function filterByDateLate(Request $request)
    {
        $date = $request->get('date');

        $entries = \DB::table('late_curfew as l')
            ->leftJoin('students as s', 'l.student_id', '=', 's.id')
            ->select(
                'l.id',
                'l.date',
                'l.time',
                's.first_name as student_name',
                'l.room',
                'l.reason',
                'l.status'
            )
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('l.date', $date);
            })
            ->orderBy('l.date', 'desc')
            ->get();

        return response()->json(['entries' => $entries]);
    }







    public function doctorVisit(Request $request)
    {
        $studentFilter = $request->get('student_id');

        // Base query
        $query = \DB::table('guest_visit');
        if (!empty($studentFilter)) {
            $query->where('student_id', $studentFilter);
        }

        $doctors = $query->get();

        $students = \DB::table('students')
            ->select('id', 'first_name')
            ->orderBy('first_name')
            ->get();


        if ($request->ajax()) {
            return response()->json(['doctors' => $doctors]);
        }

        // Otherwise return full page
        return view('backend.dormitory.doctor_visit.index', compact('doctors', 'students'));
    }



    public function doctorVisitstore(Request $request)
    {

        $request->validate([

            'student_id' => 'nullable|integer',

            'student_name'       => 'nullable|string',
            'entry_date'         => 'required|date',
            'name' => 'nullable|string',
            'description'       => 'nullable|string',
            'issue'       => 'nullable|string',
        ]);



        // Insert into database
        DB::table('guest_visit')->insert([

            'student_id' => $request->student_id,
            'student_name' => $request->student_name,
            'entry_date' => $request->entry_date,
            'name' => $request->name,
            'description' => $request->description,
            'issue' => $request->issue,


        ]);



        return redirect()->back()->with(['success' => true, 'message' => 'Doctor visit record saved successfully!']);
    }


    public function filterdoctordatabyDate(Request $request)
    {
        $date = $request->get('entry_date');

        $doctors = \DB::table('guest_visit')
            ->select(
                'id',
                'entry_date',
                'student_id',
                'type',
                'name',
                'description',
                'issue'
            )
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('entry_date', $date);
            })
            ->orderBy('entry_date', 'desc')
            ->get();

        return response()->json(['doctors' => $doctors]);
    }


    public function pantry()
    {

        return view('backend.dormitory.pantry.index');
    }


    public function inventory()
    {
        $inventories = \DB::table('pantry_inventory as p')
            ->leftJoin('products as prod', 'p.product_id', '=', 'prod.id')
            ->leftJoin('category_list as c', 'p.category_id', '=', 'c.id')
            ->select(
                'p.id',
                'prod.name as product_name',
                'c.name as category_name',
                'p.qty',
                'p.unit',
                'p.reason',
                'p.status',
                'prod.price',
                'p.created_at',
                'p.updated_at'
            )
            ->orderBy('p.id', 'desc')
            ->get();

        return view('backend.dormitory.inventory.index', compact('inventories'));
    }


    public function requestedInventory()
    {

        $requests = \DB::table('pantry_request_inventory as pri')
            ->leftJoin('pantry_inventory as pi', 'pri.asset_id', '=', 'pi.id')
            ->leftJoin('products as prod', 'pi.product_id', '=', 'prod.id')
            ->leftJoin('category_list as cat', 'pi.category_id', '=', 'cat.id')
            ->select(
                'pri.id',
                'pri.asset_id',
                'pri.quantity',
                'pri.reason',
                'pri.status',
                'pri.assign_status',
                'pri.created_at',
                'prod.name as product_name',
                'cat.name as category_name'
            )
            ->orderBy('pri.id', 'desc')
            ->get();


        return view('backend.dormitory.requested_inventory.index', compact('requests'));
    }



    public function lowInventory()
    {
        $inventories = \DB::table('pantry_inventory')
            ->join('products', 'pantry_inventory.product_id', '=', 'products.id')
            ->join('category_list', 'pantry_inventory.category_id', '=', 'category_list.id')
            ->where('pantry_inventory.qty', '<=', value: 10)
            ->orderBy('pantry_inventory.updated_at', 'desc')
            ->select(
                'pantry_inventory.*',
                'products.product_name',
                'category_list.name'
            )
            ->get();

        #print_r($inventories);die;
        // dd($inventories);

        return view('backend.dormitory.low_inventory.index', compact('inventories'));
    }


    public function updateRequestInventoryStatus(Request $request, $id)
    {
        try {
            $requestItem = \DB::table('pantry_request_inventory')->where('id', $id)->first();

            if (!$requestItem) {
                return response()->json(['success' => false, 'message' => 'Request not found']);
            }

            \DB::table('pantry_request_inventory')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            $statusText = match ($request->status) {
                3 => 'Approved',
                4 => 'Rejected',
                default => 'Updated'
            };

            return response()->json([
                'success' => true,
                'message' => "Request has been {$statusText} successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ]);
        }
    }



    public function usageReport()
    {
        // Step 1: Deduct approved request quantities from inventory (only once)
        $approvedRequests = \DB::table('pantry_request_inventory')
            ->where('status', 4)
            ->get();

        foreach ($approvedRequests as $req) {
            // Deduct only if stock is sufficient
            \DB::table('pantry_inventory')
                ->where('id', $req->asset_id)
                ->decrement('qty', $req->quantity);

            // Optional: Mark processed so we don't deduct twice
            \DB::table('pantry_request_inventory')
                ->where('id', $req->id)
                ->update(['status' => 4]); // mark as available or processed
        }

        // Step 2: Fetch updated pantry inventory data
        $inventories = \DB::table('pantry_inventory')
            ->join('products', 'pantry_inventory.product_id', '=', 'products.id')
            ->join('category_list', 'pantry_inventory.category_id', '=', 'category_list.id')
            ->select(
                'pantry_inventory.id',
                'products.product_name',
                'category_list.name',
                'pantry_inventory.qty',
                'pantry_inventory.reason',
                'pantry_inventory.updated_at',
                'pantry_inventory.unit'
            )
            ->orderBy('pantry_inventory.updated_at', 'desc')
            ->get();
        return view('backend.dormitory.usage_report.index', compact('inventories'));
    }
}
