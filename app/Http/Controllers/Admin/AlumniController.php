<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AlumniGalleryRepositoryInterface as InterfacesAlumniGalleryRepositoryInterface;
use App\Interfaces\RecordedClassRepositoryInterface;
use App\Models\Academic\Classes;
use App\Models\Academic\Semester;
use App\Models\Academic\YearStatus;
use App\Models\Session;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use ZipArchive;
use App\Models\StudentClassMapping;
use App\Models\StudentInfo\SchoolDetail;

class AlumniController extends Controller
{
    protected $repository;
    protected $recordedClassRepository;

    public function __construct(
        InterfacesAlumniGalleryRepositoryInterface $repository,
        RecordedClassRepositoryInterface $recordedClassRepository
        ) {
            $this->repository = $repository;
            $this->recordedClassRepository = $recordedClassRepository;
        }

    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getFiltered($request);
        }

        $years = Session::orderByDesc('id') ->get();
        $yearStatuses = YearStatus::orderByDesc('id') ->get();
        $semesters = Semester::orderByDesc('id')->get();

        $allStudents = Student::with([
                'parent' => fn($q) => $q->with('user')->active()
            ])
            ->selectRaw("CONCAT(first_name, ' ', last_name) as name")
            ->distinct()
            ->get();

        return view('backend.alumni.index', compact(
            'allStudents',
            'years',
            'yearStatuses',
            'semesters'
        ));
    }


    public function getFiltered(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        // -------------------------------------------------
        // 1. Build the query with school details
        // -------------------------------------------------
        $query = Student::query()
            ->join('student_class_mapping', 'students.id', '=', 'student_class_mapping.student_id')
            ->join('classes', 'student_class_mapping.class_id', '=', 'classes.id')
            ->leftJoin('sessions', 'classes.session_id', '=', 'sessions.id')
            ->leftJoin('year_status', 'classes.year_status_id', '=', 'year_status.id')  // Fixed
            ->leftJoin('semesters', 'classes.semester_id', '=', 'semesters.id')
            ->leftJoin('school_details', 'students.id', '=', 'school_details.student_id') 
            ->leftJoin('parent_guardians', 'students.id', '=', 'parent_guardians.student_id')
            ->select([
                'students.*',
                'classes.name as class_name',
                'classes.abbreviation as class_abbr',
                'sessions.name as session_name',
                'year_status.name as year_status_name',
                'semesters.name as semester_name',
                'school_details.*',
                'parent_guardians.*',
            ])
            ->distinct();

        // -------------------------------------------------
        // 2. Apply filters
        // -------------------------------------------------

        if ($studentName = $request->query('student_name')) {
            $query->whereRaw("CONCAT(students.first_name, ' ', students.last_name) = ?", [$studentName]);
        }

        if ($schoolYear = $request->query('school_year')) {
            $query->where('classes.session_id', $schoolYear);
        }

        if ($yearStatus = $request->query('year_status')) {
            $query->where('classes.year_status_id', $yearStatus);
        }

        if ($semester = $request->query('semester')) {
            $query->where('classes.semester_id', $semester);
        }

        $query->where('student_class_mapping.status', 1);

        // -------------------------------------------------
        // 3. Paginate & render
        // -------------------------------------------------
        $alumni = $query->paginate($perPage)->appends($request->query());

        $html = view('backend.alumni.list', compact('alumni', 'perPage'))->render();

        return response()->json(['html' => $html]);
    }


    public function alumni_list_info($id)
    {
        $alumniInfo = Student::with([
            'parent' => function ($query) {
                $query->with(['user'])->active();
            },
            'schoolDetail'
        ])->findOrFail($id);

        return view('backend.alumni.alumni-list-info', compact('alumniInfo'));
    }


    public function gallery()
    {
        $galleryItems = $this->repository->all();
        return view('backend.alumni.gallery', compact('galleryItems'));
    }

    public function store(Request $request)
    {
        try {
            $result = $this->repository->create(
                $request->only(['title', 'description']),
                $request->file('file')
            );

            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while uploading the file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $galleryItem = $this->repository->find($id);
            return response()->json([
                'galleryItem' => [
                    'id' => $galleryItem->id,
                    'filename' => $galleryItem->filename,
                    'path' => Storage::disk('public')->url($galleryItem->path),
                    'type' => $galleryItem->type,
                    'size' => $galleryItem->size,
                    'title' => $galleryItem->title,
                    'description' => $galleryItem->description,
                    'created_at' => $galleryItem->created_at->diffForHumans(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching gallery item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $result = $this->repository->update(
                $id,
                $request->only(['title', 'description']),
                $request->file('file')
            );

            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return response()->json([
                'message' => 'Gallery item deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting gallery item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadAll()
    {
        try {
            $galleryItems = $this->repository->all();
            if ($galleryItems->isEmpty()) {
                return response()->json(['message' => 'No files available to download'], 404);
            }

            $zip = new ZipArchive;
            $zipFileName = storage_path('app/public/gallery_files.zip');
            if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return response()->json(['message' => 'Could not create ZIP file'], 500);
            }

            foreach ($galleryItems as $item) {
                $filePath = storage_path('app/public/' . $item->path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $item->filename);
                }
            }

            $zip->close();

            if (!file_exists($zipFileName)) {
                return response()->json(['message' => 'No files were added to the ZIP'], 404);
            }

            return response()->download($zipFileName, 'gallery_files.zip')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error preparing download',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    ##########################################################################

    public function recorded_class()
    {
        $videos = $this->recordedClassRepository->getByType('video')->load('class');
        $audios = $this->recordedClassRepository->getByType('audio')->load('class');
        return view('backend.alumni.recorded-classes', compact('videos', 'audios'));
    }

    public function getByType($type)
    {
        try {
            $recordedClasses = $this->recordedClassRepository->getByType($type);
            return response()->json([
                'recordedClasses' => $recordedClasses->load('class')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching recorded classes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeRecord(Request $request)
    {
        try {
            $result = $this->recordedClassRepository->create(
                $request->only(['title', 'author', 'class_id', 'speaker', 'date']),
                $request->file('file')
            );
            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating recorded class',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update_record(Request $request, $id)
    {
        try {
            $data = $request->only(['title', 'author', 'class_id', 'speaker', 'date', 'coded_name']);
            $file = $request->file('file');
            $result = $this->recordedClassRepository->update($id, $data, $file);
            if (!$result['recordedClass']) {
                throw new \Exception('Update failed: No data returned');
            }
            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
                'message' => 'Validation failed'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating recorded class',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy_record($id)
    {
        try {
            $this->recordedClassRepository->delete($id);
            return response()->json([
                'message' => 'Media deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting media',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}