'use client';

import { useState } from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { Button } from '@/components/ui/button';

const equipment = [
  {
    name: 'Cnc precision machining',
    capacity: 75,
  },
  {
    name: 'Extrusion press line',
    capacity: 85,
  },
  {
    name: 'Heat treatment furnace',
    capacity: 70,
  },
  {
    name: 'Quality testing lab',
    capacity: 90,
  },
  {
    name: 'Rolling mill station',
    capacity: 80,
  },
  {
    name: 'Wire drawing equipment',
    capacity: 65,
  },
];

export default function ProductionLine() {
  const [currentSlide, setCurrentSlide] = useState(0);
  const itemsPerSlide = 1;
  const maxSlides = Math.ceil(equipment.length / itemsPerSlide);

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev + 1) % maxSlides);
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev - 1 + maxSlides) % maxSlides);
  };

  return (
    <section className="bg-[#F2F4F7] pt-[100px] pb-[100px]">
      <div className="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="mb-4 text-center">
          <p className="mb-2 font-mono text-sm font-semibold uppercase tracking-wider text-[#F97C30]">
            STATE-OF-THE-ART FACILITY
          </p>
          <h2 className="text-heading text-3xl font-bold text-[#0B3570] md:text-4xl">
            Advanced Production Equipment
          </h2>
        </div>
        <p className="mx-auto mb-12 max-w-2xl text-center text-base leading-relaxed text-[#0B3570]/70">
          Our manufacturing facility features cutting-edge equipment and precision machinery to deliver the highest quality copper and brass products.
        </p>

        {/* Equipment Slider */}
        <div className="relative px-12 mb-12">
          {/* Navigation Arrows */}
          <button
            onClick={prevSlide}
            className="absolute left-0 top-1/2 -translate-y-1/2 z-10 p-3 rounded-sm bg-white border-2 border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white transition-colors shadow-lg"
            aria-label="Previous equipment"
          >
            <ChevronLeft className="w-6 h-6" />
          </button>
          <button
            onClick={nextSlide}
            className="absolute right-0 top-1/2 -translate-y-1/2 z-10 p-3 rounded-sm bg-white border-2 border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white transition-colors shadow-lg"
            aria-label="Next equipment"
          >
            <ChevronRight className="w-6 h-6" />
          </button>

          {/* Slider Container */}
          <div className="overflow-hidden">
            <div 
              className="flex transition-transform duration-500 ease-out"
              style={{ transform: `translateX(-${currentSlide * 100}%)` }}
            >
              {Array.from({ length: maxSlides }).map((_, slideIndex) => (
                <div key={slideIndex} className="w-full flex-shrink-0">
                  <div className="grid grid-cols-1 gap-6">
                    {equipment
                      .slice(slideIndex * itemsPerSlide, (slideIndex + 1) * itemsPerSlide)
                      .map((item, idx) => {
                        const absoluteIndex = slideIndex * itemsPerSlide + idx;
                        return (
                          <div
                            key={idx}
                            className="group relative overflow-hidden rounded-sm border border-[#0B3570]/20 bg-white shadow-md transition-all hover:shadow-xl hover:border-[#F97C30] flex flex-col md:flex-row"
                          >
                            {/* Image/Number Section - Wide for Single Item */}
                            <div className="relative bg-gradient-to-br from-[#0B3570] to-[#1e5a9e] h-80 md:h-[400px] md:w-2/3 flex items-center justify-center">
                              <div className="text-9xl font-bold text-white/10">
                                {String(absoluteIndex + 1).padStart(2, '0')}
                              </div>
                            </div>

                            {/* Title Section */}
                            <div className="p-12 flex flex-col justify-center items-center text-center md:w-1/3">
                              <h3 className="text-heading text-2xl font-bold text-[#0B3570] capitalize mb-4">
                                {item.name}
                              </h3>
                              <p className="text-[#0B3570]/70">
                                Precision engineered for industrial excellence.
                              </p>
                            </div>

                            {/* Hover Accent */}
                            <div className="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] opacity-0 transition-opacity group-hover:opacity-100" />
                          </div>
                        );
                      })}
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
                className={`h-2 rounded-sm transition-all ${
                  currentSlide === idx
                    ? 'w-8 bg-[#F97C30]'
                    : 'w-2 bg-[#0B3570]/20 hover:bg-[#F97C30]/50'
                }`}
                aria-label={`Go to slide ${idx + 1}`}
              />
            ))}
          </div>
        </div>

        {/* CTA Section */}
        <div className="rounded-sm border border-[#0B3570]/20 bg-white p-8 text-center shadow-md">
          <h3 className="text-heading mb-3 text-2xl font-bold text-[#0B3570]">
            Tour Our Manufacturing Facility
          </h3>
          <p className="mx-auto mb-6 max-w-2xl text-base leading-relaxed text-[#0B3570]/70">
            See our production capabilities firsthand. Schedule a facility tour to understand how we maintain the highest quality standards.
          </p>
          <div className="flex flex-col justify-center gap-4 sm:flex-row">
            <Button className="bg-[#F97C30] font-semibold text-white hover:bg-[#e86d20] rounded-sm">
              Schedule Tour →
            </Button>
            <Button
              variant="outline"
              className="border-[#0B3570] bg-transparent font-semibold text-[#0B3570] hover:bg-[#0B3570]/5 rounded-sm"
            >
              Download Capabilities PDF
            </Button>
          </div>
        </div>

        {/* Certifications Badge */}
        <div className="mt-8 flex flex-wrap items-center justify-center gap-6 text-[#0B3570]/60">
          <div className="flex items-center gap-2">
            <div className="flex h-8 w-8 items-center justify-center rounded-sm border border-[#0B3570]/20 bg-white">
              <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
              </svg>
            </div>
            <span className="font-mono text-sm">ISO 9001:2015</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="flex h-8 w-8 items-center justify-center rounded-sm border border-[#0B3570]/20 bg-white">
              <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
              </svg>
            </div>
            <span className="font-mono text-sm">ASTM Certified</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="flex h-8 w-8 items-center justify-center rounded-sm border border-[#0B3570]/20 bg-white">
              <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5z"/>
              </svg>
            </div>
            <span className="font-mono text-sm">RoHS Compliant</span>
          </div>
        </div>
      </div>
    </section>
  );
}
