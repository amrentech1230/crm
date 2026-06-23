<?php

namespace App\Http\Controllers;
// use Illuminate\Support\Facades\File; // Add this line for importing the File facade
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Load;
use TCPDI;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Tcpdf\Fpdi;
use File;
use setasign\Fpdi\PdfParser\TcpdfParser;
use TCPDF;
use setasign\Fpdi\PdfReader;
use Carbon\Carbon;
use App\Helpers\LogActivity;

class FilesUploadController extends Controller
{
    public function index(int $filesId)
    {
        $load = Load::findOrFail($filesId);
        $uploadedFiles = json_decode($load->public_file, true);
        return view('files.files', compact('load', 'uploadedFiles'));
    }
    

    public function getFiles($recordId)
    {
        $record = Load::findOrFail($recordId);

        $files = json_decode($record->public_file, true);
    
        $fileList = [];
        foreach ($files as $field => $fileArray) {
            if (is_array($fileArray)) {
                foreach ($fileArray as $file) {
                    $fileList[] = asset('storage/' . $file); // Use storage path
                }
            } else {
                $fileList[] = asset('storage/' . $fileArray); // Use storage path
            }
        }
    
        return response()->json(['files' => $fileList]);
    }
    
    

    public function deleteFile(Request $request)
    {
        $recordId = $request->input('record_id');
        $fileName = $request->input('file_name');

        $record = Load::findOrFail($recordId);
        $files = json_decode($record->public_file, true);

        foreach ($files as $key => $fileArray) {
            if (is_array($fileArray)) {
                foreach ($fileArray as $index => $file) {
                    if (basename($file) == $fileName) {
                        unset($files[$key][$index]);
                        if (empty($files[$key])) {
                            unset($files[$key]);
                        }
                        File::delete(public_path($file));
                        break 2;
                    }
                }
            } else {
                if (basename($fileArray) == $fileName) {
                    unset($files[$key]);
                    File::delete(public_path($fileArray));
                    break;
                }
            }
        }

        $record->public_file = json_encode($files);
        $record->save();

        return response()->json(['success' => true]);
    }

public function showForm($loadId)
{
    // Retrieve the load
    $load = Load::findOrFail($loadId);
    
    // Get the uploaded files for this load
    $uploadedFiles = json_decode($load->public_file, true);
    
    // Pass the load and uploaded files to the view
    return view('files.files', compact('load', 'uploadedFiles'));
}


public function mergeFiles(Request $request)
{
    $recordId = $request->input('recordId');
    $inputFilePaths = $request->input('filePaths');

    try {
        $load = Load::findOrFail($recordId);
        $filePathsJson = $load->public_file;
        $filePaths = !empty($filePathsJson) ? json_decode($filePathsJson, true) : [];

        // Ensure inputFilePaths is an array, initialize if null
        if (is_null($inputFilePaths)) {
            $inputFilePaths = [];
        }

        // Merge the input file paths with the existing file paths
        $filePaths = array_merge($filePaths, $inputFilePaths);

        // Flatten and filter the filePaths to ensure they are strings
        $filePaths = array_filter($filePaths, 'is_string');

        $mergedFileName = 'load_' . $load->load_number . '.pdf';
        $outputPath = public_path('uploads/mergedfiles/' . $mergedFileName);

        // Create a new PDF document
        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        foreach ($filePaths as $filePath) {

            if (is_string($filePath) && file_exists(public_path($filePath))) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (strtolower($extension) === 'pdf') {
                    // Merge PDF
                    $pageCount = $pdf->setSourceFile(public_path($filePath));
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $tplIdx = $pdf->importPage($pageNo);
                        $pdf->AddPage();
                        $pdf->useTemplate($tplIdx, 10, 10, 200);
                    }
                } elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    // Add image to PDF
                    $pdf->AddPage();
                    $pdf->Image(public_path($filePath), 10, 10, 190, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);
                }
            }
        }

        // Output the merged file
        $pdf->Output($outputPath, 'F');

        return response()->json([
            'success' => true,
            'url' => asset('uploads/mergedfiles/' . $mergedFileName)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error merging files: ' . $e->getMessage()
        ], 500);
    }
}

