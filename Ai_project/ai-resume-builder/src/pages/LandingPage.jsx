import React from 'react';
import { useNavigate } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Sparkles, FileText, Globe, Zap, ArrowRight } from 'lucide-react';
import './LandingPage.css';

const LandingPage = () => {
  const navigate = useNavigate();

  const containerVariants = {
    hidden: { opacity: 0 },
    visible: { 
      opacity: 1,
      transition: { staggerChildren: 0.2 }
    }
  };

  const itemVariants = {
    hidden: { y: 20, opacity: 0 },
    visible: { y: 0, opacity: 1, transition: { duration: 0.5 } }
  };

  return (
    <div className="landing-container">
      {/* Background Elements */}
      <div className="orb orb-1"></div>
      <div className="orb orb-2"></div>
      <div className="orb orb-3"></div>
      
      <div className="container">
        <nav className="navbar">
          <div className="logo">
            <Sparkles className="logo-icon" />
            <span>Synthetix</span>
          </div>
          <button className="nav-btn" onClick={() => navigate('/build')}>
            Launch App
          </button>
        </nav>

        <motion.main 
          className="hero-section"
          variants={containerVariants}
          initial="hidden"
          animate="visible"
        >
          <motion.div variants={itemVariants} className="badge">
            <Sparkles size={16} />
            <span>AI-Powered Generation</span>
          </motion.div>

          <motion.h1 variants={itemVariants} className="hero-title">
            The Future of <br/>
            <span className="gradient-text">Professional Identity</span>
          </motion.h1>

          <motion.p variants={itemVariants} className="hero-subtitle">
            Create a stunning resume and a personal portfolio website in minutes.<br/>
            Powered by advanced AI suggestions and next-gen design systems.
          </motion.p>

          <motion.div variants={itemVariants} className="hero-actions">
            <button className="primary-btn gradient-bg" onClick={() => navigate('/build')}>
              <span>Start Building Free</span>
              <ArrowRight size={20} />
            </button>
          </motion.div>

          <motion.div variants={itemVariants} className="features-grid">
            <div className="feature-card glass-panel">
              <div className="feature-icon"><FileText size={24} /></div>
              <h3>Smart Resumes</h3>
              <p>Multiple premium templates with AI-enhanced bullet points for maximum impact.</p>
            </div>
            <div className="feature-card glass-panel">
              <div className="feature-icon"><Globe size={24} /></div>
              <h3>Instant Portfolio</h3>
              <p>Automatically generate a responsive web portfolio from your resume data.</p>
            </div>
            <div className="feature-card glass-panel">
              <div className="feature-icon"><Zap size={24} /></div>
              <h3>Lightning Fast</h3>
              <p>Export to PDF or deploy your site instantly without writing any code.</p>
            </div>
          </motion.div>
        </motion.main>
      </div>
    </div>
  );
};

export default LandingPage;
