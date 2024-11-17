<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Notification;
class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */

    public function getFacultyMembers() {
        $faculty = User::where('user_type', 'faculty')->get();
        return response()->json($faculty);
    }
    public function updateDepartment(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->user_course = $request->department;
        $user->save();
        return response()->json(['message' => 'Department updated successfully']);
    }
    public function updateCoordinator(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->is_coordinator = $request->is_coordinator;
        $user->save();
        return response()->json(['message' => 'Coordinator status updated successfully']);
    }
    
    

    public function deactivateUser($id) {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();
    
        return response()->json(['message' => 'User deactivated successfully']);
    }

    public function reactivateUser($id) {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return response()->json(['message' => 'User reactivated successfully']);
    }
    

    public function approveProject(Request $request, $id)
{
    $project = Project::findOrFail($id);

    if ($request->status == 'approve') {
        $project->status = 'approved';
        $message = 'Your project has been approved.';
    } elseif ($request->status == 'reject') {
        $project->status = 'rejected';
        $message = 'Your project has been rejected.';
    }

    $project->save();

    // Notify the student
    Notification::create([
        'user_id' => $project->user_id, // Student who submitted the project
        'message' => $message,
    ]);

    return redirect()->back()->with('success', 'Project status updated.');
}
    
}
