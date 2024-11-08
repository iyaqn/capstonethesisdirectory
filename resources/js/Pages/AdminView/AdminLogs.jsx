import React from 'react';
import { usePage } from '@inertiajs/react';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';

const AdminLogs = () => {
  // Retrieve logs data from the backend via Inertia props
  const { logs } = usePage().props;

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="logs-container">
            <h1>User Activity Logs</h1>
            <table className="logs-table">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>User Name</th>
                  <th>Course</th>
                  <th>Role</th>
                  <th>Action</th>
                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>
                {logs.data && logs.data.length > 0 ? (
                  logs.data.map((log) => (
                    <tr key={log.id}>
                      <td>{log.user_id}</td>
                      <td>{log.user ? `${log.user.first_name} ${log.user.last_name}` : 'N/A'}</td>
                      <td>{log.log_course || 'N/A'}</td>
                      <td>{log.log_type || 'N/A'}</td>
                      <td>{log.action}</td>
                      <td>{new Date(log.created_at).toLocaleString()}</td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="6">No logs available.</td>
                  </tr>
                )}
              </tbody>
            </table>

            {/* Pagination */}
            <div className="pagination">
              {logs.links && logs.links.map((link, index) => (
                <button
                  key={index}
                  disabled={!link.url}
                  onClick={() => router.visit(link.url)}
                  dangerouslySetInnerHTML={{ __html: link.label }}
                  className={link.active ? 'active' : ''}
                />
              ))}
            </div>
          </div>
        </main>
      </div>
      <Footer />
    </div>
  );
};

export default AdminLogs;
