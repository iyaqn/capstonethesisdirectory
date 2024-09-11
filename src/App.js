import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import AdminLogin from "./AdminView/AdminLogin";
import StudentLogin from "./StudentView/StudentLogin";
import FacultyLogin from "./FacultyView/FacultyLogin";
import PasswordRecovery from "./General/PasswordRecovery";
import AdminHome from "./AdminView/AdminHome";
import AdminViewITipr from "./AdminView/AdminViewITipr"
import AdminViewISipr from "./AdminView/AdminViewISipr"
import AdminViewCSipr from "./AdminView/AdminViewCSipr"
import StudentRegister from "./StudentView/StudentRegister";
import StudentHome from "./StudentView/StudentHome"; // Import the StudentHome component
import StudentProfile from "./StudentView/StudentProfile";
import StudentViewITipr from "./StudentView/StudentViewITipr";
import StudentViewISipr from "./StudentView/StudentViewISipr";
import StudentViewCSipr from "./StudentView/StudentViewCSipr";
import AdminProfile from "./AdminView/AdminProfile";
import AdminAddITCap from "./AdminView/AdminAddITCap";
import AdminAddISCap from "./AdminView/AdminAddISCap";
import AdminAddCSThes from "./AdminView/AdminAddCSThes";
import AdminITApproval from "./AdminView/AdminITApproval";
import AdminISApproval from "./AdminView/AdminISApproval";
import AdminCSApproval from "./AdminView/AdminCSApproval";
import AdminFullDocu from "./AdminView/AdminFullDocu";
import AdminApprovalForm from "./AdminView/AdminApprovalForm";
import AdminBestIT from "./AdminView/AdminBestIT";
import AdminBestIS from "./AdminView/AdminBestIS";
import AdminBestCS from "./AdminView/AdminBestCS";
import AdminManageRoles from "./AdminView/AdminManageRoles";
import AdminEditCSThesis from "./AdminView/AdminEditCSThesis";
import AdminEditISCap from "./AdminView/AdminEditISCap";
import AdminEditITCap from "./AdminView/AdminEditITCap";

function App() {
  return (
    <Router>
      <Routes>
        {/* Admin */}
        <Route path="/admin-login" element={<AdminLogin />} />
        <Route path="/admin-home" element={<AdminHome />} />
        <Route path="admin/ip-registered/IT-cap" element={<AdminViewITipr />} />
        <Route path="admin/ip-registered/IS-cap" element={<AdminViewISipr />} />
        <Route path="admin/ip-registered/CS-thes" element={<AdminViewCSipr />} />
        <Route path="/admin/edit-IS-Cap/:projectId" element={<AdminEditISCap />} />
        <Route path="/admin/edit-cs-thesis/:id" element={<AdminEditCSThesis />} />
        <Route path="/admin/edit-IT-Cap/:projectId" element={<AdminEditITCap />} />
        <Route path="/admin-profile" element={<AdminProfile />} />
        <Route path="/admin/add-IT-Cap" element={<AdminAddITCap />} />
        <Route path="/admin/add-IS-Cap" element={<AdminAddISCap />} />
        <Route path="/admin/add-CS-Thes" element={<AdminAddCSThes />} />
        <Route path="/admin/approval-IT" element={<AdminITApproval />} />
        <Route path="/admin/approval-IS" element={<AdminISApproval />} />
        <Route path="/admin/approval-CS" element={<AdminCSApproval />} />
        <Route path="/admin/full-document" element={<AdminFullDocu/>}/>
        <Route path="/admin/approval-form" element={<AdminApprovalForm/>}/>
        <Route path="/admin/BestIT" element={<AdminBestIT/>}/>
        <Route path="/admin/BestIS" element={<AdminBestIS/>}/>
        <Route path="/admin/BestCS" element={<AdminBestCS/>}/>
        <Route path="/admin/roles" element={<AdminManageRoles/>}/>


        {/* Faculty */}
        <Route path="/faculty-login" element={<FacultyLogin />} />

        {/* Student */}
        <Route path="/" element={<StudentLogin />} />
        <Route path="/student-register" element={<StudentRegister />} />
        <Route path="/student-profile" element={<StudentProfile />} />
        <Route path="/ip-registered/IT-cap" element={<StudentViewITipr />} />
        <Route path="/ip-registered/IS-cap" element={<StudentViewISipr/>} />
        <Route path="/ip-registered/CS-thes" element={<StudentViewCSipr/>} />
        <Route path="/student-home" element={<StudentHome />} />

        {/* General */}
        <Route path="/password-recovery" element={<PasswordRecovery />} />

      </Routes>
    </Router>
  );
}

export default App;
