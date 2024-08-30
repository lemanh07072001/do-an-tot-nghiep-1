<?php

namespace App\Http\Controllers\Backend\AI;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use App\Http\Controllers\Controller;

class AIController extends Controller
{
    public function chat(Request $request)
    {

        $question = $request->valueData ?? 'Hello';
        $result   = Gemini::geminiPro()->generateContent($question);
        return response()->json(['result' => $result->text()]);
    }
}
