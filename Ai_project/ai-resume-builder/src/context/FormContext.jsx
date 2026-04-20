import React, { createContext, useState, useContext } from 'react';

const FormContext = createContext();

export const useFormContext = () => useContext(FormContext);

const initialData = {
  personalInfo: {
    fullName: '',
    jobTitle: '',
    email: '',
    phone: '',
    location: '',
    linkedin: '',
    github: '',
    website: '',
    summary: '',
  },
  education: [],
  experience: [],
  skills: '',
  projects: [],
  certifications: [],
  achievements: '',
  templateId: 'modern-tech' // default template
};

export const FormProvider = ({ children }) => {
  const [formData, setFormData] = useState(initialData);

  const updateFormData = (section, data) => {
    setFormData((prev) => ({
      ...prev,
      [section]: data
    }));
  };

  const setTemplate = (id) => {
    setFormData((prev) => ({
      ...prev,
      templateId: id
    }));
  };

  const regenerateWithAI = async (section, dataToImprove) => {
    // Simulating AI improvement
    return new Promise((resolve) => {
      setTimeout(() => {
        let text = dataToImprove;
        if(typeof dataToImprove === 'string') {
           text = `[AI Improved] ${dataToImprove} with professional terminology and better focus on outcomes and metrics.`;
        }
        resolve(text);
      }, 1000);
    });
  };

  return (
    <FormContext.Provider value={{ formData, updateFormData, setTemplate, regenerateWithAI }}>
      {children}
    </FormContext.Provider>
  );
};
