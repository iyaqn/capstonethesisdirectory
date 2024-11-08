import React from 'react';
import { useForm, usePage, router } from '@inertiajs/react'; // Import useForm and usePage
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import '../../../css/AdminView/AdminIPreg.css';

const AdminEditITCap = () => {
  // Get project data from Inertia page props
  const { project } = usePage().props;

  // Using useForm from Inertia to handle form data
  const { data, setData, put, processing, errors } = useForm({
    ipRegistration: project?.ipRegistration || '',
    specialization: project?.specialization || '',
    title: project?.title || '',
    author1: project?.author1 || '',
    author2: project?.author2 || '',
    author3: project?.author3 || '',
    author4: project?.author4 || '',
    technicalAdviser: project?.technicalAdviser || '',
    yearPublished: project?.yearPublished || '',
    fullDocument: null,  // No need to show the current uploaded document
    acmPaper: null,  // No need to show the current uploaded document
    sourceCode: null,  // No need to show the current uploaded document
    approvalForm: null,  // No need to show the current uploaded document
    tags: project?.tags || '',
  });

  // Handle input text changes
  const handleChange = (e) => {
    setData(e.target.name, e.target.value);
  };

  // Handle file input changes
  const handleFileChange = (e) => {
    setData(e.target.name, e.target.files[0]);
  };

  // Handle form submission
  const handleSubmit = (e) => {
    e.preventDefault();

    // Send updated form data to the backend
    put(route('admin/update-IT-Cap', project.id), {
      onSuccess: () => router.visit('/admin/ip-registered/IT-cap'), // Redirect after success
    });
  };

  // Handle cancel button
  const handleCancel = () => {
    router.visit('/admin/ip-registered/IT-cap');
  };

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="capstone-container">
            <h1>Edit IT Capstone Project</h1>
            <form className="capstone-form" onSubmit={handleSubmit}>
              {/* IP Registration Number */}
              <div className="form-group">
                <label>IP Registration #:</label>
                <input
                  type="text"
                  name="ipRegistration"
                  value={data.ipRegistration}
                  onChange={handleChange}
                />
                {errors.ipRegistration && <div>{errors.ipRegistration}</div>}
              </div>

              {/* Specialization Dropdown */}
              <div className="form-group">
                <label>Specialization:</label>
                <select
                  name="specialization"
                  value={data.specialization}
                  onChange={handleChange}
                >
                  <option value="" disabled>Select Specialization</option>
                  <option value="IT Automation">IT Automation</option>
                  <option value="Network Security">Network Security</option>
                  <option value="Web and Mobile App Development">Web and Mobile App Development</option>
                </select>
                {errors.specialization && <div>{errors.specialization}</div>}
              </div>

              {/* Capstone Title */}
              <div className="form-group">
                <label>Capstone Title:</label>
                <input
                  type="text"
                  name="title"
                  value={data.title}
                  onChange={handleChange}
                />
                {errors.title && <div>{errors.title}</div>}
              </div>

              {/* Author Fields */}
              <div className="form-group">
                <label>Author 1:</label>
                <input
                  type="text"
                  name="author1"
                  value={data.author1}
                  onChange={handleChange}
                />
                {errors.author1 && <div>{errors.author1}</div>}
              </div>
              <div className="form-group">
                <label>Author 2:</label>
                <input
                  type="text"
                  name="author2"
                  value={data.author2}
                  onChange={handleChange}
                />
                {errors.author2 && <div>{errors.author2}</div>}
              </div>
              <div className="form-group">
                <label>Author 3:</label>
                <input
                  type="text"
                  name="author3"
                  value={data.author3}
                  onChange={handleChange}
                />
                {errors.author3 && <div>{errors.author3}</div>}
              </div>
              <div className="form-group">
                <label>Author 4:</label>
                <input
                  type="text"
                  name="author4"
                  value={data.author4}
                  onChange={handleChange}
                />
                {errors.author4 && <div>{errors.author4}</div>}
              </div>

              {/* Technical Adviser */}
              <div className="form-group">
                <label>Technical Adviser:</label>
                <input
                  type="text"
                  name="technicalAdviser"
                  value={data.technicalAdviser}
                  onChange={handleChange}
                />
                {errors.technicalAdviser && <div>{errors.technicalAdviser}</div>}
              </div>

              {/* Year Published */}
              <div className="form-group">
                <label>Year Published:</label>
                <input
                  type="text"
                  name="yearPublished"
                  value={data.yearPublished}
                  onChange={handleChange}
                />
                {errors.yearPublished && <div>{errors.yearPublished}</div>}
              </div>

              {/* File Uploads */}
              <div className="form-group">
                <label>Full Document:</label>
                <input
                  type="file"
                  name="fullDocument"
                  onChange={handleFileChange}
                />
                {errors.fullDocument && <div>{errors.fullDocument}</div>}
              </div>
              <div className="form-group">
                <label>ACM Paper:</label>
                <input
                  type="file"
                  name="acmPaper"
                  onChange={handleFileChange}
                />
                {errors.acmPaper && <div>{errors.acmPaper}</div>}
              </div>
              <div className="form-group">
                <label>Source Code:</label>
                <input
                  type="file"
                  name="sourceCode"
                  onChange={handleFileChange}
                />
                {errors.sourceCode && <div>{errors.sourceCode}</div>}
              </div>
              <div className="form-group">
                <label>Approval Form:</label>
                <input
                  type="file"
                  name="approvalForm"
                  onChange={handleFileChange}
                />
                {errors.approvalForm && <div>{errors.approvalForm}</div>}
              </div>

              {/* tags */}
              <div className="form-group">
                <label>tags:</label>
                <input
                  type="text"
                  name="tags"
                  value={data.tags}
                  onChange={handleChange}
                />
                {errors.tags && <div>{errors.tags}</div>}
              </div>

              {/* Form Actions */}
              <div className="form-actions">
                <button type="submit" className="save-button" disabled={processing}>
                  Save IT Capstone Project
                </button>
                <button type="button" className="cancel-button" onClick={handleCancel}>
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </main>
      </div>
      <Footer />
    </div>
  );
};

export default AdminEditITCap;
