'use client';

import { useState, useEffect } from 'react';

const tabs = [
  { id: 'description', label: 'Description' },
  { id: 'applications', label: 'Applications' },
  { id: 'specifications', label: 'Specifications' },
  { id: 'manufacturing', label: 'Manufacturing' },
];

export default function ProductTabs() {
  const [activeTab, setActiveTab] = useState('description');

  useEffect(() => {
    // Create intersection observer to track which section is in view
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            setActiveTab(entry.target.id);
          }
        });
      },
      {
        threshold: 0.3,
        rootMargin: '-100px 0px -66% 0px',
      }
    );

    // Observe all tab sections
    tabs.forEach((tab) => {
      const element = document.getElementById(tab.id);
      if (element) {
        observer.observe(element);
      }
    });

    return () => {
      tabs.forEach((tab) => {
        const element = document.getElementById(tab.id);
        if (element) {
          observer.unobserve(element);
        }
      });
    };
  }, []);

  const handleTabClick = (tabId: string) => {
    const element = document.getElementById(tabId);
    if (element) {
      const offset = 80; // Height of sticky header
      const elementPosition = element.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - offset;
      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth',
      });
    }
  };

  return (
    <div className="sticky top-0 z-40 bg-white border-b border-border shadow-sm">
      <div className="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        <nav className="flex space-x-1 overflow-x-auto no-scrollbar" aria-label="Tabs">
          {tabs.map((tab) => (
            <button
              key={tab.id}
              onClick={() => handleTabClick(tab.id)}
              className={`nav_tab ${activeTab === tab.id ? 'nav_tab--active' : ''}`}
            >
              {tab.label}
            </button>
          ))}
        </nav>
      </div>
    </div>
  );
}
