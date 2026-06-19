# Photo and Video Upload Implementation Guide

## Overview
The media upload system has been successfully implemented with the following features:
- **Photo Upload**: Upload multiple photos (JPG, PNG, SVG)
- **Video Upload**: Upload single video file (MP4, WebM, OGG)
- **Live Preview**: See image/video previews before saving
- **Save Functionality**: Upload and store files on the server
- **Delete Option**: Remove uploaded files with confirmation
- **View Full Image**: Click on photos to view in full screen

## Features Implemented

### 1. **Photo Upload Section**
- Click the upload box or use file input to select photos
- Support for multiple photos at once
- Live preview of selected photos
- "Save Photos" button to upload all selected photos
- Display section showing all uploaded photos
- Delete button on hover to remove individual photos
- Click any photo to view in full screen

### 2. **Video Upload Section**
- Click the upload box or use file input to select a video
- Support for single video upload
- Live preview with video player
- "Save Video" button to upload the selected video
- Display section showing the uploaded video
- Delete button to remove the video

### 3. **File Validation**
- **Photos**: JPG, PNG, SVG formats only (max 5MB)
- **Videos**: MP4, WebM, OGG formats only (max 100MB)

### 4. **User Experience**
- Instant preview before upload
- Upload progress feedback (button changes to "Uploading...")
- Success/error messages via alerts
- Hover effects on photos/videos with delete option
- Responsive design with Tailwind CSS

## Technical Details

### Backend Files Created/Modified

1. **`app/Http/Controllers/MediaUploadController.php`** (NEW)
   - `uploadPhotos()`: Handles multiple photo uploads
   - `uploadVideo()`: Handles single video upload
   - `deletePhoto()`: Removes photo from storage
   - `deleteVideo()`: Removes video from storage

2. **`routes/api.php`** (MODIFIED)
   - Added POST `/api/upload-photos` route
   - Added POST `/api/upload-video` route
   - Added DELETE `/api/delete-photo` route
   - Added DELETE `/api/delete-video` route

3. **`resources/views/inventory/myinventory/fullpage/fullpage/partials/_media.blade.php`** (MODIFIED)
   - Added file input fields for photos and videos
   - Added preview containers
   - Added save buttons
   - Added saved media display containers
   - Enhanced JavaScript with upload/delete logic

### Storage Configuration
Files are stored in:
- **Photos**: `storage/app/public/uploads/photos/`
- **Videos**: `storage/app/public/uploads/videos/`

These are accessible via:
- **Photos**: `https://yoursite.com/storage/uploads/photos/filename`
- **Videos**: `https://yoursite.com/storage/uploads/videos/filename`

## How to Use

### Uploading Photos
1. Click on the photo upload box in the "Photos" section
2. Select one or multiple image files (JPG, PNG, SVG)
3. See live preview of selected photos
4. Click "Save Photos" button
5. Photos will be uploaded to the server
6. Uploaded photos appear below with delete option

### Uploading Video
1. Click on the video upload box in the "Product Video" section
2. Select a video file (MP4, WebM, OGG)
3. See live preview with video player
4. Click "Save Video" button
5. Video will be uploaded to the server
6. Uploaded video appears below with delete option

### Deleting Media
1. Hover over any uploaded photo/video
2. Click the "×" delete button
3. Confirm deletion in the popup
4. File is removed from the server

## Error Handling
- Invalid file formats are rejected before upload
- File size limits are enforced
- Network errors are caught and reported
- User-friendly error messages

## Requirements
- Laravel 8+ (or your installed version)
- PHP 7.4+
- SQLite or Database configured
- Public disk configured in `config/filesystems.php`

## Important Notes
1. **CSRF Token**: Ensure your Blade template includes `<meta name="csrf-token" content="{{ csrf_token() }}">`
2. **Storage Link**: Run `php artisan storage:link` to create the storage symlink for public access
3. **Permissions**: Ensure `storage/app/public/` directory has write permissions
4. **File Limits**: Adjust MAX sizes in controller as needed:
   - Photos: Change `5120` (5MB) in validation
   - Videos: Change `102400` (100MB) in validation

## Customization

### To Change File Size Limits
Edit `MediaUploadController.php`:
```php
// For photos (in KB)
'photos.*' => 'required|image|mimes:jpeg,png,svg|max:5120'

// For videos (in KB)
'video' => 'required|mimetypes:video/mp4,video/webm,video/ogg|max:102400'
```

### To Change Allowed Formats
Edit the validation rules in `MediaUploadController.php` and the `accept` attributes in `_media.blade.php`:
```php
// Controller
'mimes:jpeg,png,svg' // or 'mimes:jpeg,png,gif,webp'

// Blade
accept="image/jpeg,image/png,image/svg+xml" // or add more formats
```

## Testing
To test the functionality:
1. Navigate to the inventory page with the media section
2. Try uploading a photo/video
3. Check if the file appears in the saved section
4. Try deleting it
5. Verify the file is removed from both UI and storage

## Troubleshooting
- **"Page not found" when uploading**: Ensure routes are properly registered
- **"Permission denied" error**: Check storage directory permissions
- **Files not accessible after upload**: Run `php artisan storage:link`
- **CSRF token errors**: Add CSRF meta tag to your base layout

## Future Enhancements
- Add drag-and-drop functionality
- Add progress bar for uploads
- Add file size indicator
- Add image cropping tool
- Add video thumbnail generation
- Add multiple video support
