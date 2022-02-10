<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInspectingFormRequest;
use App\Models\InspectingForm;
use App\Models\Process;
use App\Models\Product;
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

    public function edit(InspectingForm $inspecting_form)
    {
        return view('inspecting-forms.edit', [
            'inspectingForm' => $inspecting_form,
        ]);
    }

    public function update(UpdateInspectingFormRequest $request, InspectingForm $inspecting_form)
    {
        $input = $request->all();

        $inspecting_form->form = $input['form'];
        $inspecting_form->save();

        return redirect(route('inspecting-forms.index'));
    }

    public function createByProcess(Process $process)
    {
        return view('inspecting-forms.create-by-process', [

        ]);
    }

    public function createByProduct(Product $product)
    {
        return view('inspecting-forms.create-by-process', [

        ]);
    }

    public function storeByProcess(Process $process)
    {
        return redirect(route('inspecting-forms.index'));
    }

    public function storeByProduct(Product $product)
    {
        return redirect(route('inspecting-forms.index'));
    }
}
