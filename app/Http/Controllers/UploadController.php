<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {

        try {

            if ($request->hasFile('file')) {
                $files = $request->file('file');
                $pathFull = 'upload';
                $storedFiles = [];

                if (is_array($files)) {
                    // Lặp qua từng file trong mảng
                    foreach ($files as $file) {
                        $name = $file->getClientOriginalName();
                        $path = $file->storeAs($pathFull, $name);

                        array_push($storedFiles,'storage/' . $pathFull . '/' . $name);
                        // $storedFiles[] = 'storage/' . $pathFull . '/' . $name;
                    }
                } else {
                    // Nếu chỉ có một file
                    $name = $files->getClientOriginalName();
                    $path = $files->storeAs($pathFull, $name);
                    $storedFiles[] = 'storage/' . $pathFull . '/' . $name;
                }


                return response()->json( $storedFiles);
            }
        } catch (\Exception $error) {
            return response()->json(['error' => 'File upload failed'], 500);
        }
    }

}
