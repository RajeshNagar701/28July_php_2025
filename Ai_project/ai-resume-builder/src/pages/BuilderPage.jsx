import React, { useState, useRef } from 'react';
import { useNavigate } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { ChevronRight, ChevronLeft, Download, CheckCircle, Wand2, Eye } from 'lucide-react';
import { useFormContext } from '../context/FormContext';
import PersonalInfoForm from '../components/forms/PersonalInfoForm';
import EducationForm from '../components/forms/EducationForm';
import ExperienceForm from '../components/forms/ExperienceForm';
import SkillsProjectsForm from '../components/forms/SkillsProjectsForm';
import ResumePreview from '../components/ResumePreview';
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';
import './BuilderPage.css';

const steps = [
  { id: 'personal', title: 'Personal Info' },
  { id: 'education', title: 'Education' },
  { id: 'experience', title: 'Experience' },
  { id: 'skills', title: 'Skills & Projects' },
  { id: 'preview', title: 'Preview & Export' }
];

const BuilderPage = () => {
  const [currentStep, setCurrentStep] = useState(0);
  const { formData } = useFormContext();
  const navigate = useNavigate();
  const resumeRef = useRef(null);

  const nextStep = () => setCurrentStep(prev => Math.min(prev + 1, steps.length - 1));
  const prevStep = () => setCurrentStep(prev => Math.max(prev - 1, 0));

  const handleDownloadPDF = async () => {
    const element = resumeRef.current;
    if (!element) return;
    
    // Set scale higher for better resolution
    const canvas = await html2canvas(element, { 
      scale: 2,
      useCORS: true,
      logging: false
    });
    
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4'
    });

    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
    
    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
    pdf.save(`${formData.personalInfo.fullName || 'Resume'}.pdf`);
  };

  const renderStepContent = () => {
    switch (currentStep) {
      case 0: return <PersonalInfoForm />;
      case 1: return <EducationForm />;
      case 2: return <ExperienceForm />;
      case 3: return <SkillsProjectsForm />;
      case 4: return (
        <div className="preview-container-wrapper">
           <div className="resume-paper" ref={resumeRef}>
             <ResumePreview />
           </div>
        </div>
      );
      default: return null;
    }
  };

  return (
    <div className="builder-layout">
      {/* Sidebar / Progress */}
      <aside className="builder-sidebar">
        <div className="sidebar-header" onClick={() => navigate('/')} style={{cursor: 'pointer'}}>
          <SparklesIcon /> <span>Synthetix</span>
        </div>
        
        <div className="steps-container">
          {steps.map((step, index) => (
            <div 
              key={step.id} 
              className={`step-item ${index === currentStep ? 'active' : ''} ${index < currentStep ? 'completed' : ''}`}
              onClick={() => setCurrentStep(index)}
            >
              <div className="step-indicator">
                {index < currentStep ? <CheckCircle size={14} /> : index + 1}
              </div>
              <span className="step-title">{step.title}</span>
            </div>
          ))}
        </div>

        <div className="sidebar-footer">
          <button className="secondary-btn" onClick={() => navigate('/portfolio')}>
            <Eye size={16} /> View Portfolio
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <main className="builder-main">
        <div className="builder-header">
          <h2>{steps[currentStep].title}</h2>
          {currentStep === 4 && (
            <button className="primary-btn sm" onClick={handleDownloadPDF}>
              <Download size={16} /> Download PDF
            </button>
          )}
        </div>

        <div className="builder-content">
          <AnimatePresence mode="wait">
            <motion.div
              key={currentStep}
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
              transition={{ duration: 0.3 }}
              className="step-content-inner"
            >
              {renderStepContent()}
            </motion.div>
          </AnimatePresence>
        </div>

        <div className="builder-controls">
          <button 
            className="control-btn prev" 
            onClick={prevStep} 
            disabled={currentStep === 0}
          >
            <ChevronLeft size={20} /> Back
          </button>
          
          {currentStep < steps.length - 1 ? (
            <button className="control-btn next gradient-bg" onClick={nextStep}>
              Next Step <ChevronRight size={20} />
            </button>
          ) : (
            <button className="control-btn next gradient-bg" onClick={() => navigate('/portfolio')}>
              Generate Portfolio <ChevronRight size={20} />
            </button>
          )}
        </div>
      </main>
    </div>
  );
};

const SparklesIcon = () => (
  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" style={{color: 'var(--accent-cyan)'}}>
    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
    <path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/>
  </svg>
);

export default BuilderPage;
