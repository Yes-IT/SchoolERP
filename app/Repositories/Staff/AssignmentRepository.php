<?php
namespace App\Repositories\Staff;

use App\Interfaces\Staff\AssignmentInterface;
use App\Models\Academic\{Assignment,AssignmentMedia,AssignmentSubmission};
use Illuminate\Support\Facades\{DB,Log};
use Exception;


class AssignmentRepository implements AssignmentInterface
{
    public function createAssignment(array $data, array $files = [])
    {
        DB::beginTransaction();
        
        try {
            // Create assignment
            $assignment = Assignment::create($data);

            // Handle file uploads
            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = $file->store('staff/uploads/assignments/images', 'public');

                    AssignmentMedia::create([
                        'assignment_id' => $assignment->id,
                        'file_name'     => $file->getClientOriginalName(),
                        'media_type'    => $file->getClientOriginalExtension(),
                        'path'          => $path,
                        'file_size'     => $file->getSize(),
                    ]);
                }
            }

            DB::commit();
            return $assignment;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getByTeacher($teacherId)
    {
        return Assignment::with(['subject', 'media'])
                        ->where('created_by', $teacherId)
                        ->orderBy('created_at', 'desc')
                        ->get();
    }


    public function getByStatus($teacherId, $status)
    {
        // Log::info("Repo: Fetching assignments | Teacher: $teacherId | Status: $status");

        $assignments = Assignment::with(['subject', 'media'])
                        ->where('created_by', $teacherId)
                        ->where('status', $status)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Log::info("Repo Result Count: " . $assignments->count());

        // foreach ($assignments as $assignment) {
        //     Log::info("Assignment ID: {$assignment->id}, Subject: " . ($assignment->subject->name ?? 'NULL') . ", Status: {$assignment->status}");
        // }

        return $assignments;
    }

    public function find($id)
    {
        return Assignment::with(['subject', 'media'])->find($id);
    }

    public function update($id, array $data)
    {

        $assignment = Assignment::find($id);
            if ($assignment) {
                // Log::info('Updating assignment:', [
                //     'id' => $id,
                //     'data' => $data,
                //     'current_data' => $assignment->toArray()
                // ]);
                
                $assignment->update($data);
                
                // Log::info('Assignment updated successfully:', $assignment->toArray());
                return $assignment;
            }
        
        Log::warning('Assignment not found for update:', ['id' => $id]);
        return null;
    }

    // public function uploadMedia($assignmentId, $file)
    // {
    //     $fileName = time() . '_' . $file->getClientOriginalName();
    //     $path = $file->storeAs('staff/uploads/assignments/images', $fileName, 'public');

    //     return AssignmentMedia::create([
    //         'assignment_id' => $assignmentId,
    //         'student_id' => null,
    //         'media_type' => $file->getClientOriginalExtension(),
    //         'file_name' => $fileName,
    //         'path' => $path,
    //     ]);
    // }

    public function uploadMedia($assignmentId, $file)
    {
        //  Allowed extensions
        $allowedExtensions = ['pdf','jpg','jpeg','png','webp','mp4','mov','doc','docx','xls','xlsx'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            return [
                'status' => false,
                'message' => 'Unsupported file type. Allowed types: PDF, Images, Videos, DOC, XLS.'
            ];
        }

        //  File size validation
        $sizeMB = $file->getSize() / (1024 * 1024);
        $mime = $file->getMimeType();

        // IMAGE VALIDATION (max 5MB)
        if (str_starts_with($mime, 'image/') && $sizeMB > 5) {
            return [
                'status' => false,
                'message' => 'Images larger than 5 MB are not accepted. Please upload to Google Drive and share the link instead.'
            ];
        }

        // VIDEO VALIDATION (max 10MB)
        if (str_starts_with($mime, 'video/') && $sizeMB > 10) {
            return [
                'status' => false,
                'message' => 'Videos must be under 10 MB. Please upload to Google Drive and share the link instead.'
            ];
        }

        // DOCUMENT VALIDATION (20MB max)
        if (in_array($extension, ['pdf','doc','docx','xls','xlsx']) && $sizeMB > 20) {
            return [
                'status' => false,
                'message' => 'Documents larger than 20 MB are not accepted.'
            ];
        }

        //  Save file
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('staff/uploads/assignments/images', $fileName, 'public');

        AssignmentMedia::create([
            'assignment_id' => $assignmentId,
            'student_id' => null,
            'media_type' => $extension,
            'file_name' => $fileName,
            'path'      => $path,
        ]);

        return [
            'status' => true,
            'message' => 'File uploaded successfully.'
        ];
    }


    public function getMedia($assignmentId)
    {
        return AssignmentMedia::where('assignment_id', $assignmentId)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($media) {
                return [
                    'assignment_id' => $media->assignment_id,
                    'file_name' => $media->file_name,
                    'media_type' => $media->media_type,
                    'title' => $media->assignment->title ?? '',
                    'grade' => $media->assignment->grade ?? '',  
                ];
             });
    }



    public function getSubmissionsForEvaluation($assignmentId)
    {
        return AssignmentSubmission::with('student')
                ->where('assignment_id', $assignmentId)
                ->whereNull('deleted_at')
                ->get();
    }

    public function saveEvaluation($assignmentId, $request)
    {
        $grades = $request->grades ?? [];
        $notes  = $request->notes ?? [];

        $teacherId = auth()->user()->staff->id;  // evaluator/teacher

        foreach ($grades as $submissionId => $grade) {

            $submission = AssignmentSubmission::find($submissionId);

            if ($submission) {
                $submission->grade        = $grade;
                $submission->note         = $notes[$submissionId] ?? null;
                $submission->evaluated_by = $teacherId;
                $submission->evaluated_at = now();
                $submission->status       = 2; // evaluated
                $submission->save();
            }
        }



        // for closed assignment 
        $assignment = Assignment::find($assignmentId);

        if ($assignment) {

            $dueDatePassed = now()->greaterThan($assignment->due_date);

            $hasEvaluations = AssignmentSubmission::where('assignment_id', $assignmentId)
                                ->whereNotNull('evaluated_at')
                                ->exists();

            $lateExists = AssignmentSubmission::where('assignment_id', $assignmentId)
                            ->whereNotNull('submitted_at')
                            ->where('submitted_at', '>', $assignment->due_date)
                            ->exists();

            if ($assignment->status == 1 && $dueDatePassed && $hasEvaluations && !$lateExists) {

                $assignment->status = 2; // CLOSED assignment
                $assignment->save();
            }
        }


        return true;
    }


}