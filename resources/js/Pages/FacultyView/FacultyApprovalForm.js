import React from 'react';
import { useLocation } from 'react-router-dom';
import FacultySidebar from './FacultySidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';

const FacultyApprovalForm = () => {
  const location = useLocation();
  const { approvalForm } = location.state || {}; // Fetch the full document passed from the previous page

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <FacultySidebar />
        <main className="main-content">
          <div className="document-container">
            <h1>Approval Form</h1>
            {/* Render the full document here */}
            <div className="document-content">
              {approvalForm ? (
                <p>{approvalForm}</p>
              ) : (
                <p>No document available.</p>
              )}
            </div>
          </div>
        </main>
      </div>
      <Footer />
    </div>
  );
};

export default FacultyApprovalForm;
