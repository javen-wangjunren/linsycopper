'use client';

import { Quote } from 'lucide-react';

const reviews = [
  {
    id: 1,
    content: 'We\'ve been sourcing C17200 beryllium copper from this supplier for our aerospace components for over 3 years. The material consistency is exceptional, with every shipment meeting ASTM B194 specifications.',
    author: 'David Morrison',
    position: 'Chief Procurement Officer',
    company: 'AeroTech Manufacturing',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
  },
  {
    id: 2,
    content: 'The 24-hour quote turnaround and consistent delivery schedule has made our production planning much more efficient. Their technical team helped us select the optimal naval brass grade for our marine hardware.',
    author: 'Jennifer Chen',
    position: 'Supply Chain Director',
    company: 'Maritime Solutions Inc',
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop&crop=face',
  },
  {
    id: 3,
    content: 'Working with their engineering team on our custom copper busbar project was impressive. They provided detailed electrical conductivity data and helped optimize our specifications for cost and performance.',
    author: 'Michael Zhang',
    position: 'Senior Electrical Engineer',
    company: 'PowerGrid Systems',
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
  },
  {
    id: 4,
    content: 'Their extensive stock of standard grades means we can get materials quickly for urgent projects. The packaging quality ensures materials arrive in perfect condition. True B2B efficiency.',
    author: 'Robert Williams',
    position: 'Operations Manager',
    company: 'Industrial Fabrication Co',
    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
  }
];

export default function Review() {
  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-12 text-center">
          <div className="mb-3 inline-block rounded bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
            Testimonials
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Trusted by Industry Leaders
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Real feedback from procurement and engineering professionals across industries
          </p>
        </div>

        {/* Two Column Grid */}
        <div className="grid gap-6 lg:grid-cols-2">
          {reviews.map((review) => (
            <div
              key={review.id}
              className="group relative flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-lg"
            >
              {/* Quote Icon */}
              <Quote className="mb-4 h-8 w-8 text-[#0B3570]/10 group-hover:text-[#F97C30]/20 transition-colors" />

              {/* Quote Content */}
              <blockquote className="flex-1 text-base leading-relaxed text-[#1F2937] mb-6">
                &quot;{review.content}&quot;
              </blockquote>

              {/* Author Info */}
              <div className="flex items-center gap-4 border-t border-[#E5E7EB] pt-6">
                <img
                  src={review.avatar}
                  alt={review.author}
                  className="h-12 w-12 shrink-0 rounded-full object-cover"
                />
                <div className="flex-1">
                  <div className="font-semibold text-[#1F2937]">{review.author}</div>
                  <div className="text-sm text-[#6B7280]">{review.position}</div>
                  <div className="font-mono text-xs text-[#9CA3AF] uppercase tracking-wider">{review.company}</div>
                </div>
              </div>

              {/* Bottom Accent Bar */}
              <div className="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full" />
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
