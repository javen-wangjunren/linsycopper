'use client';

import { useState } from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { Button } from '@/components/ui/button';

const industries = [
  {
    title: 'Aerospace & Defense',
    description: 'High-performance alloys for critical aerospace components and defense applications',
    image: '/images/aerospace.jpg',
    specs: ['C11000 (ETP)', 'C36000 (Free Cutting)', 'Phosphor Bronze'],
  },
  {
    title: 'Electrical & Electronics',
    description: 'Superior conductivity copper for electrical components and electronic systems',
    image: '/images/electrical.jpg',
    specs: ['C10100 (OFE)', 'C11000 (ETP)', 'Beryllium Copper'],
  },
  {
    title: 'Marine & Naval',
    description: 'Corrosion-resistant alloys engineered for harsh marine environments',
    image: '/images/marine.jpg',
    specs: ['Naval Brass C46400', 'Aluminum Bronze', 'Silicon Bronze'],
  },
  {
    title: 'Industrial Manufacturing',
    description: 'Versatile copper materials for machinery, tooling, and industrial equipment',
    image: '/images/industrial.jpg',
    specs: ['C36000 (Brass)', 'Phosphor Bronze', 'Beryllium Copper'],
  },
  {
    title: 'Architectural & Construction',
    description: 'Durable copper products for architectural elements and building systems',
    image: '/images/architecture.jpg',
    specs: ['C11000 (ETP)', 'Architectural Bronze', 'Weathering Bronze'],
  },
];

export default function IndustrySlider() {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [selectedSpec, setSelectedSpec] = useState<string | null>(null);

  const nextSlide = () => {
    setCurrentIndex((prev: number) => (prev + 1) % industries.length);
  };

  const prevSlide = () => {
    setCurrentIndex((prev: number) => (prev - 1 + industries.length) % industries.length);
  };

  const goToSlide = (index: number) => {
    setCurrentIndex(index);
  };

  return (
    <section className="bg-[#F2F4F7] pt-[100px] pb-[100px]">
      <div className="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="mb-12 text-center">
          <p className="mb-2 font-mono text-xs font-semibold text-[#F97C30]">
            Industries We Serve
          </p>
          <h2 className="text-heading text-3xl font-semibold tracking-tight text-[#111827] md:text-4xl">
            Trusted Across Critical Industries
          </h2>
        </div>

        {/* Slider */}
        <div className="relative">
          {/* Main Slide */}
          <div className="relative overflow-hidden rounded-sm border border-black/10 bg-white shadow-[0_18px_45px_rgba(16,24,40,0.10)]">
            <div className="grid md:grid-cols-12">
              {/* Image Section */}
              <div className="relative md:col-span-7">
                <div className="relative aspect-[4/3] w-full bg-[#0B3570] md:aspect-auto md:h-full md:min-h-[420px]">
                  {industries[currentIndex].image ? (
                    <img
                      src={industries[currentIndex].image}
                      alt={industries[currentIndex].title}
                      className="absolute inset-0 h-full w-full object-cover"
                    />
                  ) : (
                    <div className="absolute inset-0 flex items-center justify-center">
                      <div className="text-center text-white/35">
                        <div className="text-6xl font-semibold">{currentIndex + 1}</div>
                        <div className="mt-2 font-mono text-xs tracking-[0.24em]">INDUSTRY PHOTO</div>
                      </div>
                    </div>
                  )}

                  <div className="absolute inset-0 bg-gradient-to-tr from-black/55 via-black/10 to-transparent" />
                  <div className="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                    <div className="flex items-center gap-3">
                      <span className="h-2 w-2 rounded-sm bg-[#F97C30]" />
                      <span className="font-mono text-[11px] font-semibold tracking-[0.24em] text-white/70">
                        MATERIAL SELECTION
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              {/* Content Section */}
              <div className="flex flex-col justify-center p-7 md:col-span-5 md:p-10 lg:p-12">
                <h3 className="text-heading mb-3 text-2xl font-semibold tracking-tight text-[#111827] md:text-3xl">
                  {industries[currentIndex].title}
                </h3>
                <p className="mb-6 text-[15px] leading-relaxed text-[#4B5563]">
                  {industries[currentIndex].description}
                </p>

                {/* Material Specs */}
                <div className="mb-8">
                  <div className="mb-3 font-mono text-[11px] font-semibold tracking-[0.24em] text-[#6B7280]">
                    Common Materials
                  </div>
                  <div className="flex flex-wrap gap-2.5">
                    {industries[currentIndex].specs.map((spec, idx) => (
                      <button
                        key={idx}
                        type="button"
                        onClick={() => setSelectedSpec((prev) => (prev === spec ? null : spec))}
                        className={[
                          'rounded-sm border px-3 py-1.5 font-mono text-xs transition-colors',
                          selectedSpec === spec
                            ? 'border-[#F97C30] bg-[#F97C30]/10 text-[#111827]'
                            : 'border-[#E5E7EB] bg-white text-[#111827] hover:border-[#F97C30]/60',
                        ].join(' ')}
                      >
                        {spec}
                      </button>
                    ))}
                  </div>
                </div>

                {/* CTA */}
                <div>
                  <Button className="rounded-sm bg-[#F97C30] px-5 font-semibold text-white hover:bg-[#e86d20]">
                    View Solutions →
                  </Button>
                </div>
              </div>
            </div>
          </div>

          {/* Navigation Arrows */}
          <button
            onClick={prevSlide}
            className="absolute left-3 top-1/2 -translate-y-1/2 rounded-sm border border-black/10 bg-white p-2 shadow-md transition-all hover:bg-[#F2F4F7] focus:outline-none focus:ring-2 focus:ring-[#F97C30]/60 md:-left-5"
            aria-label="Previous slide"
          >
            <ChevronLeft className="h-5 w-5 text-[#0B3570]" />
          </button>
          <button
            onClick={nextSlide}
            className="absolute right-3 top-1/2 -translate-y-1/2 rounded-sm border border-black/10 bg-white p-2 shadow-md transition-all hover:bg-[#F2F4F7] focus:outline-none focus:ring-2 focus:ring-[#F97C30]/60 md:-right-5"
            aria-label="Next slide"
          >
            <ChevronRight className="h-5 w-5 text-[#0B3570]" />
          </button>

          {/* Dots Navigation */}
          <div className="mt-8 flex justify-center gap-2">
            {industries.map((_, index) => (
              <button
                key={index}
                onClick={() => goToSlide(index)}
                className={[
                  'h-2 rounded-sm transition-all',
                  index === currentIndex ? 'w-10 bg-[#F97C30]' : 'w-2 bg-[#D1D5DB] hover:bg-[#9CA3AF]',
                ].join(' ')}
                aria-label={`Go to slide ${index + 1}`}
              />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
