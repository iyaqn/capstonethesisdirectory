import React, { useState, useEffect } from "react";
import "../../../css/AdminView/AdminIPreg.css";
import { router, usePage } from '@inertiajs/react';
import AdminSidebar from "./AdminSidebar";
import Header from "../General/Header";
import Footer from "../General/Footer";
import AdminModal from "./AdminModal"; 

const AdminViewCSipr = () => {
  const {
    csThesisPapers,
    searchQuery: initialSearchQuery,
    filterYear: initialFilterYear,
    filterSpecialization: initialFilterSpecialization,
    sortBy: initialSortBy
  } = usePage().props;

  const [searchQuery, setSearchQuery] = useState(initialSearchQuery || "");
  const [filterYear, setFilterYear] = useState(initialFilterYear || "all");
  const [filterSpecialization, setFilterSpecialization] = useState(initialFilterSpecialization || "");
  const [sortBy, setSortBy] = useState(initialSortBy || "alphabetical");
  const [showModal, setShowModal] = useState(false);
  const [acmDocument, setAcmDocument] = useState(null);

  const handleSearchChange = (e) => setSearchQuery(e.target.value);
  const handleYearFilterChange = (e) => setFilterYear(e.target.value);
  const handleSpecializationChange = (e) => setFilterSpecialization(e.target.value);
  const handleSortChange = (e) => setSortBy(e.target.value);

  const handleAdd = () => {
    router.visit("/admin/add-CS-Thes");
  };

  const handleViewAcm = (doc) => {
    setAcmDocument(doc);
    setShowModal(true); 
  };

  const handleViewFullDoc = (doc) => {
    router.visit("/admin/full-document", { state: { fullDocument: doc } });
  };

  const handleViewApproval = (doc) => {
    router.visit("/admin/approval-form", { state: { approvalForm: doc } });
  };

  const handleEdit = (projectId) => {
    router.visit(`/admin/edit-CS-Thes/${projectId}`);
  };

  const handleSearchSubmit = (e) => {
    e.preventDefault(); // Prevent page reload

    router.visit(route('admin/ip-registered/CS-thes', {
      search: searchQuery,

    }), { preserveState: true, preserveScroll: true });
  };

  useEffect(() => {
    // Auto-fetch on sort and filter change
    router.visit(route('admin/ip-registered/CS-thes', {

      filterYear,
      filterSpecialization,
      sortBy
    }), { preserveState: true, preserveScroll: true });
  }, [filterYear, filterSpecialization, sortBy]);

  const toggleBestCapstone = (projectId, isBest) => {
    router.put(`/admin/toggle-best-capstone/${projectId}`, {
      is_best_proj: isBest
    }, { preserveScroll: true });
  };

  return (
    <div className="admin-home">
      <Header />
      <div className="content-container">
        <AdminSidebar />
        <main className="main-content">
          <div className="capstone-container">
            <header className="capstone-header">
              <h1>IP-registered CS Thesis Papers</h1>
              <div className="search-bar">
                <form onSubmit={handleSearchSubmit}>
                  <input
                    type="text"
                    placeholder="Search..."
                    value={searchQuery}
                    onChange={handleSearchChange}
                  />
                  <button type="submit" className="search-button">
                    <img src="/search-icon.png" alt="Search" />
                  </button>
                </form>
              </div>
            </header>

            {/* Filters */}
            <div className="capstone-filters">
              {/* Year Filter */}
              <div className="sort-dropdown">
                <label>Year:</label>
                <select value={filterYear} onChange={handleYearFilterChange}>
                  <option value="all">All</option>
                  <option value="at-most-5">At most 5 years old</option>
                  <option value="at-least-5">At least 5 years old</option>
                  {/* You can add more year options or custom ranges */}
                </select>
              </div>

              {/* Specialization Filter */}
              <div className="sort-dropdown">
                <label>Specialization:</label>
                <select value={filterSpecialization} onChange={handleSpecializationChange}>
                  <option value="">All Specializations</option>
                  <option value="Core Computer Science">Core Computer Science</option>
                  <option value="Game Development">Game Development</option>
                  <option value="Data Analytics">Data Analytics</option>
                </select>
              </div>

              {/* Sort By */}
              <div className="sort-dropdown">
                <label>Sort by:</label>
                <select value={sortBy} onChange={handleSortChange}>
                  <option value="alphabetical">Alphabetical (Title)</option>
                  <option value="newest">Newest</option>
                  <option value="oldest">Oldest</option>
                  <option value="best">Best</option>
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
                  <th>Best Capstone</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                {Array.isArray(csThesisPapers.data) && csThesisPapers.data.length > 0 ? (
                  csThesisPapers.data.map((project) => (
                    <tr key={project.id}>
                      <td>{project.ipRegistration}</td>
                      <td>{project.title}</td>
                      <td>{project.specialization}</td>
                      <td>{project.yearPublished}</td>
                      <td>{project.author1}, {project.author2}, {project.author3}, {project.author4}</td>
                      <td>{project.keywords}</td>
                      <td>
                        <input 
                          type="checkbox" 
                          checked={project.is_best_proj} 
                          onChange={(e) => toggleBestCapstone(project.id, e.target.checked)} 
                        />
                      </td>
                      <td>
                        <button className="view-button" onClick={() => handleEdit(project.id)}>Edit</button>
                        <button className="view-button" onClick={() => handleViewAcm(`ACM Document for ${project.title}`)}>View ACM</button>
                        <button className="view-button" onClick={() => handleViewFullDoc(project.id)}>View Full Document</button>
                        <button className="view-button" onClick={() => handleViewApproval(`Approval form for ${project.title}`)}>View Approval Form</button>
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
              {csThesisPapers.links.map((link, index) => (
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
              <button className="submit-button" onClick={handleAdd}>Add CS Thesis Papers</button>
            </footer>
          </div>
        </main>
      </div>

      <AdminModal showModal={showModal} setShowModal={setShowModal} acmDocument={acmDocument} />
      <Footer />
    </div>
  );
};

export default AdminViewCSipr;
