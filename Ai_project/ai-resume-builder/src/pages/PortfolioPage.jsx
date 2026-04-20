import React from 'react';
import { useNavigate } from 'react-router-dom';
import { motion } from 'framer-motion';
import { useFormContext } from '../context/FormContext';
import { ArrowLeft, Mail, Phone, MapPin, Link2, Code, ExternalLink, Sparkles } from 'lucide-react';
import './PortfolioPage.css';

const PortfolioPage = () => {
  const navigate = useNavigate();
  const { formData } = useFormContext();
  const { personalInfo, education, experience, skills, projects, certifications, achievements } = formData;
  const skillsList = skills ? skills.split(',').map(s => s.trim()).filter(Boolean) : [];

  const sectionVariants = {
    hidden: { opacity: 0, y: 30 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.6 } }
  };

  return (
    <div className="portfolio-page">
      <button className="back-btn" onClick={() => navigate('/build')}>
        <ArrowLeft size={18} /> Back to Builder
      </button>

      {/* Hero */}
      <motion.section 
        className="portfolio-hero"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ duration: 0.8 }}
      >
        <div className="hero-orb hero-orb-1"></div>
        <div className="hero-orb hero-orb-2"></div>
        <div className="portfolio-hero-content">
          <div className="portfolio-avatar">
            {(personalInfo.fullName || 'U')[0].toUpperCase()}
          </div>
          <h1 className="portfolio-name gradient-text">{personalInfo.fullName || 'Your Name'}</h1>
          <p className="portfolio-title">{personalInfo.jobTitle || 'Your Title'}</p>
          <div className="portfolio-links">
            {personalInfo.email && (
              <a href={`mailto:${personalInfo.email}`}><Mail size={16} /> Email</a>
            )}
            {personalInfo.phone && (
              <a href={`tel:${personalInfo.phone}`}><Phone size={16} /> Phone</a>
            )}
            {personalInfo.linkedin && (
              <a href={personalInfo.linkedin} target="_blank" rel="noreferrer"><Link2 size={16} /> LinkedIn</a>
            )}
            {personalInfo.github && (
              <a href={personalInfo.github} target="_blank" rel="noreferrer"><Code size={16} /> GitHub</a>
            )}
          </div>
        </div>
      </motion.section>

      <div className="portfolio-body container">
        {/* About */}
        {personalInfo.summary && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2><Sparkles size={20} /> About Me</h2>
            <p className="about-text">{personalInfo.summary}</p>
          </motion.section>
        )}

        {/* Skills */}
        {skillsList.length > 0 && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Skills</h2>
            <div className="portfolio-skills">
              {skillsList.map((skill, i) => (
                <span key={i} className="portfolio-skill-tag">{skill}</span>
              ))}
            </div>
          </motion.section>
        )}

        {/* Experience */}
        {experience.length > 0 && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Experience</h2>
            <div className="timeline">
              {experience.map((exp, i) => (
                <div className="timeline-item glass-panel" key={i}>
                  <div className="timeline-dot"></div>
                  <div className="timeline-content">
                    <h3>{exp.role}</h3>
                    <p className="timeline-meta">{exp.company} {exp.location && `• ${exp.location}`}</p>
                    <span className="timeline-date">{exp.startDate} – {exp.endDate}</span>
                    {exp.description && <p className="timeline-desc">{exp.description}</p>}
                  </div>
                </div>
              ))}
            </div>
          </motion.section>
        )}

        {/* Projects */}
        {projects.length > 0 && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Projects</h2>
            <div className="projects-grid">
              {projects.map((proj, i) => (
                <div className="project-card glass-panel" key={i}>
                  <div className="project-card-header">
                    <h3>{proj.name || 'Project'}</h3>
                    {proj.link && (
                      <a href={proj.link} target="_blank" rel="noreferrer">
                        <ExternalLink size={16} />
                      </a>
                    )}
                  </div>
                  {proj.techStack && (
                    <div className="project-tech">
                      {proj.techStack.split(',').map((t, j) => (
                        <span key={j} className="tech-pill">{t.trim()}</span>
                      ))}
                    </div>
                  )}
                  {proj.description && <p>{proj.description}</p>}
                </div>
              ))}
            </div>
          </motion.section>
        )}

        {/* Education */}
        {education.length > 0 && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Education</h2>
            <div className="edu-grid">
              {education.map((edu, i) => (
                <div className="edu-card glass-panel" key={i}>
                  <h3>{edu.degree} {edu.field && `in ${edu.field}`}</h3>
                  <p>{edu.institution}</p>
                  <span className="edu-date">{edu.startDate} – {edu.endDate}</span>
                  {edu.grade && <p className="edu-grade">GPA: {edu.grade}</p>}
                </div>
              ))}
            </div>
          </motion.section>
        )}

        {/* Certifications */}
        {certifications.length > 0 && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Certifications</h2>
            <div className="cert-list">
              {certifications.map((cert, i) => (
                <div className="cert-item glass-panel" key={i}>
                  <strong>{cert.name}</strong>
                  <span>{cert.issuer} — {cert.date}</span>
                </div>
              ))}
            </div>
          </motion.section>
        )}

        {/* Achievements */}
        {achievements && (
          <motion.section 
            className="portfolio-section"
            variants={sectionVariants}
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true }}
          >
            <h2>Achievements</h2>
            <p className="about-text">{achievements}</p>
          </motion.section>
        )}

        {/* Contact */}
        <motion.section 
          className="portfolio-section contact-section"
          variants={sectionVariants}
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true }}
        >
          <h2>Get in Touch</h2>
          <p className="contact-text">Interested in working together? Feel free to reach out!</p>
          <div className="contact-cards">
            {personalInfo.email && (
              <a href={`mailto:${personalInfo.email}`} className="contact-card glass-panel">
                <Mail size={24} />
                <span>{personalInfo.email}</span>
              </a>
            )}
            {personalInfo.phone && (
              <a href={`tel:${personalInfo.phone}`} className="contact-card glass-panel">
                <Phone size={24} />
                <span>{personalInfo.phone}</span>
              </a>
            )}
            {personalInfo.location && (
              <div className="contact-card glass-panel">
                <MapPin size={24} />
                <span>{personalInfo.location}</span>
              </div>
            )}
          </div>
        </motion.section>
      </div>

      <footer className="portfolio-footer">
        <p>Built with <span className="gradient-text">Synthetix</span> — AI Resume & Portfolio Builder</p>
      </footer>
    </div>
  );
};

export default PortfolioPage;
