import React, { useState } from "react";
import "../../../css/AdminView/AdminBest.css";
import StudentSidebar from "./StudentSidebar";
import Header from "../General/Header";
import Footer from "../General/Footer";
const StudentBestIS = () => {
  // Initial data for best projects (this can be fetched from an API)
  const initialProjects = {
    busAnalytics: ["Project 1", "Project 2", "Project 3"],
    servMan: ["Project 4", "Project 5", "Project 6"],
  };

  // State to store the current projects and if we're in edit mode
  const [projects, setProjects] = useState(initialProjects);

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <StudentSidebar />
        <div className="main-content">
          <div className="capstone-container">
            <div className="capstone-header">
              <h1>Best IS Capstone Projects</h1>
            </div>
            <div className="capstone-table">
              <table>
                <thead>
                  <tr>
                    <th>Business Analytics:</th>
                    <th>Service Management:</th>
                  </tr>
                </thead>
                <tbody>
                  {projects.busAnalytics.map((project, index) => (
                    <tr key={index}>
                      <td>{project}</td>
                      <td>{projects.servMan[index]}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            <div className="capstone-footer"></div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default StudentBestIS;
