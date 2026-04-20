import React, { useState } from 'react';
import { useFormContext } from '../context/FormContext';
import { Mail, Phone, MapPin, Link2, Code, ExternalLink } from 'lucide-react';
import './ResumePreview.css';

const templates = [
  { id: 'modern-tech', name: 'Modern Tech', accent: '#3b82f6' },
  { id: 'classic-elegant', name: 'Classic Elegant', accent: '#0f766e' },
  { id: 'bold-creative', name: 'Bold Creative', accent: '#7c3aed' },
];

const ResumePreview = () => {
  const { formData, setTemplate } = useFormContext();
  const { personalInfo, education, experience, skills, projects, certifications, achievements, templateId } = formData;

  const currentTemplate = templates.find(t => t.id === templateId) || templates[0];
  const accentColor = currentTemplate.accent;

  const skillsList = skills ? skills.split(',').map(s => s.trim()).filter(Boolean) : [];

  return (
    <div className="resume-preview-wrapper">
      {/* Template Selector */}
      <div className="template-selector" style={{ marginBottom: '1.5rem' }}>
        {templates.map(t => (
          <button
            key={t.id}
            className={`template-chip ${templateId === t.id ? 'active' : ''}`}
            style={{ '--chip-accent': t.accent }}
            onClick={() => setTemplate(t.id)}
          >
            <span className="chip-dot" style={{ background: t.accent }}></span>
            {t.name}
          </button>
        ))}
      </div>

      {/* Resume Content */}
      <div className={`resume-template ${templateId}`}>
        {/* Header */}
        <div className="resume-header" style={{ borderBottomColor: accentColor }}>
          <h1 style={{ color: accentColor }}>{personalInfo.fullName || 'Your Name'}</h1>
          <p className="resume-jobtitle">{personalInfo.jobTitle || 'Your Job Title'}</p>
          <div className="resume-contact-row">
            {personalInfo.email && (
              <span><Mail size={12} /> {personalInfo.email}</span>
            )}
            {personalInfo.phone && (
              <span><Phone size={12} /> {personalInfo.phone}</span>
            )}
            {personalInfo.location && (
              <span><MapPin size={12} /> {personalInfo.location}</span>
            )}
            {personalInfo.linkedin && (
              <span><Link2 size={12} /> {personalInfo.linkedin}</span>
            )}
            {personalInfo.github && (
              <span><Code size={12} /> {personalInfo.github}</span>
            )}
          </div>
        </div>

        {/* Summary */}
        {personalInfo.summary && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Professional Summary</h2>
            <p className="resume-text">{personalInfo.summary}</p>
          </div>
        )}

        {/* Experience */}
        {experience.length > 0 && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Work Experience</h2>
            {experience.map((exp, i) => (
              <div className="resume-entry" key={i}>
                <div className="entry-header">
                  <div>
                    <strong>{exp.role || 'Role'}</strong>
                    <span className="entry-company"> — {exp.company || 'Company'}</span>
                  </div>
                  <span className="entry-date">{exp.startDate} – {exp.endDate}</span>
                </div>
                {exp.location && <p className="entry-location">{exp.location}</p>}
                {exp.description && <p className="resume-text">{exp.description}</p>}
              </div>
            ))}
          </div>
        )}

        {/* Education */}
        {education.length > 0 && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Education</h2>
            {education.map((edu, i) => (
              <div className="resume-entry" key={i}>
                <div className="entry-header">
                  <div>
                    <strong>{edu.degree} in {edu.field}</strong>
                    <span className="entry-company"> — {edu.institution}</span>
                  </div>
                  <span className="entry-date">{edu.startDate} – {edu.endDate}</span>
                </div>
                {edu.grade && <p className="entry-location">GPA: {edu.grade}</p>}
                {edu.description && <p className="resume-text">{edu.description}</p>}
              </div>
            ))}
          </div>
        )}

        {/* Skills */}
        {skillsList.length > 0 && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Skills</h2>
            <div className="skills-tags">
              {skillsList.map((skill, i) => (
                <span key={i} className="skill-tag" style={{ borderColor: accentColor, color: accentColor }}>{skill}</span>
              ))}
            </div>
          </div>
        )}

        {/* Projects */}
        {projects.length > 0 && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Projects</h2>
            {projects.map((proj, i) => (
              <div className="resume-entry" key={i}>
                <div className="entry-header">
                  <strong>{proj.name || 'Project'}</strong>
                  {proj.link && (
                    <a href={proj.link} target="_blank" rel="noreferrer" className="entry-link" style={{color: accentColor}}>
                      <ExternalLink size={12} /> Link
                    </a>
                  )}
                </div>
                {proj.techStack && <p className="entry-location">Tech: {proj.techStack}</p>}
                {proj.description && <p className="resume-text">{proj.description}</p>}
              </div>
            ))}
          </div>
        )}

        {/* Certifications */}
        {certifications.length > 0 && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Certifications</h2>
            {certifications.map((cert, i) => (
              <div className="resume-entry" key={i}>
                <div className="entry-header">
                  <strong>{cert.name}</strong>
                  <span className="entry-date">{cert.date}</span>
                </div>
                <p className="entry-location">{cert.issuer}</p>
              </div>
            ))}
          </div>
        )}

        {/* Achievements */}
        {achievements && (
          <div className="resume-section">
            <h2 className="section-title" style={{ color: accentColor }}>Achievements</h2>
            <p className="resume-text">{achievements}</p>
          </div>
        )}
      </div>
    </div>
  );
};

export default ResumePreview;