public function uploadFiles(Request $request, int $filesId)
{
    // Validate incoming request
    $request->validate([
        'carrer_rate_cnfrm_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'pod_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'shipper_rate_approval_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'carrier_invoice_doc' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'do' => 'nullable|mimes:pdf,jpg,png|max:10240',
        'optional_docs.*' => 'nullable|mimes:pdf,jpg,png|max:10240',
    ]);

    $load = Load::findOrFail($filesId);

    // Decode existing file paths or initialize as an associative array
    $filePaths = json_decode($load->public_file, true) ?: [];

    // File fields to process
    $fileFields = [
        'carrer_rate_cnfrm_doc',
        'pod_doc',
        'shipper_rate_approval_doc',
        'carrier_invoice_doc',
        'do',
        'optional_docs'
    ];

    foreach ($fileFields as $field) {
        if ($request->hasFile($field)) {
            $files = $request->file($field);
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file->isValid()) {
					
					$originalName = $file->getClientOriginalName();
					$extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    // Build unique filename
                    $filename =  $field.'-'.$load->id.'.' . $extension;

                    // Define destination path
                    $relativeDirectory = 'uploads/Load-files/' . $load->load_number . '-' . $load->customer_id;
                    $destinationPath = public_path($relativeDirectory);

                    // Create directory if it doesn't exist
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0775, true);
                    }

                    // Move file to destination
                    $file->move($destinationPath, $filename);

                    // Build full relative path
                    $filePath = $relativeDirectory . '/' . $filename;

                    // Initialize field array if not already
                    if (!isset($filePaths[$field])) {
                        $filePaths[$field] = [];
                    }

                    // Append new file path
                    $filePaths[$field][] = $filePath;

                    // Special case: store 'do' field to its own column
                    if ($field === 'do') {
                        $load->load_delivery_do_file = $filePath;
                    }
                }
            }
        }
    }

    // Update database fields
    $load->public_file = json_encode($filePaths);
    $load->public_file_upload_date = Carbon::now();
    $load->save();

    return back()->with('success', 'Files uploaded successfully.');
}

public function deleteFilebroker(Request $request)
{
    $recordId = $request->input('record_id');
    $fileName = $request->input('file_name');
    
    $record = Load::find($recordId);

    if (!$record) {
        return response()->json(['error' => 'Record not found'], 404);
    }

    $files = json_decode($record->public_file, true);

    foreach ($files as $key => $fileArray) {
        if (is_array($fileArray)) {
            foreach ($fileArray as $index => $file) {
                if (basename($file) == basename($fileName)) {
                    unset($files[$key][$index]);
                    if (empty($files[$key])) {
                        unset($files[$key]);
                    }
                    File::delete(public_path($file));
                    break 2;
                }
            }
        } else {
            if (basename($fileArray) == basename($fileName)) {
                unset($files[$key]);
                File::delete(public_path($fileArray));
                break;
            }
        }
    }

    // Re-index the array to remove any gaps
    $files = array_values($files);

    $record->public_file = json_encode($files);
    $record->save();
    return response()->json(['success' => true]);
}


public function movefile(Request $request)
{
     $request->validate([
        'file' => 'required|string'
    ]);

    // e.g., "uploads/Load-files/2-1/filename.pdf"
    $relativePath = $request->input('file');
	$loadid = $request->input('load_id');
	
	$load = Load::findOrFail($loadid);
	$oldfiles = json_decode($load->load_delivery_do_file, false) ?? [];
	
    $fileName = basename($relativePath);

    $sourcePath = public_path($relativePath);
    $targetDir = public_path('uploads/delivery-order/'.$loadid.'/');
	$targetPath = $targetDir . $fileName;
    
	

    // Check if source file exists
    if (!file_exists($sourcePath)) {
        return response()->json(['success' => false, 'message' => 'Source file does not exist.']);
    }

    // Ensure target directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Attempt to copy the file
    if (!copy($sourcePath, $targetPath)) {
        return response()->json(['success' => false, 'message' => 'Failed to copy file.']);
    }
	
	$targetPathnew = 'uploads/delivery-order/'.$loadid.'/' . $fileName;
	
	$newfile[] = $targetPathnew;
	
	$relativeFromAbsolute = array_map(function ($path) {
		return str_replace(public_path() . '/', '', $path);
	}, $oldfiles);

	// Merge both relative arrays
	$merged = array_merge($relativeFromAbsolute, $newfile);

	// Optional: Remove duplicates
	$merged = array_unique($merged);
	
	
	$load->load_delivery_do_file = json_encode($merged);
	$load->save();
	
	$subject = "Public File move to private folder, filename:- ".$newfile;
    addToLog($customerId ='', $loadid, $subject, $oldData ='', $newData ='');

    return response()->json([
        'success' => true,
        'new_path' => 'uploads/private/' . $fileName
    ]);
}



    
}
