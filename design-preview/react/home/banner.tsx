'use client';

import Link from 'next/link';
import { ArrowRight, CheckCircle2 } from 'lucide-react';

const TRUST_STATS = [
  { value: '1,000+', label: 'Tons Ready Stock' },
  { value: 'ISO 9001', label: 'Certified Quality' },
  { value: '25+ Years', label: 'Industry Experience' },
  { value: '48-Hr', label: 'Quote Turnaround' },
];

const CERTIFICATIONS = ['ASTM B152', 'RoHS Compliant', 'Full MTR Docs'];

export default function Banner() {
  return (
    <section className="relative min-h-[88vh] flex items-center overflow-hidden bg-[#0B3570]">
      {/* Background photo */}
      <img
        src="https://images.unsplash.com/photo-1565793979013-6b1ed28a3b43?auto=format&fit=crop&q=80&w=2000"
        alt="Copper inventory warehouse"
        className="absolute inset-0 w-full h-full object-cover"
      />

      {/* Multi-layer overlay: strong navy from left, lighter toward right */}
      <div className="absolute inset-0 bg-[#0B3570]/80" />
      <div className="absolute inset-0 bg-gradient-to-r from-[#0B3570]/95 via-[#0B3570]/70 to-[#0B3570]/30" />

      {/* Subtle diagonal rule — industrial texture detail */}
      <div
        className="absolute inset-0 opacity-[0.04] pointer-events-none"
        style={{
          backgroundImage:
            'repeating-linear-gradient(135deg, #fff 0px, #fff 1px, transparent 1px, transparent 40px)',
        }}
      />

      {/* Content */}
      <div className="relative z-10 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-24 md:py-32">
        <div className="max-w-3xl">

          {/* Certifications row */}
          <div className="flex flex-wrap items-center gap-4 mb-8">
            {CERTIFICATIONS.map((cert) => (
              <span
                key={cert}
                className="flex items-center gap-1.5 font-mono text-[15px] font-semibold text-[#F4BD5D]"
              >
                <CheckCircle2 className="w-3.5 h-3.5 shrink-0" />
                {cert}
              </span>
            ))}
          </div>

          {/* Headline */}
          <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-[1.05] tracking-tight text-balance mb-6">
            Premium Copper
            <br />
            <span className="text-[#F97C30]">&amp; Bronze Alloys</span>
          </h1>

          {/* Sub-copy */}
          <p className="text-lg md:text-xl text-white/75 leading-relaxed max-w-xl mb-10">
            Largest inventory of C11000, C10100, and Naval Brass in the region. Cut to size, precision machined, and shipped globally.
          </p>

          {/* CTAs */}
          <div className="flex flex-wrap gap-4 mb-16">
            <Link
              href="/shapes"
              className="inline-flex items-center gap-2 bg-[#F97C30] hover:bg-[#e36a20] text-white font-semibold px-8 py-3.5 rounded-sm transition-all hover:-translate-y-0.5 shadow-lg"
            >
              Browse Products
              <ArrowRight className="w-4 h-4" />
            </Link>
            <Link
              href="/contact"
              className="inline-flex items-center gap-2 border border-white/40 hover:border-[#F4BD5D] text-white hover:text-[#F4BD5D] font-semibold px-8 py-3.5 rounded-sm transition-all"
            >
              Request a Quote
            </Link>
          </div>

          {/* Stats bar */}
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-6 border-t border-white/15 pt-8">
            {TRUST_STATS.map((stat) => (
              <div key={stat.value}>
                <div className="font-mono text-2xl font-bold text-[#F4BD5D] mb-0.5">
                  {stat.value}
                </div>
                <div className="text-[15px] font-semibold text-white/50">
                  {stat.label}
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
