import React from 'react';
import '../../../css/AdminView/AdminBest.css';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import { usePage } from '@inertiajs/react';

const AdminBestIT = () => {
  // Access the props passed from the backend via Inertia.js
  const { bestProjects } = usePage().props;

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <div className="main-content">
          <div className="capstone-container">
            <div className="capstone-header">
              <h1>Best IT Capstone Projects</h1>
            </div>
            <div className="capstone-table">
              <table>
                <thead>
                  <tr>
                    <th>Web and Mobile Development</th>
                    <th>IT Automation</th>
                    <th>Network and Security</th>
                  </tr>
                </thead>
                <tbody>
                  {/* Assuming each specialization has a max of 3 best projects */}
                  {[0, 1, 2].map(index => (
                    <tr key={index}>
                      <td>{bestProjects.webAndMobile[index]?.title || 'No project'}</td>
                      <td>{bestProjects.itAutomation[index]?.title || 'No project'}</td>
                      <td>{bestProjects.networkSecurity[index]?.title || 'No project'}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default AdminBestIT;
