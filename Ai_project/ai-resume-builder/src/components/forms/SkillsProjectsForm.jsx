import React, { useState } from 'react';
import { useFormContext } from '../../context/FormContext';
import { Plus, Trash2, Wand2, Loader } from 'lucide-react';

const SkillsProjectsForm = () => {
  const { formData, updateFormData, regenerateWithAI } = useFormContext();
  const [loadingSkills, setLoadingSkills] = useState(false);
  const [loadingAchievements, setLoadingAchievements] = useState(false);

  const handleSkillsChange = (e) => {
    updateFormData('skills', e.target.value);
  };

  const handleAchievementsChange = (e) => {
    updateFormData('achievements', e.target.value);
  };

  const addProject = () => {
    updateFormData('projects', [
      ...formData.projects,
      { name: '', description: '', techStack: '', link: '' }
    ]);
  };

  const removeProject = (index) => {
    const updated = formData.projects.filter((_, i) => i !== index);
    updateFormData('projects', updated);
  };

  const handleProjectChange = (index, e) => {
    const { name, value } = e.target;
    const updated = formData.projects.map((item, i) =>
      i === index ? { ...item, [name]: value } : item
    );
    updateFormData('projects', updated);
  };

  const addCertification = () => {
    updateFormData('certifications', [
      ...formData.certifications,
      { name: '', issuer: '', date: '', link: '' }
    ]);
  };

  const removeCertification = (index) => {
    const updated = formData.certifications.filter((_, i) => i !== index);
    updateFormData('certifications', updated);
  };

  const handleCertChange = (index, e) => {
    const { name, value } = e.target;
    const updated = formData.certifications.map((item, i) =>
      i === index ? { ...item, [name]: value } : item
    );
    updateFormData('certifications', updated);
  };

  const handleAISkills = async () => {
    if (!formData.skills) return;
    setLoadingSkills(true);
    const improved = await regenerateWithAI('skills', formData.skills);
    updateFormData('skills', improved);
    setLoadingSkills(false);
  };

  const handleAIAchievements = async () => {
    if (!formData.achievements) return;
    setLoadingAchievements(true);
    const improved = await regenerateWithAI('achievements', formData.achievements);
    updateFormData('achievements', improved);
    setLoadingAchievements(false);
  };

  return (
    <div className="form-section">
      <h3>Skills</h3>
      <p style={{ color: 'var(--text-secondary)', marginBottom: '1rem' }}>
        List your technical and soft skills (comma separated).
      </p>
      <div className="form-group">
        <textarea
          rows="3"
          placeholder="React, Node.js, Python, Machine Learning, Project Management..."
          value={formData.skills}
          onChange={handleSkillsChange}
        />
        <button className="ai-btn" onClick={handleAISkills} disabled={loadingSkills || !formData.skills}>
          {loadingSkills ? <Loader size={14} className="spin" /> : <Wand2 size={14} />}
          AI Enhance Skills
        </button>
      </div>

      <h3 style={{ marginTop: '2rem' }}>Projects</h3>
      <p style={{ color: 'var(--text-secondary)', marginBottom: '1rem' }}>
        Showcase your best work.
      </p>

      {formData.projects.map((proj, index) => (
        <div className="item-card" key={index}>
          <button className="delete-btn" onClick={() => removeProject(index)}>
            <Trash2 size={18} />
          </button>
          <div className="form-grid">
            <div className="form-group">
              <label>Project Name</label>
              <input
                type="text" name="name" placeholder="AI Chat Application"
                value={proj.name} onChange={(e) => handleProjectChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Tech Stack</label>
              <input
                type="text" name="techStack" placeholder="React, Node.js, MongoDB"
                value={proj.techStack} onChange={(e) => handleProjectChange(index, e)}
              />
            </div>
            <div className="form-group full-width">
              <label>Description</label>
              <textarea
                name="description" rows="2"
                placeholder="Describe what the project does and your role..."
                value={proj.description} onChange={(e) => handleProjectChange(index, e)}
              />
            </div>
            <div className="form-group full-width">
              <label>Live/Repo Link (Optional)</label>
              <input
                type="url" name="link" placeholder="https://github.com/..."
                value={proj.link} onChange={(e) => handleProjectChange(index, e)}
              />
            </div>
          </div>
        </div>
      ))}
      <button className="add-btn" onClick={addProject}>
        <Plus size={18} /> Add Project
      </button>

      <h3 style={{ marginTop: '2rem' }}>Certifications</h3>
      {formData.certifications.map((cert, index) => (
        <div className="item-card" key={index}>
          <button className="delete-btn" onClick={() => removeCertification(index)}>
            <Trash2 size={18} />
          </button>
          <div className="form-grid">
            <div className="form-group">
              <label>Certification Name</label>
              <input
                type="text" name="name" placeholder="AWS Solutions Architect"
                value={cert.name} onChange={(e) => handleCertChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Issuer</label>
              <input
                type="text" name="issuer" placeholder="Amazon Web Services"
                value={cert.issuer} onChange={(e) => handleCertChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Date</label>
              <input
                type="text" name="date" placeholder="March 2023"
                value={cert.date} onChange={(e) => handleCertChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Link (Optional)</label>
              <input
                type="url" name="link" placeholder="https://credential.net/..."
                value={cert.link} onChange={(e) => handleCertChange(index, e)}
              />
            </div>
          </div>
        </div>
      ))}
      <button className="add-btn" onClick={addCertification}>
        <Plus size={18} /> Add Certification
      </button>

      <h3 style={{ marginTop: '2rem' }}>Achievements</h3>
      <div className="form-group">
        <textarea
          rows="3"
          placeholder="Won first place in XYZ hackathon, Published paper in ABC journal..."
          value={formData.achievements}
          onChange={handleAchievementsChange}
        />
        <button className="ai-btn" onClick={handleAIAchievements} disabled={loadingAchievements || !formData.achievements}>
          {loadingAchievements ? <Loader size={14} className="spin" /> : <Wand2 size={14} />}
          AI Enhance Achievements
        </button>
      </div>
    </div>
  );
};

export default SkillsProjectsForm;
