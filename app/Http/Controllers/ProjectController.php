<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as LaravelLog;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;


class ProjectController extends Controller
{

    public function viewLogs()
    {
        $logs = Log::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return Inertia::render('AdminView/AdminLogs', [
            'logs' => $logs,
        ]);
    }
    

// View pages
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
                  ->orWhere('tags', 'like', '%' . $searchQuery . '%');
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
        $itCapstoneProjects = $query->paginate(perPage: 10);
    
        // Pass the data to the Inertia view
        return Inertia::render('AdminView/AdminViewITipr', [
            'itCapstoneProjects' => [
                'total_items' => $itCapstoneProjects->total(), // Total items
                'total_pages' => $itCapstoneProjects->lastPage(), // Total pages
                'current_page' => $itCapstoneProjects->currentPage(),
                'data' => $itCapstoneProjects->items(),

                'first_page_url' => $itCapstoneProjects->url(1),
                'from' => $itCapstoneProjects->firstItem(),
                'last_page' => $itCapstoneProjects->lastPage(),
                'last_page_url' => $itCapstoneProjects->url($itCapstoneProjects->lastPage()),
                'links' => $itCapstoneProjects->linkCollection()->toArray(),
                'next_page_url' => $itCapstoneProjects->nextPageUrl(),
                'path' => $itCapstoneProjects->path(),
                'per_page' => $itCapstoneProjects->perPage(),
                'prev_page_url' => $itCapstoneProjects->previousPageUrl(),
                'to' => $itCapstoneProjects->lastItem(),

            ],
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
                  ->orWhere('tags', 'like', '%' . $searchQuery . '%');
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
                  ->orWhere('tags', 'like', '%' . $searchQuery . '%');
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
            'sourceCode' => 'nullable|string|max:255',
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
            $project->fullDocument = $fullDocument->storeAs('documents', $fullDocumentFilename, 'public');
    
            // Optional: Make an API call for keywords
            try {
                $response = Http::attach(
                    'file',
                    file_get_contents($fullDocument->getRealPath()),
                    $fullDocument->getClientOriginalName()
                )->post('https://file-keywords-generator-production.up.railway.app/api/keywords-generator/file-upload/');
    
                if ($response->successful()) {
                    $keywordsData = $response->json();
                    if (isset($keywordsData['keywords']) && is_array($keywordsData['keywords'])) {
                        $project->keywords = implode(', ', $keywordsData['keywords']);
                    }
                }
            } catch (\Exception $e) {
                // Log the exception if necessary
                Log::error('Keyword generation failed: ' . $e->getMessage());
            }
        }
    
        if ($request->hasFile('acmPaper')) {
            $acmPaper = $request->file('acmPaper');
            $acmPaperFilename = $sanitizedTitle . '_ACM_Paper.' . $acmPaper->getClientOriginalExtension();
            $project->acmPaper = $acmPaper->storeAs('documents', $acmPaperFilename, 'public');
        }
    
        // Store the project
        $project->save();
    
        // Log the action
        $user = Auth::user();
        Log::create([
            'user_id' => $user->id,
            'action' => 'Added a new project called ' . $sanitizedTitle,
            'created_at' => now(),
        ]);
    
        // Notify admins
        $adminUsers = User::where('user_type', 'Admin')->get();
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'project_edit',
                'message' => "A project titled '{$project->title}' has been added by {$user->name}.",
            ]);
        }
    
        // Redirect based on the course
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
                    'user_id' => $user->id,           // Laravel automatically handles this relation
                    'action' => 'Added a new project called ' . $sanitizedTitle,
                    'created_at' => now(),
                ]);
    
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
    
    
    


    

    public function showFullDocument($id)//might remove later
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
