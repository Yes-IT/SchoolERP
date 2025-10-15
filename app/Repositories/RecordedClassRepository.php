<?php

namespace App\Repositories;

use App\Interfaces\RecordedClassRepositoryInterface;
use App\Models\RecordedClass;
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

    
    public function update($id, array $data, $file = null)
    {
        $this->validateData($data, $file, true);

        $recordedClass = RecordedClass::findOrFail($id);

        if ($file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $type = $extension === 'mp4' ? 'video' : 'audio';
            if ($recordedClass->path) {
                Storage::disk('public')->delete($recordedClass->path);
            }
            $filePath = $file->store("recorded_classes/$type", 'public');
            $data['path'] = $filePath;
            $data['filename'] = $file->getClientOriginalName();
            $data['type'] = $type;
            $data['size'] = $file->getSize();
        }

        // Ensure coded_name is set if not provided
        $data['coded_name'] = $data['coded_name'] ?? $recordedClass->coded_name ?? '';

        $recordedClass->update($data);

        return [
            'message' => 'Recorded class updated successfully',
            'recordedClass' => $recordedClass
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
            'class_id' => 'required|exists:classes,id',
            'speaker' => 'required|string|max:255',
            'date' => 'required|date',
            'coded_name' => 'nullable|string|max:255',
        ];

        if (!$isUpdate) {
            $rules['file'] = 'required|file|mimes:mp4,mp3';
        } else {
            $rules['file'] = 'nullable|file|mimes:mp4,mp3';
        }

        $validator = validator(array_merge($data, $file ? ['file' => $file] : []), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

}