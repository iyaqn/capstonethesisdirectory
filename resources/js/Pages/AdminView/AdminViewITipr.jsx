import React, { useState } from "react";
import "../../../css/AdminView/AdminIPreg.css";
import { router, usePage, Link } from '@inertiajs/react'; // Add Link from Inertia
import AdminSidebar from "./AdminSidebar";
import Header from "../General/Header";
import Footer from "../General/Footer";
import AdminModal from "./AdminModal";

const AdminViewITipr = () => {
  const { itCapstoneProjects, searchQuery: initialSearchQuery } = usePage().props; // Get the data passed from Inertia
  const [searchQuery, setSearchQuery] = useState(initialSearchQuery || ""); // Initialize with the existing query
  const [filterYear, setFilterYear] = useState("all");
  const [showModal, setShowModal] = useState(false);
  const [acmDocument, setAcmDocument] = useState(null);

  const handleSearchChange = (e) => setSearchQuery(e.target.value);

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    // Navigate to the same route but include the search query
    router.visit(route('admin/ip-registered/IT-cap', { search: searchQuery }));
  };

  const handleYearFilterChange = (e) => setFilterYear(e.target.value);

  const handleAdd = () => {
    router.visit("/admin/add-IT-Cap");
  };

  const handleViewAcm = (doc) => {
    setAcmDocument(doc);
    setShowModal(true);
  };

  const handleViewFullDoc = (id) => {
    router.visit(`/admin/full-document/${id}`);
  };

  const handleViewApproval = (doc) => {
    router.visit("/admin/approval-form", { state: { approvalFrom: doc } });
  };

  const handleEdit = (projectId) => {
    router.visit(`/admin/edit-IT-Cap/${projectId}`);
  };

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="capstone-container">
            <header className="capstone-header">
              <h1>IP-registered IT Capstone Projects</h1>
              <div className="search-bar">
                <form onSubmit={handleSearchSubmit}>
                  <input
                    type="text"
                    placeholder="Search..."
                    value={searchQuery}
                    onChange={handleSearchChange}
                  />
                  <button className="search-button" type="submit">
                    <img src="/search-icon.png" alt="Search" />
                  </button>
                </form>
              </div>
            </header>

            {/* Filters */}
            <div className="capstone-filters">
              <div className="filter-year">
                <button
                  className={filterYear === "all" ? "active" : ""}
                  onClick={() => setFilterYear("all")}
                >
                  All
                </button>
                <button
                  className={filterYear === "2019-2023" ? "active" : ""}
                  onClick={() => setFilterYear("2019-2023")}
                >
                  2019-2023
                </button>
                <button
                  className={filterYear === "2014-2018" ? "active" : ""}
                  onClick={() => setFilterYear("2014-2018")}
                >
                  2014-2018
                </button>
              </div>
              <div className="availability-filters">
                <button>Available for Viewing</button>
                <button>Restricted</button>
                <button>More</button>
              </div>
              <div className="sort-dropdown">
                <label>Sort by</label>
                <select>
                  <option value="newest">Newest</option>
                  <option value="oldest">Oldest</option>
                  <option value="title">Title</option>
                </select>
              </div>
            </div>

            {/* Table */}
            <table className="capstone-table">
              <thead>
                <tr>
                  <th>IP Registration Number</th>
                  <th>Title</th>
                  <th>Specialization</th>
                  <th>Year Published</th>
                  <th>Author/s</th>
                  <th>Keyword/s</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                {Array.isArray(itCapstoneProjects.data) && itCapstoneProjects.data.length > 0 ? (
                  itCapstoneProjects.data.map((project, index) => (
                    <tr key={project.id}>
                      <td>{project.ipRegistration}</td>
                      <td>{project.title}</td>
                      <td>{project.specialization}</td>
                      <td>{project.yearPublished}</td>
                      <td>
                        {project.author1}, {project.author2}, {project.author3}, {project.author4}
                      </td>
                      <td>{project.keywords}</td>
                      <td>
                        <button className="view-button">Add to Best IT Capstone list</button>
                        <button className="view-button" onClick={() => handleEdit(project.id)}>
                          Edit
                        </button>
                        <button className="view-button" onClick={() => handleViewAcm(`ACM Document for ${project.title}`)}>
                          View ACM
                        </button>
                        <button className="view-button" onClick={() => handleViewFullDoc(project.id)}>
                          View Full Document
                        </button>
                        <button
                          className="view-button"
                          onClick={() => handleViewApproval(`Approval form for ${project.title}`)}
                        >
                          View Approval Form
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="7">No projects available.</td>
                  </tr>
                )}
              </tbody>
            </table>

            {/* Pagination */}
            <div className="pagination">
              {itCapstoneProjects.links.map((link, index) => (
                <button
                  key={index}
                  disabled={!link.url}
                  onClick={() => router.get(link.url)}
                  dangerouslySetInnerHTML={{ __html: link.label }}
                  className={link.active ? 'active' : ''}
                />
              ))}
            </div>

            <footer className="capstone-footer">
              <button className="submit-button" onClick={handleAdd}>
                Add IT Capstone Project
              </button>
            </footer>
          </div>
        </main>
      </div>

      <AdminModal showModal={showModal} setShowModal={setShowModal} acmDocument={acmDocument} />

      <Footer />
    </div>
  );
};

export default AdminViewITipr;
