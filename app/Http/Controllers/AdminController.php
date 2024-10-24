<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
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
    
    

    public function deactivateUser($userId) {
        $user = User::find($userId);
        if ($user) {
            $user->status = 'inactive';
            $user->save();
            return redirect()->back()->with('message', 'User account deactivated successfully.');
        }
        return redirect()->back()->withErrors('User not found.');
    }

    public function reactivateUser($id) {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return response()->json(['message' => 'User reactivated successfully']);
    }
    
    
}
