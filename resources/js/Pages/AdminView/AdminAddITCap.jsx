import React from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AdminSidebar from "./AdminSidebar";
import Header from "../General/Header";
import Footer from "../General/Footer";
import "../../../css/AdminView/AdminIPreg.css";

const AdminAddITCap = () => {
  // Using useForm from Inertia to handle form data
  const { data, setData, post, processing, errors, reset } = useForm({
    ipRegistration: "",
    specialization: "",
    title: "",
    author1: "",
    author2: "",  
    author3: "",
    author4: "",
    technicalAdviser: "",
    yearPublished: "",
    fullDocument: null,
    acmPaper: null,
    sourceCode: null,
    tags: "",
    course: 'IT', // Always set course to "IT"

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

    // Submitting form data to backend via Inertia post method
    setData('course', 'IT');
    post(route('admin/add-IT-Cap'), {
      onSuccess: () => reset()  // Reset form after successful submission
    });
  };

  // Handle cancel button
  const handleCancel = () => {
    router.visit("/admin/ip-registered/IT-cap");
  };

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="capstone-container">
            <h1>Add IT Capstone Project</h1>
            <form className="capstone-form" onSubmit={handleSubmit}>
              {/* Form Fields */}
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

              <div className="form-group">
                <label>Specialization:</label>
                <select
                  name="specialization"
                  value={data.specialization}
                  onChange={handleChange}
                >
                  <option value="" disabled selected>Select Specialization</option>
                  <option value="IT Automation">IT Automation</option>
                  <option value="Network Security">Network Security</option>
                  <option value="Web and Mobile App Development">Web and Mobile App Development</option>
                </select>
                {errors.specialization && <div>{errors.specialization}</div>}
              </div>

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
                  type="text"
                  name="sourceCode"
                  onChange={handleFileChange}
                />
                {errors.sourceCode && <div>{errors.sourceCode}</div>}
              </div>

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

              <div className="form-actions">
                <button type="submit" className="submit-button" disabled={processing}>
                  Add IT Capstone Project
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

export default AdminAddITCap;
