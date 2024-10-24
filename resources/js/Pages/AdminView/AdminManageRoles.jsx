import React, { useState, useEffect } from 'react';
import '../../../css/AdminView/AdminManageRoles.css';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import axios from 'axios'; // Use axios or fetch for API calls

const AdminManageRoles = () => {
  const [facultyMembers, setFacultyMembers] = useState([]); // Store the list of faculty members
  const [searchTerm, setSearchTerm] = useState(''); // Store the search term

  useEffect(() => {
    // Fetch all faculty members when the component loads
    axios.get('/admin/faculty-members') // Adjust the URL based on your route
      .then(response => {
        setFacultyMembers(response.data);
      })
      .catch(error => console.error('Error fetching faculty members:', error));
  }, []);

  // Handle search functionality
  const filteredFacultyMembers = facultyMembers.filter(faculty => 
    faculty.first_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
    faculty.last_name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  // Handle department change
  const handleDepartmentChange = (userId, newDepartment) => {
    axios.put(`/admin/faculty-members/${userId}/update-department`, { department: newDepartment })
      .then(response => {
        // Update the local state with the new department
        setFacultyMembers(facultyMembers.map(faculty => 
          faculty.id === userId ? { ...faculty, user_course: newDepartment } : faculty
        ));
      })
      .catch(error => console.error('Error updating department:', error));
  };

  // Handle capstone coordinator change
  const handleCoordinatorChange = (userId, isCoordinator) => {
    axios.put(`/admin/faculty-members/${userId}/update-coordinator`, { is_coordinator: isCoordinator })
      .then(response => {
        // Update the local state with the new coordinator status
        setFacultyMembers(facultyMembers.map(faculty => 
          faculty.id === userId ? { ...faculty, is_coordinator: isCoordinator } : faculty
        ));
      })
      .catch(error => console.error('Error updating coordinator status:', error));
  };

  // Handle deactivation of user
  const handleDeactivateUser = (userId) => {
    axios.put(`/admin/faculty-members/${userId}/deactivate`)
      .then(response => {
        // Update the local state with the new status
        setFacultyMembers(facultyMembers.map(faculty => 
          faculty.id === userId ? { ...faculty, status: 'inactive' } : faculty
        ));
      })
      .catch(error => console.error('Error deactivating user:', error));
  };

  // Handle reactivation of user
  const handleReactivateUser = (userId) => {
    axios.put(`/admin/faculty-members/${userId}/reactivate`)
      .then(response => {
        // Update the local state with the new status
        setFacultyMembers(facultyMembers.map(faculty => 
          faculty.id === userId ? { ...faculty, status: 'active' } : faculty
        ));
      })
      .catch(error => console.error('Error reactivating user:', error));
  };

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <div className="main-content">
          <div className="roles-container">
            <div className="roles-header">
              <h1>Manage Faculty Roles</h1>
            </div>
            
            <div className="search-bar">
              <input 
                type="text" 
                placeholder="Search faculty member..." 
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)} // Update search term
              />
            </div>
            
            <div className="roles-table">
              <table>
                <thead>
                  <tr>
                    <th>Faculty Member Name</th>
                    <th>Email Address</th>
                    <th>Department</th>
                    <th>Capstone Coordinator</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>Last Updated</th>
                  </tr>
                </thead>
                <tbody>
                  {filteredFacultyMembers.map(faculty => (
                    <tr key={faculty.id}>
                      <td>{faculty.first_name} {faculty.last_name}</td>
                      <td>{faculty.email}</td>
                      <td>
                        <select 
                          value={faculty.user_course} 
                          onChange={(e) => handleDepartmentChange(faculty.id, e.target.value)}
                        >
                          <option value="CS">CS</option>
                          <option value="IT">IT</option>
                          <option value="IS">IS</option>
                        </select>
                      </td>
                      <td>
                        <input 
                          type="checkbox" 
                          checked={faculty.is_coordinator}
                          onChange={(e) => handleCoordinatorChange(faculty.id, e.target.checked)} 
                        />
                      </td>
                      <td>{faculty.status === 'active' ? 'Active' : 'Inactive'}</td>
                      <td>
                        {faculty.status === 'active' ? (
                          <button 
                            className="deactivate-button" 
                            onClick={() => handleDeactivateUser(faculty.id)}
                          >
                            Deactivate
                          </button>
                        ) : (
                          <button 
                            className="reactivate-button" 
                            onClick={() => handleReactivateUser(faculty.id)}
                          >
                            Reactivate
                          </button>
                        )}
                      </td>
                      <td>{faculty.updated_at}</td>
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
}

export default AdminManageRoles;
