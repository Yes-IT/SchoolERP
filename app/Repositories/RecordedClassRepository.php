<?php

namespace App\Repositories;

use App\Interfaces\RecordedClassRepositoryInterface;
use App\Models\RecordedClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class RecordedClassRepository implements RecordedClassRepositoryInterface
{
    public function all()
    {
        return RecordedClass::all();
    }

    public function find($id)
    {
        return RecordedClass::findOrFail($id);
    }

    public function create(array $data, $file = null)
    {
        $this->validateData($data, $file);

        if ($file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $type = $extension === 'mp4' ? 'video' : 'audio';
            $filePath = $file->store("recorded_classes/$type", 'public');
            $data['path'] = $filePath;
            $data['filename'] = $file->getClientOriginalName();
            $data['type'] = $type;
            $data['size'] = $file->getSize();
        }

        $recordedClass = RecordedClass::create($data);

        return [
            'message' => 'Recorded class created successfully',
            'recordedClass' => $recordedClass
        ];
    }

    
    // In RecordedClassRepository.php -> update method

    public function update($id, array $data, $file = null)
    {
        $this->validateData($data, $file, true);

        // Find the record first to get current path
        $current = DB::table('recorded_classes')->where('id', $id)->first();

        if (!$current) {
            throw new \Exception('Recorded class not found');
        }

        $updateData = [
            'title' => $data['title'],
            'author' => $data['author'],
            'speaker' => $data['speaker'],
            'date' => $data['date'],
            'class_id' => !empty($data['class_id']) ? $data['class_id'] : null,
            'updated_at' => now(),
        ];

        // Handle coded_name if provided
        if (array_key_exists('coded_name', $data)) {
            $updateData['coded_name'] = $data['coded_name'] ?: null;
        }

        // Handle file upload
        if ($file) {
            // Delete old file
            if ($current->path && Storage::disk('public')->exists($current->path)) {
                Storage::disk('public')->delete($current->path);
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $type = $extension === 'mp4' ? 'video' : 'audio';

            $filePath = $file->store("recorded_classes/$type", 'public');

            $updateData['path'] = $filePath;
            $updateData['filename'] = $file->getClientOriginalName();
            $updateData['type'] = $type;
            $updateData['size'] = $file->getSize();
        }

        // Perform the raw DB update
        DB::table('recorded_classes')
            ->where('id', $id)
            ->update($updateData);

        // Fetch the updated record with class relation (if needed)
        $updatedRecord = DB::table('recorded_classes')
            ->leftJoin('classes', 'recorded_classes.class_id', '=', 'classes.id')
            ->select(
                'recorded_classes.*',
                'classes.name as class_name'
            )
            ->where('recorded_classes.id', $id)
            ->first();

        return [
            'message' => 'Recorded class updated successfully',
            'recordedClass' => $updatedRecord
        ];
    }


    public function delete($id)
    {
        $recordedClass = RecordedClass::findOrFail($id);
        if ($recordedClass->path) {
            Storage::disk('public')->delete($recordedClass->path);
        }
        $recordedClass->delete();
    }

    public function getByType(string $type)
    {
        return RecordedClass::where('type', $type)->get();
    }

    
    protected function validateData(array $data, $file = null, $isUpdate = false)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'date' => 'required|date',
            'coded_name' => 'nullable|string|max:255',
            'class_id' => 'nullable|exists:classes,id',
        ];

        if (!$isUpdate) {
            $rules['file'] = 'required|file|mimes:mp4,mp3|max:102400';
        } else {
            $rules['file'] = 'nullable|file|mimes:mp4,mp3|max:102400';
        }

        $validator = validator(array_merge($data, $file ? ['file' => $file] : []), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }


}