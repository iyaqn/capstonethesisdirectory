<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\User;
use App\Models\Notification;

class StudentController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'ipRegistration' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'authors' => 'array',
            'authors.*' => 'string|max:255', // Validate each author name in the array
            'technicalAdviser' => 'required|string|max:255',
            'yearPublished' => 'required|integer',
            'fullDocument' => 'nullable|file',
            'acmPaper' => 'nullable|file',
            'sourceCode' => 'nullable|string',
            'approvalForm' => 'nullable|file',
            'keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
            'course' => 'nullable|string',
        ]);
    
        $project = new Project();
        $project->fill($validated);
    
        // Sanitize title for filenames
        $sanitizedTitle = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $validated['title']);
    
        // Handle file uploads
        if ($request->hasFile('fullDocument')) {
            $fullDocument = $request->file('fullDocument');
            $fullDocumentFilename = $sanitizedTitle . '_Full_Document.' . $fullDocument->getClientOriginalExtension();
            
            // Store the file with the custom filename
            $project->fullDocument = $fullDocument->storeAs('documents', $fullDocumentFilename, 'public');
    
            // Make a POST request to the external API to get keywords
            $response = Http::attach(
                'file',
                file_get_contents($fullDocument->getRealPath()),
                $fullDocument->getClientOriginalName()
            )->post('https://file-keywords-generator-production.up.railway.app/api/keywords-generator/file-upload/');
            
            if ($response->successful()) {
                $keywordsData = $response->json();
                if (isset($keywordsData['keywords']) && is_array($keywordsData['keywords'])) {
                    $project->keywords = implode(', ', $keywordsData['keywords']);
                } else {
                    $project->keywords = null;
                }
            } else {
                return back()->withErrors(['message' => 'Failed to generate keywords from the document.']);
            }
        }
    
        if ($request->hasFile('acmPaper')) {
            $acmPaper = $request->file('acmPaper');
            $acmPaperFilename = $sanitizedTitle . '_ACM_Paper.' . $acmPaper->getClientOriginalExtension();
            
            // Store the file with the custom filename
            $project->acmPaper = $acmPaper->storeAs('documents', $acmPaperFilename, 'public');
        }
    
    
        // Save the project
        $project->save();

        //Logger
        $user = Auth::user();

        Log::create([
            'user_id' => $user->id,           // Laravel automatically handles this relation
            'action' => 'Added a new project called ' . $sanitizedTitle,
            'created_at' => now(),
        ]);

    // Notify all admins
    $adminUsers = User::where('user_type', 'Admin')->get();
    foreach ($adminUsers as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'project_submission',
            'message' => "A new project titled '{$project->title}' has been submitted by {$user->name}.",
        ]);
    }

    
        // Redirect based on the course attribute
        switch ($project->course) {
            case 'IT':
                return redirect()->route('admin/ip-registered/IT-cap')->with('success', 'Capstone project added successfully!');
            case 'CS':
                return redirect()->route('admin/ip-registered/CS-thes')->with('success', 'Capstone project added successfully!');
            case 'IS':
                return redirect()->route('admin/ip-registered/IS-cap')->with('success', 'Capstone project added successfully!');
            default:
                return redirect()->back()->with('success', 'Capstone project added successfully!');
        }
    }
    

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'ipRegistration' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'authors' => 'array',
            'authors.*' => 'string|max:255', // Validate each author name in the array
            'technicalAdviser' => 'required|string|max:255',
            'yearPublished' => 'required|integer',
            'fullDocument' => 'nullable|file',
            'acmPaper' => 'nullable|file',
            'sourceCode' => 'nullable|string',
            'approvalForm' => 'nullable|file',
            'keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:255',
        ]);
    
        // Find the existing project by its ID
        $project = Project::findOrFail($id);
        
        // Update the project with the validated data
        $project->fill($validated);
    
        // Sanitize title for filenames
        $sanitizedTitle = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $validated['title']);
    
        // Handle file uploads
        if ($request->hasFile('fullDocument')) {
            $fullDocument = $request->file('fullDocument');
            $fullDocumentFilename = $sanitizedTitle . '_Full_Document.' . $fullDocument->getClientOriginalExtension();
            
            // Store the file with the custom filename
            $project->fullDocument = $fullDocument->storeAs('documents', $fullDocumentFilename, 'public');
    
            // Make a POST request to the external API to get keywords
            $response = Http::attach(
                'file',
                file_get_contents($fullDocument->getRealPath()),
                $fullDocument->getClientOriginalName()
            )->post('https://file-keywords-generator-production.up.railway.app/api/keywords-generator/file-upload/');
            
            if ($response->successful()) {
                $keywordsData = $response->json();
                if (isset($keywordsData['keywords']) && is_array($keywordsData['keywords'])) {
                    $project->keywords = implode(', ', $keywordsData['keywords']);
                } else {
                    $project->keywords = null;
                }
            } else {
                return back()->withErrors(['message' => 'Failed to generate keywords from the document.']);
            }
        }
    
        if ($request->hasFile('acmPaper')) {
            $acmPaper = $request->file('acmPaper');
            $acmPaperFilename = $sanitizedTitle . '_ACM_Paper.' . $acmPaper->getClientOriginalExtension();
            
            // Store the file with the custom filename
            $project->acmPaper = $acmPaper->storeAs('documents', $acmPaperFilename, 'public');
        }
    
    
        // Save the updated project
        $project->save();


        //Logger
        $user = Auth::user();

        Log::create([
            'user_id' => $user->id,           
            'action' => 'Edited a project called ' . $sanitizedTitle,
            'updated_at' => now(),
        ]);

    // Notify all admins
    $adminUsers = User::where('user_type', 'Admin')->get();
    foreach ($adminUsers as $admin) {
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'project_edit',
            'message' => "A project titled '{$project->title}' has been edited by {$user->name}.",
        ]);
    }
    
        // Redirect based on the course attribute
        switch ($project->course) {
            case 'IT':
                return redirect()->route('admin/ip-registered/IT-cap')->with('success', 'Capstone project updated successfully!');
            case 'CS':
                return redirect()->route('admin/ip-registered/CS-thes')->with('success', 'Capstone project updated successfully!');
            case 'IS':
                return redirect()->route('admin/ip-registered/IS-cap')->with('success', 'Capstone project updated successfully!');
            default:
                return redirect()->back()->with('success', 'Capstone project updated successfully!');
        }


        
    }
}
