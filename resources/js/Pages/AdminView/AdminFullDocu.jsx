import React from 'react';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import { usePage } from '@inertiajs/react';

const AdminFullDocu = () => {
  const { fullDocument } = usePage().props;

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="document-container">
            <h1>Full Document</h1>
            <div className="document-content">
              {fullDocument ? (
                <a 
                  href={`/storage/${fullDocument}`} 
                  download 
                  target="_blank" 
                  rel="noopener noreferrer"
                  className="document-link"
                >
                  Download Full Document
                </a>
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

export default AdminFullDocu;
