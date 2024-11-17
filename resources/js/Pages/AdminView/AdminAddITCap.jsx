import React from 'react';
import { useForm, router } from '@inertiajs/react';
import AdminSidebar from './AdminSidebar';
import Header from '../General/Header';
import Footer from '../General/Footer';
import '../../../css/AdminView/AdminIPreg.css';

const AdminAddITCap = () => {
  const { data, setData, post, processing, errors, reset } = useForm({
    ipRegistration: '',
    specialization: '',
    title: '',
    authors: ['', '', '', ''], // Array for up to 4 authors
    technicalAdviser: '',
    yearPublished: '',
    fullDocument: null,
    acmPaper: null,
    sourceCode: '',
    tags: '',
    course: 'IT',
  });

  const handleChange = (e) => {
    setData(e.target.name, e.target.value);
  };

  const handleAuthorChange = (index, value) => {
    const updatedAuthors = [...data.authors];
    updatedAuthors[index] = value;
    setData('authors', updatedAuthors);
  };

  const handleFileChange = (e) => {
    setData(e.target.name, e.target.files[0]);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    post(route('admin/add-IT-Cap'), {
      onSuccess: () => reset(),
    });
  };

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
            <h1>Add IT Capstone Project</h1>
            <form className="capstone-form" onSubmit={handleSubmit}>
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
                <select name="specialization" value={data.specialization} onChange={handleChange}>
                  <option value="" disabled>Select Specialization</option>
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
                <label>Authors:</label>
                {data.authors.map((author, index) => (
                  <input
                    key={index}
                    type="text"
                    name={`author${index + 1}`}
                    value={author}
                    placeholder={`Author ${index + 1}`}
                    onChange={(e) => handleAuthorChange(index, e.target.value)}
                  />
                ))}
                {errors.authors && <div>{errors.authors}</div>}
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
                <select name="yearPublished" value={data.yearPublished} onChange={handleChange}>
                  <option value="" disabled>Select Year</option>
                  {Array.from({ length: new Date().getFullYear() - 2013 }, (_, i) => {
                    const year = new Date().getFullYear() - i;
                    return (
                      <option key={year} value={year}>
                        {year}
                      </option>
                    );
                  })}
                </select>
                {errors.yearPublished && <div>{errors.yearPublished}</div>}
              </div>

              <div className="form-group">
                <label>Full Document:</label>
                <input type="file" name="fullDocument" onChange={handleFileChange} />
                {errors.fullDocument && <div>{errors.fullDocument}</div>}
              </div>

              <div className="form-group">
                <label>ACM Paper:</label>
                <input type="file" name="acmPaper" onChange={handleFileChange} />
                {errors.acmPaper && <div>{errors.acmPaper}</div>}
              </div>

              <div className="form-group">
                <label>Source Code:</label>
                <input
                  type="text"
                  name="sourceCode"
                  value={data.sourceCode}
                  onChange={handleChange}
                />
                {errors.sourceCode && <div>{errors.sourceCode}</div>}
              </div>

              <div className="form-group">
                <label>Tags:</label>
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
