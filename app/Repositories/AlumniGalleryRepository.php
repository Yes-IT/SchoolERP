<?php

namespace App\Repositories;

use App\Interfaces\AlumniGalleryRepositoryInterface;
use App\Models\AlumniGallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AlumniGalleryRepository implements AlumniGalleryRepositoryInterface
{
    protected $model;

    public function __construct(AlumniGallery $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            throw new \Exception('Gallery item not found');
        }
        return $item;
    }

    public function create(array $data, $file)
    {
        // Validate input
        $validator = Validator::make(
            array_merge($data, ['file' => $file]),
            [
                'file' => [
                    'required',
                    'file',
                    function ($attribute, $value, $fail) {
                        $extension = strtolower($value->getClientOriginalExtension());
                        $size = $value->getSize();
                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        $maxSize = $isImage ? 5 * 1024 * 1024 : 10 * 1024 * 1024; // 5MB for images, 10MB for videos
                        if ($size > $maxSize) {
                            $fail("The {$attribute} must not exceed " . ($isImage ? '5MB' : '10MB') . " for " . ($isImage ? 'images' : 'videos') . ".");
                        }
                        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mov'])) {
                            $fail("The {$attribute} must be a file of type: jpg, jpeg, png, webp, mp4, mov.");
                        }
                    },
                ],
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Determine storage folder based on file type
        $extension = strtolower($file->getClientOriginalExtension());
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
        $folder = $isImage ? 'alumni_images' : 'alumni_videos';

        // Generate filename
        $filename = $file->getClientOriginalName();
        $encodedName = Str::random(40) . '.' . $extension;

        try {
            // Store the file on the 'public' disk
            $path = $file->storeAs($folder, $encodedName, 'public');

            // Verify file was stored
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('File failed to upload to storage.');
            }

            // Get file details
            $type = $extension;
            $size = $file->getSize();

            // Create gallery item
            $galleryItem = $this->model->create([
                'filename' => $filename,
                'encoded_name' => $encodedName,
                'path' => "{$folder}/{$encodedName}",
                'type' => $type,
                'size' => $size,
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
            ]);

            DB::commit();

            return [
                'message' => 'File uploaded successfully',
                'galleryItem' => [
                    'id' => $galleryItem->id,
                    'path' => Storage::disk('public')->url($galleryItem->path),
                    'title' => $galleryItem->title,
                    'type' => $galleryItem->type,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('An error occurred while uploading the file: ' . $e->getMessage());
        }
    }


    public function update($id, array $data, $file = null)
    {
        $galleryItem = $this->find($id);

        // Validate input
        $validator = Validator::make(
            array_merge($data, ['file' => $file]),
            [
                'file' => [
                    'nullable',
                    'file',
                    function ($attribute, $value, $fail) use ($file) {
                        if ($file) {
                            $extension = strtolower($value->getClientOriginalExtension());
                            $size = $value->getSize();
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                            $maxSize = $isImage ? 5 * 1024 * 1024 : 10 * 1024 * 1024; // 5MB for images, 10MB for videos
                            if ($size > $maxSize) {
                                $fail("The {$attribute} must not exceed " . ($isImage ? '5MB' : '10MB') . " for " . ($isImage ? 'images' : 'videos') . ".");
                            }
                            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mov'])) {
                                $fail("The {$attribute} must be a file of type: jpg, jpeg, png, webp, mp4, mov.");
                            }
                        }
                    },
                ],
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $attributes = [
                'title' => $data['title'] ?? $galleryItem->title,
                'description' => $data['description'] ?? $galleryItem->description,
            ];

            if ($file) {
                // Delete old file
                Storage::disk('public')->delete($galleryItem->path);

                // Store new file
                $extension = strtolower($file->getClientOriginalExtension());
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                $folder = $isImage ? 'alumni_images' : 'alumni_videos';
                $filename = $file->getClientOriginalName();
                $encodedName = Str::random(40) . '.' . $extension;
                $path = $file->storeAs($folder, $encodedName, 'public');

                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('File failed to upload to storage.');
                }

                $attributes = array_merge($attributes, [
                    'filename' => $filename,
                    'encoded_name' => $encodedName,
                    'path' => "{$folder}/{$encodedName}",
                    'type' => $extension,
                    'size' => $file->getSize(),
                ]);
            }

            $galleryItem->update($attributes);

            DB::commit();

            return [
                'message' => 'File updated successfully',
                'galleryItem' => [
                    'id' => $galleryItem->id,
                    'path' => Storage::disk('public')->url($galleryItem->path),
                    'title' => $galleryItem->title,
                    'type' => $galleryItem->type,
                ]
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('An error occurred while updating the file: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        $galleryItem = $this->find($id);

        DB::beginTransaction();
        try {
            // Delete file from storage
            Storage::disk('public')->delete($galleryItem->path);

            // Delete database record
            $galleryItem->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Error deleting gallery item: ' . $e->getMessage());
        }
    }


}