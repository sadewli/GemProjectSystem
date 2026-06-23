<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MediaUploadController extends Controller
{
    private function getProductId(Request $request) {
        $productId = $request->input('product_id');
        if (!$productId || !is_numeric($productId)) {
            // fallback to checking the referer URL if product_id is not passed
            $referer = $request->headers->get('referer');
            if ($referer) {
                $parts = explode('/', parse_url($referer, PHP_URL_PATH));
                $last = end($parts);
                if (is_numeric($last)) {
                    $productId = $last;
                }
            }
        }
        return $productId ?: 1; // Default to 1 if not found to avoid DB constraint error
    }

    private function getUserId() {
        return Session::get('userid') ?: 1;
    }

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
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();

            // Ensure media master exists
            $mediaType = DB::table('tbl_media_types')->where('type_name', 'photo')->first();
            $masterId = DB::table('tbl_product_media_master')->where('idtbl_products', $productId)->where('idtbl_media_types', $mediaType->idtbl_media_types)->value('idtbl_product_media_master');
            
            if (!$masterId) {
                $masterId = DB::table('tbl_product_media_master')->insertGetId([
                    'idtbl_products' => $productId,
                    'idtbl_media_types' => $mediaType->idtbl_media_types,
                    'status' => 1,
                    'insertuser' => $userId,
                    'insertdatetime' => now()
                ]);
            }
            
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs('uploads/photos', $filename, 'public');
                    $url = asset('storage/' . $path);
                    $uploadedPhotos[] = $url;

                    DB::table('tbl_product_media_details')->insert([
                        'idtbl_product_media_master' => $masterId,
                        'file_name' => $photo->getClientOriginalName(),
                        'file_path' => $url,
                        'file_size' => $photo->getSize(),
                        'is_primary' => 0,
                        'sort_order' => 0,
                        'status' => 1,
                        'insertuser' => $userId,
                        'insertdatetime' => now()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Photos uploaded successfully',
                'photos' => $uploadedPhotos
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error uploading photos: ' . $e->getMessage()], 500);
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
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();
            
            // Ensure media master exists
            $mediaType = DB::table('tbl_media_types')->where('type_name', 'video')->first();
            $masterId = DB::table('tbl_product_media_master')->where('idtbl_products', $productId)->where('idtbl_media_types', $mediaType->idtbl_media_types)->value('idtbl_product_media_master');
            
            if (!$masterId) {
                $masterId = DB::table('tbl_product_media_master')->insertGetId([
                    'idtbl_products' => $productId,
                    'idtbl_media_types' => $mediaType->idtbl_media_types,
                    'status' => 1,
                    'insertuser' => $userId,
                    'insertdatetime' => now()
                ]);
            }

            if ($request->hasFile('video')) {
                $videoFile = $request->file('video');
                $filename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
                $path = $videoFile->storeAs('uploads/videos', $filename, 'public');
                $video = asset('storage/' . $path);

                DB::table('tbl_product_media_details')->insert([
                    'idtbl_product_media_master' => $masterId,
                    'file_name' => $videoFile->getClientOriginalName(),
                    'file_path' => $video,
                    'file_size' => $videoFile->getSize(),
                    'is_primary' => 0,
                    'sort_order' => 0,
                    'status' => 1,
                    'insertuser' => $userId,
                    'insertdatetime' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'video' => $video
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error uploading video: ' . $e->getMessage()], 500);
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
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();

            $mediaType = DB::table('tbl_media_types')->where('type_name', 'view360')->first();
            $masterId = DB::table('tbl_product_media_master')->where('idtbl_products', $productId)->where('idtbl_media_types', $mediaType->idtbl_media_types)->value('idtbl_product_media_master');
            
            if (!$masterId) {
                $masterId = DB::table('tbl_product_media_master')->insertGetId([
                    'idtbl_products' => $productId,
                    'idtbl_media_types' => $mediaType->idtbl_media_types,
                    'status' => 1,
                    'insertuser' => $userId,
                    'insertdatetime' => now()
                ]);
            }

            if ($request->hasFile('view360')) {
                $file = $request->file('view360');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/360views', $fileName, 'public');
                $view360File = asset('storage/' . $path);

                DB::table('tbl_product_media_details')->insert([
                    'idtbl_product_media_master' => $masterId,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $view360File,
                    'file_size' => $file->getSize(),
                    'is_primary' => 0,
                    'sort_order' => 0,
                    'status' => 1,
                    'insertuser' => $userId,
                    'insertdatetime' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => '360° view uploaded successfully',
                'view360_url' => $view360File,
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error uploading 360° view: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete photo
     */
    public function deletePhoto(Request $request)
    {
        try {
            $photoUrl = $request->input('photo_url');
            $path = str_replace(asset('storage/'), '', $photoUrl);
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            DB::table('tbl_product_media_details')->where('file_path', $photoUrl)->update(['status' => 0]);

            return response()->json(['success' => true, 'message' => 'Photo deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting photo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete video
     */
    public function deleteVideo(Request $request)
    {
        try {
            $videoUrl = $request->input('video_url');
            $path = str_replace(asset('storage/'), '', $videoUrl);
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            DB::table('tbl_product_media_details')->where('file_path', $videoUrl)->update(['status' => 0]);

            return response()->json(['success' => true, 'message' => 'Video deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting video: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete 360° view file
     */
    public function delete360View(Request $request)
    {
        try {
            $view360Url = $request->input('view360_url');
            $path = str_replace(asset('storage/'), '', $view360Url);
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            DB::table('tbl_product_media_details')->where('file_path', $view360Url)->update(['status' => 0]);

            return response()->json(['success' => true, 'message' => '360° view deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting 360° view: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Upload Certificate
     */
    public function uploadCertificate(Request $request)
    {
        try {
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();

            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/certificates', $filename, 'public');
                $filePath = asset('storage/' . $path);
            }

            DB::table('tbl_product_certificates')->insert([
                'idtbl_products' => $productId,
                'idtbl_certificate_labs' => $request->input('certificate_lab') ?: 1,
                'report_number' => $request->input('report_number'),
                'certificate_url' => $request->input('certificate_url'),
                'file_path' => $filePath,
                'status' => 1,
                'insertuser' => $userId,
                'insertdatetime' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate uploaded successfully',
                'data' => [
                    'lab' => $request->input('certificate_lab_name') ?: 'Lab',
                    'report_number' => $request->input('report_number'),
                    'url' => $request->input('certificate_url'),
                    'file_path' => $filePath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Upload Document
     */
    public function uploadDocument(Request $request)
    {
        try {
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();

            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/documents', $filename, 'public');
                $filePath = asset('storage/' . $path);
            }

            DB::table('tbl_product_documents')->insert([
                'idtbl_products' => $productId,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'file_path' => $filePath,
                'status' => 1,
                'insertuser' => $userId,
                'insertdatetime' => now()
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Document uploaded successfully', 
                'data' => [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'file_path' => $filePath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Upload Traceability Document
     */
    public function uploadTraceability(Request $request)
    {
        try {
            $productId = $this->getProductId($request);
            $userId = $this->getUserId();

            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/traceability', $filename, 'public');
                $filePath = asset('storage/' . $path);
            }

            DB::table('tbl_product_traceability_docs')->insert([
                'idtbl_products' => $productId,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'file_path' => $filePath,
                'status' => 1,
                'insertuser' => $userId,
                'insertdatetime' => now()
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Traceability uploaded successfully', 
                'data' => [
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'file_path' => $filePath
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
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

            $id = DB::table('tbl_certificate_labs')->insertGetId([
                'lab_name' => $request->input('lab_name'),
                'status' => 1,
                'insertuser' => $this->getUserId(),
                'insertdatetime' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Certificate lab created successfully',
                'lab_id' => $id,
                'lab_name' => $request->input('lab_name')
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating certificate lab: ' . $e->getMessage()], 500);
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

            $id = DB::table('tbl_media_types')->insertGetId([
                'type_name' => $request->input('photo_type_name'),
                'status' => 1,
                'insertuser' => $this->getUserId(),
                'insertdatetime' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo type created successfully',
                'photo_type_name' => $request->input('photo_type_name')
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating photo type: ' . $e->getMessage()], 500);
        }
    }
}
