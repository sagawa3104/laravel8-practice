<?php

namespace App\Http\Controllers;

use App\Models\InspectingForm;
use App\Models\Process;
use Illuminate\Http\Request;

class InspectingFormController extends Controller
{
    //
    public function index()
    {
        $inspectingForms = InspectingForm::all();
        return view('inspecting-forms.index', [
            'inspectingForms' => $inspectingForms,
        ]);
    }
}
