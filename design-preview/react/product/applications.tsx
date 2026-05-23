'use client';

import { useState } from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';

export default function Applications() {
  const [currentSlide, setCurrentSlide] = useState(0);

  const applications = [
    {
      title: 'Electrical Connectors',
      description: 'High conductivity for terminals, bus bars, and switchgear components',
      industries: ['Power Distribution', 'Electronics'],
      image: '/placeholder-electrical.jpg',
    },
    {
      title: 'Heat Exchangers',
      description: 'Superior thermal conductivity for HVAC, refrigeration, and radiators',
      industries: ['HVAC', 'Automotive'],
      image: '/placeholder-heat-exchanger.jpg',
    },
    {
      title: 'Architectural Applications',
      description: 'Roofing, cladding, gutters with excellent corrosion resistance',
      industries: ['Construction', 'Architecture'],
      image: '/placeholder-architecture.jpg',
    },
    {
      title: 'Industrial Equipment',
      description: 'Gaskets, washers, and precision parts for manufacturing',
      industries: ['Manufacturing', 'Oil & Gas'],
      image: '/placeholder-industrial.jpg',
    },
    {
      title: 'Electronic Components',
      description: 'PCB substrates, shielding, and semiconductor applications',
      industries: ['Electronics', 'Telecommunications'],
      image: '/placeholder-electronics.jpg',
    },
    {
      title: 'Marine Hardware',
      description: 'Saltwater resistant fittings, propellers, and fasteners',
      industries: ['Marine', 'Offshore'],
      image: '/placeholder-marine.jpg',
    },
  ];

  const itemsPerSlide = 3;
  const maxSlides = Math.ceil(applications.length / itemsPerSlide);

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev + 1) % maxSlides);
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + maxSlides) % maxSlides);
  };

  return (
    <section id="applications" className="bg-muted/30 py-16">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-12 text-center">
          <h2 className="text-3xl font-bold text-foreground md:text-4xl">
            Applications & Use Cases
          </h2>
          <p className="mt-3 text-muted-foreground max-w-2xl mx-auto">
            Proven solutions across diverse industries. From aerospace to marine environments.
          </p>
        </div>

        {/* Slider Container */}
        <div className="relative px-12">
          {/* Navigation Arrows */}
          <button
            onClick={prevSlide}
            className="absolute left-0 top-1/2 -translate-y-1/2 z-10 p-2 rounded-full bg-white border-2 border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white transition-colors shadow-lg"
            aria-label="Previous applications"
          >
            <ChevronLeft className="w-5 h-5" />
          </button>
          <button
            onClick={nextSlide}
            className="absolute right-0 top-1/2 -translate-y-1/2 z-10 p-2 rounded-full bg-white border-2 border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white transition-colors shadow-lg"
            aria-label="Next applications"
          >
            <ChevronRight className="w-5 h-5" />
          </button>

          {/* Main Slide */}
          <div className="overflow-hidden">
            <div 
              className="flex transition-transform duration-500 ease-out"
              style={{ transform: `translateX(-${currentSlide * 100}%)` }}
            >
              {Array.from({ length: maxSlides }).map((_, slideIndex) => (
                <div key={slideIndex} className="w-full flex-shrink-0">
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {applications
                      .slice(slideIndex * itemsPerSlide, (slideIndex + 1) * itemsPerSlide)
                      .map((app, idx) => (
                        <div
                          key={idx}
                          className="bg-white rounded border border-border overflow-hidden hover:shadow-lg transition-shadow"
                        >
                          {/* Image */}
                          <div className="aspect-[4/3] bg-gradient-to-br from-[#C87533]/20 to-[#B87333]/40 flex items-center justify-center">
                            <span className="font-mono text-3xl font-bold text-white/30">
                              {app.title.split(' ')[0]}
                            </span>
                          </div>

                          {/* Content */}
                          <div className="p-6">
                            <h3 className="text-lg font-bold text-foreground mb-2">
                              {app.title}
                            </h3>
                            <p className="text-sm text-muted-foreground leading-relaxed">
                              {app.description}
                            </p>
                          </div>
                        </div>
                      ))}
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* Dots Indicator */}
          <div className="flex justify-center gap-2 mt-8">
            {Array.from({ length: maxSlides }).map((_, idx) => (
              <button
                key={idx}
                onClick={() => setCurrentSlide(idx)}
                className={`h-2 rounded-full transition-all ${
                  currentSlide === idx
                    ? 'w-8 bg-[#F97C30]'
                    : 'w-2 bg-border hover:bg-[#F97C30]/50'
                }`}
                aria-label={`Go to slide ${idx + 1}`}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
