<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;


class ProjectController extends Controller
{
    //
    public function createIT(): Response
    {
        return Inertia::render('AdminView/AdminAddITCap');
    }
    public function createIS(): Response
    {
        return Inertia::render('AdminView/AdminAddISCap');
    }

    public function createCS(): Response
    {
        return Inertia::render('AdminView/AdminAddCSThes');
    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'ipRegistration' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'author1' => 'required|string|max:255',
            'author2' => 'nullable|string|max:255',
            'author3' => 'nullable|string|max:255',
            'author4' => 'nullable|string|max:255',
            'technicalAdviser' => 'required|string|max:255',
            'yearPublished' => 'required|integer',
            'fullDocument' => 'nullable|file',
            'acmPaper' => 'nullable|file',
            'sourceCode' => 'nullable|file',
            'approvalForm' => 'nullable|file',
            'keywords' => 'required|string|max:255',
            'course' => 'nullable|string',
        ]);

        // Store the capstone project
        $project = new Project();
        $project->fill($validated);

        // Handle file uploads
        if ($request->hasFile('fullDocument')) {
            $project->fullDocument = $request->file('fullDocument')->store('documents', 'public');
        }
        if ($request->hasFile('acmPaper')) {
            $project->acmPaper = $request->file('acmPaper')->store('documents', 'public');
        }
        if ($request->hasFile('sourceCode')) {
            $project->sourceCode = $request->file('sourceCode')->store('documents', 'public');
        }
        if ($request->hasFile('approvalForm')) {
            $project->approvalForm = $request->file('approvalForm')->store('documents', 'public');
        }

        // Save the capstone project
        $project->save();

    // Redirect to respective view pages based on the course
    if ($project->course === 'IT') {
        return redirect()->route('admin/ip-registered/IT-cap')->with('success', 'Capstone project added successfully!');
    } elseif ($project->course === 'CS') {
        return redirect()->route('admin/ip-registered/CS-thes')->with('success', 'Capstone project added successfully!');
    } elseif ($project->course === 'IS') {
        return redirect()->route('admin/ip-registered/IS-cap')->with('success', 'Capstone project added successfully!');
    }

    // Fallback redirection (optional)
    return redirect()->back()->with('success', 'Capstone project added successfully!');
    }
    
    public function editIT($id)
{
    // Fetch the project by ID
    $project = Project::findOrFail($id);

    // Pass the project data to the Inertia view
    return Inertia::render('AdminView/AdminEditITCap', [
        'project' => $project
    ]);
}
    public function editIS($id)
    {
        $project = Project::findOrFail($id);

        return Inertia::render('AdminView/AdminEditCSThesis', [
            'project' => $project,
        ]);
    }

    public function editCS($id)
    {
        $project = Project::findOrFail($id);

        return Inertia::render('AdminView/AdminEditCSThesis', [
            'project' => $project,
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'ipRegistration' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'author1' => 'required|string|max:255',
            'author2' => 'nullable|string|max:255',
            'author3' => 'nullable|string|max:255',
            'author4' => 'nullable|string|max:255',
            'technicalAdviser' => 'required|string|max:255',
            'yearPublished' => 'required|integer',
            'fullDocument' => 'nullable|file',
            'acmPaper' => 'nullable|file',
            'sourceCode' => 'nullable|file',
            'approvalForm' => 'nullable|file',
            'keywords' => 'required|string|max:255',
        ]);
    
        // Find the existing project by its ID
        $project = Project::findOrFail($id);
    
        // Update the project with the validated data
        $project->fill($validated);
    
        // Handle file uploads
        if ($request->hasFile('fullDocument')) {
            $project->fullDocument = $request->file('fullDocument')->store('documents', 'public');
        }
        if ($request->hasFile('acmPaper')) {
            $project->acmPaper = $request->file('acmPaper')->store('documents', 'public');
        }
        if ($request->hasFile('sourceCode')) {
            $project->sourceCode = $request->file('sourceCode')->store('documents', 'public');
        }
        if ($request->hasFile('approvalForm')) {
            $project->approvalForm = $request->file('approvalForm')->store('documents', 'public');
        }
    
        // Save the updated project
        $project->save();
    
        // Redirect to respective view pages based on the course
        if ($project->course === 'IT') {
            return redirect()->route('admin/ip-registered/IT-cap')->with('success', 'Capstone project updated successfully!');
        } elseif ($project->course === 'CS') {
            return redirect()->route('admin/ip-registered/CS-thes')->with('success', 'Capstone project updated successfully!');
        } elseif ($project->course === 'IS') {
            return redirect()->route('admin/ip-registered/IS-cap')->with('success', 'Capstone project updated successfully!');
        }
    
        // Fallback redirection (optional)
        return redirect()->back()->with('success', 'Capstone project updated successfully!');
    }
    
    



    public function viewITCapstones(Request $request)
    {
        $searchQuery = $request->input('search');
    
        // Fetch IT capstone projects from the database with pagination and optional search filtering
        $itCapstoneProjects = Project::where('course', 'IT')
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->where(function ($query) use ($searchQuery) {
                    $query->where('title', 'LIKE', "%$searchQuery%")
                        ->orWhere('ipRegistration', 'LIKE', "%$searchQuery%")
                        ->orWhere('author1', 'LIKE', "%$searchQuery%")
                        ->orWhere('author2', 'LIKE', "%$searchQuery%")
                        ->orWhere('author3', 'LIKE', "%$searchQuery%")
                        ->orWhere('author4', 'LIKE', "%$searchQuery%")
                        ->orWhere('keywords', 'LIKE', "%$searchQuery%");
                        
                });
            })
            ->paginate(10); // Adjust the number of items per page
    
        // Pass the paginated data to the Inertia view
        return Inertia::render('AdminView/AdminViewITipr', [
            'itCapstoneProjects' => $itCapstoneProjects,
            'searchQuery' => $searchQuery // Pass the search query back to the frontend
        ]);
    }
    
    

    public function viewCSThesis()
    {
        
        $csThesisPapers = Project::where('course', 'CS')->get();

        
        return Inertia::render('AdminView/AdminViewCSipr', [
            'csThesisPapers' => $csThesisPapers,
        ]);
    }


    public function viewISCapstones()
    {

        $isCapstoneProjects = Project::where('course', 'IS')->get();


        return Inertia::render('AdminView/AdminViewISipr', [
            'isCapstoneProjects' => $isCapstoneProjects,
        ]);
    }

    public function showFullDocument($id)
    {
        // Retrieve the project based on its ID
        $project = Project::findOrFail($id); // Find the project by ID, or return 404 if not found
        $fullDocument = $project->fullDocument; // Assuming this is the document field
    
        // Return the Inertia view with the document data
        return Inertia::render('AdminView/AdminFullDocu', [
            'fullDocument' => $fullDocument ?? 'No document available.', // Fallback if no document exists
        ]);
    }
    
    

}
