import React from 'react';
import '../../../css/AdminView/AdminBest.css';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import { usePage } from '@inertiajs/react';

const AdminBestCS = () => {
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
              <h1>Best CS Thesis Papers</h1>
            </div>
            <div className="capstone-table">
              <table>
                <thead>
                  <tr>
                    <th>Core Computer Science</th>
                    <th>Game Development</th>
                    <th>Data Analytics</th>
                  </tr>
                </thead>
                <tbody>
                  {[0, 1, 2].map(index => (
                    <tr key={index}>
                      <td>{bestProjects.coreCS[index]?.title || 'No project'}</td>
                      <td>{bestProjects.gameDev[index]?.title || 'No project'}</td>
                      <td>{bestProjects.dataAnal[index]?.title || 'No project'}</td>
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

export default AdminBestCS;
