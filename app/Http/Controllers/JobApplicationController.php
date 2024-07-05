<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplication::orderBy('created_at', 'DESC')->with('job', 'user')->paginate(10);
        return view('admin.job-applications.list', [
            'jobApplications' => $jobApplications
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $jobApplication = JobApplication::find($id);

        if ($jobApplication == null) {
            session()->flash('error', 'Job Application not found');
            return response()->json([
                'status' => false
            ]);
        }

        $jobApplication->delete();
        session()->flash('success', 'Job Application deleted successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
