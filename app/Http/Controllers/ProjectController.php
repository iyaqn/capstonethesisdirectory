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
        $filterYear = $request->input('filterYear');
        $filterSpecialization = $request->input('filterSpecialization');
        $sortBy = $request->input('sortBy');
    
        $query = Project::where('course', 'IT');
    
        // Apply search filter
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('keywords', 'like', '%' . $searchQuery . '%')
                  ->orWhere('author1', 'like', '%' . $searchQuery . '%');
            });
        }
    
        // Apply year filter
        if ($filterYear === 'at-most-5') {
            $query->where('yearPublished', '>=', now()->year - 5);
        } elseif ($filterYear === 'at-least-5') {
            $query->where('yearPublished', '<=', now()->year - 5);
        } elseif (is_numeric($filterYear)) {
            $query->where('yearPublished', $filterYear);
        }
    
        // Apply specialization filter
        if ($filterSpecialization) {
            $query->where('specialization', $filterSpecialization);
        }
    
        // Apply sorting
        if ($sortBy === 'newest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) desc');  // Treat year as a number for sorting
        } elseif ($sortBy === 'oldest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) asc');   // Treat year as a number for sorting
        } elseif ($sortBy === 'best') {
            $query->orderBy('is_best_proj', 'desc')  // Best projects appear first
            ->orderBy('title', 'asc');         // Then everything sorted alphabetically
        } else {
            $query->orderBy('title', 'asc');  // Alphabetical sorting as default
        } 

    
        // Paginate the results
        $itCapstoneProjects = $query->paginate(10);
    
        // Pass the data to the Inertia view
        return Inertia::render('AdminView/AdminViewITipr', [
            'itCapstoneProjects' => $itCapstoneProjects,
            'searchQuery' => $searchQuery,
        ]);
    }
    
    
    

    public function viewCSThesis(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterYear = $request->input('filterYear');
        $filterSpecialization = $request->input('filterSpecialization');
        $sortBy = $request->input('sortBy');
    
        $query = Project::where('course', 'CS');
    
        // Apply search filter
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('keywords', 'like', '%' . $searchQuery . '%')
                  ->orWhere('author1', 'like', '%' . $searchQuery . '%');
            });
        }
    
        // Apply year filter
        if ($filterYear === 'at-most-5') {
            $query->where('yearPublished', '>=', now()->year - 5);
        } elseif ($filterYear === 'at-least-5') {
            $query->where('yearPublished', '<=', now()->year - 5);
        } elseif (is_numeric($filterYear)) {
            $query->where('yearPublished', $filterYear);
        }
    
        // Apply specialization filter
        if ($filterSpecialization) {
            $query->where('specialization', $filterSpecialization);
        }
    
        // Apply sorting
        if ($sortBy === 'newest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) desc');  // Treat year as a number for sorting
        } elseif ($sortBy === 'oldest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) asc');   // Treat year as a number for sorting
        } elseif ($sortBy === 'best') {
            $query->orderBy('is_best_proj', 'desc')  // Best projects appear first
            ->orderBy('title', 'asc');         // Then everything sorted alphabetically
        } else {
            $query->orderBy('title', 'asc');  // Alphabetical sorting as default
        } 
    
        // Paginate the results
        $csThesisPapers = $query->paginate(10);
    
        // Pass the data to the Inertia view
        return Inertia::render('AdminView/AdminViewCSipr', [
            'csThesisPapers' => $csThesisPapers,
            'searchQuery' => $searchQuery,
            'filterYear' => $filterYear,
            'filterSpecialization' => $filterSpecialization,
            'sortBy' => $sortBy,
        ]);
    }
    


    public function viewISCapstones(Request $request)
    {
        $searchQuery = $request->input('search');
        $filterYear = $request->input('filterYear');
        $filterSpecialization = $request->input('filterSpecialization');
        $sortBy = $request->input('sortBy');
    
        $query = Project::where('course', 'IS');
    
        // Apply search filter
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('keywords', 'like', '%' . $searchQuery . '%')
                  ->orWhere('author1', 'like', '%' . $searchQuery . '%');
            });
        }
    
        // Apply year filter
        if ($filterYear === 'at-most-5') {
            $query->where('yearPublished', '>=', now()->year - 5);
        } elseif ($filterYear === 'at-least-5') {
            $query->where('yearPublished', '<=', now()->year - 5);
        } elseif (is_numeric($filterYear)) {
            $query->where('yearPublished', $filterYear);
        }
    
        // Apply specialization filter
        if ($filterSpecialization) {
            $query->where('specialization', $filterSpecialization);
        }
    
        // Apply sorting
        if ($sortBy === 'newest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) desc');  // Treat year as a number for sorting
        } elseif ($sortBy === 'oldest') {
            $query->orderByRaw('CAST(yearPublished AS UNSIGNED) asc');   // Treat year as a number for sorting
        } elseif ($sortBy === 'best') {
            $query->orderBy('is_best_proj', 'desc')  // Best projects appear first
            ->orderBy('title', 'asc');         // Then everything sorted alphabetically
        } else {
            $query->orderBy('title', 'asc');  // Alphabetical sorting as default
        } 
    
        // Paginate the results
        $isCapstoneProjects = $query->paginate(10);
    
        // Pass the data to the Inertia view
        return Inertia::render('AdminView/AdminViewISipr', [
            'isCapstoneProjects' => $isCapstoneProjects,
            'searchQuery' => $searchQuery,
            'filterYear' => $filterYear,
            'filterSpecialization' => $filterSpecialization,
            'sortBy' => $sortBy,
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
    public function toggleBestCapstone(Request $request, $id)
    {
        // Find the project by ID
        $project = Project::findOrFail($id);
    
        // Check if the project is being marked as 'best'
        $isBestProj = $request->input('is_best_proj') ? true : false;
    
        // If it's being marked as 'best', check the current number of best capstones for the same specialization
        if ($isBestProj) {
            // Count the number of projects that are already marked as "best" in the same specialization
            $bestCapstonesCount = Project::where('specialization', $project->specialization)
                ->where('is_best_proj', true)
                ->count();
    
            // If the count is 3 or more, prevent further marking
            if ($bestCapstonesCount >= 3) {
                return back()->withErrors(['message' => 'You can only have 3 best capstones per specialization.']);
            }
        }
    
        // Update the is_best_proj field
        $project->is_best_proj = $isBestProj;
    
        // Save the changes
        $project->save();
    
        return back()->with('success', 'Best Capstone status updated.');
    }
    

    public function viewBestITCapstones()
{
    // Fetch the best projects from the database for each specialization
    $bestWebAndMobile = Project::where('specialization', 'Web and Mobile App Development')
                                ->where('is_best_proj', true)
                                ->get();
    
    $bestITAutomation = Project::where('specialization', 'IT Automation')
                                ->where('is_best_proj', true)
                                ->get();
    
    $bestNetworkSecurity = Project::where('specialization', 'Network Security')
                                  ->where('is_best_proj', true)
                                  ->get();

    // Pass the data to the Inertia view
    return Inertia::render('AdminView/AdminBestIT', [
        'bestProjects' => [
            'webAndMobile' => $bestWebAndMobile,
            'itAutomation' => $bestITAutomation,
            'networkSecurity' => $bestNetworkSecurity
        ]
    ]);
}

public function viewBestISCapstones()
{
    // Fetch the best projects from the database for each specialization
    $bestBusAnalytics = Project::where('specialization', 'Business Analytics')
                                ->where('is_best_proj', true)
                                ->get();
    
    $bestServMan = Project::where('specialization', 'Service Management')
                          ->where('is_best_proj', true)
                          ->get();

    // Pass the data to the Inertia view
    return Inertia::render('AdminView/AdminBestIS', [
        'bestProjects' => [
            'busAnalytics' => $bestBusAnalytics,
            'servMan' => $bestServMan,
        ]
    ]);
}

public function viewBestCSThesis()
{
    // Fetch the best projects from the database for each specialization
    $bestCoreCS = Project::where('specialization', 'Core Computer Science')
                          ->where('is_best_proj', true)
                          ->get();
    
    $bestGameDev = Project::where('specialization', 'Game Development')
                          ->where('is_best_proj', true)
                          ->get();
    
    $bestDataAnal = Project::where('specialization', 'Data Analytics')
                          ->where('is_best_proj', true)
                          ->get();

    // Pass the data to the Inertia view
    return Inertia::render('AdminView/AdminBestCS', [
        'bestProjects' => [
            'coreCS' => $bestCoreCS,
            'gameDev' => $bestGameDev,
            'dataAnal' => $bestDataAnal,
        ]
    ]);
}




}
