import React from 'react';
import { useFormContext } from '../../context/FormContext';
import { Plus, Trash2 } from 'lucide-react';

const EducationForm = () => {
  const { formData, updateFormData } = useFormContext();

  const addEducation = () => {
    updateFormData('education', [
      ...formData.education,
      { institution: '', degree: '', field: '', startDate: '', endDate: '', grade: '', description: '' }
    ]);
  };

  const removeEducation = (index) => {
    const updated = formData.education.filter((_, i) => i !== index);
    updateFormData('education', updated);
  };

  const handleChange = (index, e) => {
    const { name, value } = e.target;
    const updated = formData.education.map((item, i) =>
      i === index ? { ...item, [name]: value } : item
    );
    updateFormData('education', updated);
  };

  return (
    <div className="form-section">
      <h3>Education</h3>
      <p style={{ color: 'var(--text-secondary)', marginBottom: '1rem' }}>
        Add your educational background, starting with the most recent.
      </p>

      {formData.education.map((edu, index) => (
        <div className="item-card" key={index}>
          <button className="delete-btn" onClick={() => removeEducation(index)}>
            <Trash2 size={18} />
          </button>
          <div className="form-grid">
            <div className="form-group">
              <label>Institution</label>
              <input
                type="text" name="institution" placeholder="MIT, Harvard, etc."
                value={edu.institution} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Degree</label>
              <input
                type="text" name="degree" placeholder="Bachelor's, Master's, etc."
                value={edu.degree} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Field of Study</label>
              <input
                type="text" name="field" placeholder="Computer Science"
                value={edu.field} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Grade / GPA</label>
              <input
                type="text" name="grade" placeholder="3.8/4.0"
                value={edu.grade} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>Start Date</label>
              <input
                type="text" name="startDate" placeholder="Aug 2018"
                value={edu.startDate} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group">
              <label>End Date</label>
              <input
                type="text" name="endDate" placeholder="May 2022 or Present"
                value={edu.endDate} onChange={(e) => handleChange(index, e)}
              />
            </div>
            <div className="form-group full-width">
              <label>Description (Optional)</label>
              <textarea
                name="description" rows="2"
                placeholder="Relevant coursework, honors, activities..."
                value={edu.description} onChange={(e) => handleChange(index, e)}
              />
            </div>
          </div>
        </div>
      ))}

      <button className="add-btn" onClick={addEducation}>
        <Plus size={18} /> Add Education
      </button>
    </div>
  );
};

export default EducationForm;
