import React, { useState } from 'react';
import { useFormContext } from '../../context/FormContext';
import { Plus, Trash2, Wand2, Loader } from 'lucide-react';

const ExperienceForm = () => {
  const { formData, updateFormData, regenerateWithAI } = useFormContext();
  const [loadingIndex, setLoadingIndex] = useState(null);

  const addExperience = () => {
    updateFormData('experience', [
      ...formData.experience,
      { company: '', role: '', startDate: '', endDate: '', location: '', description: '' }
    ]);
  };

  const removeExperience = (index) => {
    const updated = formData.experience.filter((_, i) => i !== index);
    updateFormData('experience', updated);
  };

  const handleChange = (index, e) => {
    const { name, value } = e.target;
    const updated = formData.experience.map((item, i) =>
      i === index ? { ...item, [name]: value } : item
    );
    updateFormData('experience', updated);
  };

  const handleAIImprove = async (index) => {
    const exp = formData.experience[index];
    if (!exp.description) return;
    setLoadingIndex(index);
    const improved = await regenerateWithAI('experience', exp.description);
    const updated = formData.experience.map((item, i) =>
      i === index ? { ...item, description: improved } : item
    );
    updateFormData('experience', updated);
    setLoadingIndex(null);
  };

  return (
    <div className="form-section">
      <h3>Work Experience</h3>
      <p style={{ color: 'var(--text-secondary)', marginBottom: '1rem' }}>
        Add your professional experience. Use plain English — AI will refine it.
      </p>

      {formData.experience.map((exp, index) => (
        <div className="item-card" key={index}>
          <button className="delete-btn" onClick={() => removeExperience(index)}>
            <Trash2 size={18} />
          </button>
          <div className="form-grid">
            <div className="form-group">
              <label>Company</label>
              <input
                type="text" name="company" placeholder="Google, Microsoft, etc."
                value={exp.company} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Role / Title</label>
              <input
                type="text" name="role" placeholder="Software Engineer"
                value={exp.role} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Start Date</label>
              <input
                type="text" name="startDate" placeholder="Jan 2022"
                value={exp.startDate} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>End Date</label>
              <input
                type="text" name="endDate" placeholder="Present"
                value={exp.endDate} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Location</label>
              <input
                type="text" name="location" placeholder="San Francisco, CA"
                value={exp.location} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group full-width">
              <label>Description</label>
              <textarea
                name="description" rows="3"
                placeholder="Describe your responsibilities and achievements in plain English..."
                value={exp.description} onChange={(e) => handleChange(index, e)}
              />
              <button className="ai-btn" onClick={() => handleAIImprove(index)} disabled={loadingIndex === index || !exp.description}>
                {loadingIndex === index ? <Loader size={14} className="spin" /> : <Wand2 size={14} />}
                AI Improve Description
              </button>
            </div>
          </div>
        </div>
      ))}

      <button className="add-btn" onClick={addExperience}>
        <Plus size={18} /> Add Experience
      </button>
    </div>
  );
};

export default ExperienceForm;
