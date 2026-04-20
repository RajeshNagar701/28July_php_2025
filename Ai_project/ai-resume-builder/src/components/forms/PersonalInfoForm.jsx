import React, { useState } from 'react';
import { useFormContext } from '../../context/FormContext';
import { Wand2, Loader } from 'lucide-react';

const PersonalInfoForm = () => {
  const { formData, updateFormData, regenerateWithAI } = useFormContext();
  const [loadingAI, setLoadingAI] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    updateFormData('personalInfo', { ...formData.personalInfo, [name]: value });
  };

  const handleAIImprovement = async () => {
    if (!formData.personalInfo.summary) return;
    setLoadingAI(true);
    const improvedSummary = await regenerateWithAI('summary', formData.personalInfo.summary);
    updateFormData('personalInfo', { ...formData.personalInfo, summary: improvedSummary });
    setLoadingAI(false);
  };

  const { personalInfo } = formData;

  return (
    <div className="form-section">
      <h3>Personal Information</h3>
      <p style={{color: 'var(--text-secondary)', marginBottom: '1rem'}}>
        Enter your basic details to start building your professional identity.
      </p>

      <div className="form-grid">
        <div className="form-group">
          <label>Full Name</label>
          <input 
            type="text" name="fullName" placeholder="John Doe"
            value={personalInfo.fullName} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>Job Title</label>
          <input 
            type="text" name="jobTitle" placeholder="Full Stack Developer"
            value={personalInfo.jobTitle} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>Email</label>
          <input 
            type="email" name="email" placeholder="john@example.com"
            value={personalInfo.email} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>Phone</label>
          <input 
            type="tel" name="phone" placeholder="+1 (555) 123-4567"
            value={personalInfo.phone} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>Location</label>
          <input 
            type="text" name="location" placeholder="New York, NY"
            value={personalInfo.location} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>LinkedIn URL</label>
          <input 
            type="url" name="linkedin" placeholder="linkedin.com/in/johndoe"
            value={personalInfo.linkedin} onChange={handleChange} 
          />
        </div>
        <div className="form-group">
          <label>GitHub/Portfolio URL</label>
          <input 
            type="url" name="github" placeholder="github.com/johndoe"
            value={personalInfo.github} onChange={handleChange} 
          />
        </div>
        <div className="form-group full-width">
          <label>Professional Summary</label>
          <textarea 
            name="summary" rows="4" 
            placeholder="A brief summary of your professional background and goals..."
            value={personalInfo.summary} onChange={handleChange} 
          />
          <button className="ai-btn" onClick={handleAIImprovement} disabled={loadingAI || !personalInfo.summary}>
            {loadingAI ? <Loader size={14} className="spin" /> : <Wand2 size={14} />}
            AI Improve Summary
          </button>
        </div>
      </div>
    </div>
  );
};

export default PersonalInfoForm;
