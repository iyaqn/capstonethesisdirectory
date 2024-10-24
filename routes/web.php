<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
    #Admin Routing
    Route::middleware(['auth', 'role:admin'])->group(function () {
        
        Route::get('/admin-home', function () {
            return Inertia::render('AdminView/AdminHome');
        })->name('admin-home');

    // Admin View IP Reg
    Route::get('/admin/ip-registered/IT-cap', [ProjectController::class, 'viewITCapstones'])->name('admin/ip-registered/IT-cap');
    Route::get('/admin/ip-registered/IS-cap', [ProjectController::class, 'viewISCapstones'])->name('admin/ip-registered/IS-cap');
    Route::get('/admin/ip-registered/CS-thes', [ProjectController::class, 'viewCSThesis'])->name('admin/ip-registered/CS-thes');
    Route::put('/admin/toggle-best-capstone/{id}', [ProjectController::class, 'toggleBestCapstone']);

    // Admin Add Proj Stuff
    Route::get('/admin/add-IT-Cap', [ProjectController::class, 'createIT'])->name('admin/add-IT-Cap');
    Route::get('/admin/add-IS-Cap', [ProjectController::class, 'createIS'])->name('admin/add-IS-Cap');
    Route::get('/admin/add-CS-Thes', [ProjectController::class, 'createCS'])->name('admin/add-CS-Thes');

    Route::post('/admin/add-IT-Cap', [ProjectController::class, 'store'])->name('admin/add-IT-Cap-store');
    Route::post('/admin/add-IS-Cap', [ProjectController::class, 'store'])->name('admin/add-IS-Cap-store');
    Route::post('/admin/add-CS-Thes', [ProjectController::class, 'store'])->name('admin/add-CS-Thes-store');

    // Admin Edit Proj
    Route::get('/admin/edit-IT-Cap/{id}', [ProjectController::class, 'editIT'])->name('admin/edit-IT-Cap');
    Route::get('/admin/edit-IS-Cap/{id}', [ProjectController::class, 'editIS'])->name('admin/edit-IS-Cap');
    Route::get('/admin/edit-CS-Thes/{id}', [ProjectController::class, 'editCS'])->name('admin/edit-CS-Cap');

    Route::put('/admin/edit-IT-Cap/{id}', [ProjectController::class, 'update'])->name('admin/update-IT-Cap');
    Route::put('/admin/edit-IS-Cap/{id}', [ProjectController::class, 'update'])->name('admin/update-IS-Cap');
    Route::put('/admin/edit-CS-Thes/{id}', [ProjectController::class, 'update'])->name('admin/update-CS-Thes');

    
    Route::get('/admin/approval-IT', function () {
        return Inertia::render('AdminView/AdminITApproval');
    })->name('admin/approval-IT');
    
    Route::get('/admin/approval-IS', function () {
        return Inertia::render('AdminView/AdminISApproval');
    })->name('admin/approval-IS');
    
    Route::get('/admin/approval-CS', function () {
        return Inertia::render('AdminView/AdminCSApproval');
    })->name('admin/approval-CS');
    
    Route::get('admin/full-document/{id}', [ProjectController::class, 'showFullDocument'])->name('admin/full-document');

    
    Route::get('/admin/approval-form', function () {
        return Inertia::render('AdminView/AdminApprovalForm');
    })->name('admin/approval-form');
    
    // Admin Best Proj
    Route::get('/admin/BestIT', [ProjectController::class, 'viewBestITCapstones'])->name('admin/BestIT');
    Route::get('/admin/BestIS', [ProjectController::class, 'viewBestISCapstones'])->name('admin/BestIS');
    Route::get('/admin/BestCS', [ProjectController::class, 'viewBestCSThesis'])->name('admin/BestCS');

    
    Route::get('/admin/roles', function () {
        return Inertia::render('AdminView/AdminManageRoles');
    })->name('admin/roles');
    });

    Route::get('/admin/faculty-members', [AdminController::class, 'getFacultyMembers']);
    Route::put('/admin/faculty-members/{id}/update-department', [AdminController::class, 'updateDepartment']);
    Route::put('/admin/faculty-members/{id}/update-coordinator', [AdminController::class, 'updateCoordinator']);
    Route::put('/admin/faculty-members/{id}/deactivate', [AdminController::class, 'deactivateUser']);
    Route::put('/admin/faculty-members/{id}/reactivate', [AdminController::class, 'reactivateUser']);

    

    #Faculty Routing
    Route::middleware(['auth', 'role:faculty'])->group(function () {
    Route::get('/faculty-home', function () {
        return Inertia::render('FacultyView/FacultyHome');
    })->name('faculty-home');

    Route::get('/faculty/profile', function () {
        return Inertia::render('FacultyView/FacultyProfile');
    })->name('faculty-profile');


    Route::get('/faculty/BestIT', function () {
        return Inertia::render('FacultyView/FacultyBestIT');
    })->name('/faculty/BestIT');
    Route::get('/faculty/BestIS', function () {
        return Inertia::render('FacultyView/FacultyBestIS');
    })->name('/faculty/BestIS');
    Route::get('/faculty/BestCS', function () {
        return Inertia::render('FacultyView/FacultyBestCS');
    })->name('/faculty/BestCS');


    Route::get('/faculty/ip-registered/IT-cap', function () {
        return Inertia::render('FacultyView/FacultyViewITipr');
    })->name('faculty/ip-registered/IT-cap');
    Route::get('/faculty/ip-registered/IS-cap', function () {
        return Inertia::render('FacultyView/FacultyViewISipr');
    })->name('faculty/ip-registered/IS-cap');
    Route::get('/faculty/ip-registered/CS-thes', function () {
        return Inertia::render('FacultyView/FacultyViewCSipr');
    })->name('faculty/ip-registered/CS-thes');

    Route::get('/faculty/approval-form', function () {
        return Inertia::render('FacultyView/FacultyApprovalForm');
    })->name('faculty/approval-form');
});



    # Student Routing 
    Route::middleware(['auth', 'role:student'])->group(function () {



    Route::get('/student-register', function () {
        return Inertia::render('StudentView/StudentRegister');
    })->name('student-register');

    Route::get('/student-profile', function () {
        return Inertia::render('StudentView/StudentProfile');
    })->name('student-profile');

    Route::get('/ip-registered/IT-cap', function () {
        return Inertia::render('StudentView/StudentViewITipr');
    })->name('student/ip-registered/IT-cap');

    Route::get('/ip-registered/IS-cap', function () {
        return Inertia::render('StudentView/StudentViewISipr');
    })->name('student/ip-registered/IS-cap');

    Route::get('/ip-registered/CS-thes', function () {
        return Inertia::render('StudentView/StudentViewCSipr');
    })->name('student/ip-registered/CS-thes');

    Route::get('/student-home', function () {
        return Inertia::render('StudentView/StudentHome');
    })->name('student-home');

    Route::get('/best-cs', function () {
        return Inertia::render('StudentView/StudentBestCS');
    })->name('student-best-cs');

    Route::get('/best-is', function () {
        return Inertia::render('StudentView/StudentBestIS');
    })->name('student-best-is');

    Route::get('/best-it', function () {
        return Inertia::render('StudentView/StudentBestIT');
    })->name('student-best-it');
});


    #Auth
    
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
    Route::get('/', function(){
        return Inertia::render('Dashboard');
    });
});

#Temporary Routes cos scuffed
