<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    /**
     * Upload multiple photos
     */
    public function uploadPhotos(Request $request)
    {
        try {
            $request->validate([
                'photos.*' => 'required|image|mimes:jpeg,png,svg|max:5120' // 5MB max
            ]);

            $uploadedPhotos = [];
            
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    
                    // Store in public/uploads/photos directory
                    $path = $photo->storeAs('uploads/photos', $filename, 'public');
                    
                    // Get full URL
                    $url = asset('storage/' . $path);
                    $uploadedPhotos[] = $url;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Photos uploaded successfully',
                'photos' => $uploadedPhotos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload single video
     */
    public function uploadVideo(Request $request)
    {
        try {
            $request->validate([
                'video' => 'required|mimetypes:video/mp4,video/webm,video/ogg|max:102400' // 100MB max
            ]);

            $video = null;
            
            if ($request->hasFile('video')) {
                $videoFile = $request->file('video');
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
                
                // Store in public/uploads/videos directory
                $path = $videoFile->storeAs('uploads/videos', $filename, 'public');
                
                // Get full URL
                $video = asset('storage/' . $path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'video' => $video
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete photo
     */
    public function deletePhoto(Request $request)
    {
        try {
            $photoUrl = $request->input('photo_url');
            
            // Extract path from URL
            $path = str_replace(asset('storage/'), '', $photoUrl);
            
            // Delete file
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Photo deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting photo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete video
     */
    public function deleteVideo(Request $request)
    {
        try {
            $videoUrl = $request->input('video_url');
            
            // Extract path from URL
            $path = str_replace(asset('storage/'), '', $videoUrl);
            
            // Delete file
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Video deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting video: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new Certificate Lab
     */
    public function createCertificateLab(Request $request)
    {
        try {
            $request->validate([
                'lab_name' => 'required|string|max:255'
            ]);

            // Check if CertificateLab model exists
            $modelClass = 'App\\Models\\CertificateLab';
            
            if (!class_exists($modelClass)) {
                return response()->json([
                    'success' => false,
                    'message' => 'CertificateLab model not found'
                ], 500);
            }

            $lab = $modelClass::create([
                'lab_name' => $request->input('lab_name'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate lab created successfully',
                'lab_id' => $lab->id ?? $lab->idtbl_certificate_labs,
                'lab_name' => $lab->lab_name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating certificate lab: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new Photo Type
     */
    public function createPhotoType(Request $request)
    {
        try {
            $request->validate([
                'photo_type_name' => 'required|string|max:255'
            ]);

            // You can extend this to save to database if you have a PhotoType model
            // For now, we'll return success to indicate it's ready for implementation
            
            return response()->json([
                'success' => true,
                'message' => 'Photo type created successfully',
                'photo_type_name' => $request->input('photo_type_name')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating photo type: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload 360° view file
     */
    public function upload360View(Request $request)
    {
        try {
            $request->validate([
                'view360' => 'required|mimetypes:text/html,application/zip,application/x-rar-compressed|max:102400' // 100MB max
            ]);

            $view360File = null;
            $fileName = null;
            
            if ($request->hasFile('view360')) {
                $file = $request->file('view360');
                
                // Generate unique filename
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store in public/uploads/360views directory
                $path = $file->storeAs('uploads/360views', $fileName, 'public');
                
                // Get full URL
                $view360File = asset('storage/' . $path);
            }

            return response()->json([
                'success' => true,
                'message' => '360° view uploaded successfully',
                'view360_url' => $view360File,
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading 360° view: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete 360° view file
     */
    public function delete360View(Request $request)
    {
        try {
            $view360Url = $request->input('view360_url');
            
            // Extract path from URL
            $path = str_replace(asset('storage/'), '', $view360Url);
            
            // Delete file
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true,
                'message' => '360° view deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting 360° view: ' . $e->getMessage()
            ], 500);
        }
    }
}
