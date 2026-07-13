<?php

namespace App\Http\Controllers;

use App\Models\CareerPosition;
use App\Models\CareerApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $positions = CareerPosition::where('is_active', true)->get();
        return view('public.careers', compact('positions'));
    }

    public function apply(Request $request, CareerPosition $careerPosition)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'nullable|string|max:30',
            'cover_letter' => 'nullable|string|max:2000',
            'cv'           => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'local');
        }

        CareerApplication::create([
            'career_position_id' => $careerPosition->id,
            'name'               => $data['name'],
            'email'              => $data['email'],
            'phone'              => $data['phone'] ?? null,
            'cover_letter'       => $data['cover_letter'] ?? null,
            'cv_path'            => $cvPath,
        ]);

        return redirect()->back()->with('success', 'Application submitted! We will be in touch soon.');
    }
}
