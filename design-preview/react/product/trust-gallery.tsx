'use client';

import Link from 'next/link';

export default function TrustGallery() {
  return (
    <section id="manufacturing" className="py-24 bg-muted/30">
      <div className="mx-auto max-w-7xl px-4">
        {/* Section Header */}
        <div className="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div className="max-w-2xl">
            <h2 className="text-foreground text-3xl md:text-4xl font-bold mb-4">
              Quality & Manufacturing
            </h2>
            <p className="text-muted-foreground text-sm leading-relaxed max-w-xl">
              From lab-grade compliance verification to high-precision machining, we ensure every product meets ASTM standards with superior physical properties.
            </p>
          </div>

          {/* Desktop CTA */}
          <div className="hidden md:block">
            <Link
              href="/about"
              className="inline-flex items-center justify-center px-6 py-3 border border-[#0B3570] text-[#0B3570] text-xs font-bold tracking-widest hover:bg-[#0B3570] hover:text-white transition-all duration-300 rounded-sm group"
            >
              WHY CHOOSE US
              <svg
                className="w-3 h-3 ml-2 group-hover:translate-x-1 transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </Link>
          </div>
        </div>

        {/* Bento Grid Layout */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 auto-rows-[minmax(200px,auto)]">
          {/* Card 01: ISO Cert (Left Column - Vertical, spans 4 cols, 2 rows) */}
          <div className="lg:col-span-4 lg:row-span-2 group relative bg-muted border border-border hover:border-[#F97C30] transition-all duration-300 flex flex-col rounded-sm hover:shadow-xl overflow-hidden">
            {/* Vertical Image Area */}
            <div className="h-[400px] lg:h-full bg-[#F8FAFC] relative border-b lg:border-b-0 lg:border-r border-border overflow-hidden p-8 flex items-center justify-center">
              <div className="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10" />
              {/* Certificate mockup */}
              <div className="relative w-full max-w-[240px] aspect-[3/4] bg-white shadow-lg group-hover:scale-105 transition-transform duration-700 p-2">
                <div className="w-full h-full bg-[#F1F5F9] flex items-center justify-center text-[#0B3570]/40 text-sm font-mono">
                  ISO Certificate
                </div>
              </div>
              {/* Index */}
              <div className="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">
                01
              </div>
            </div>

            {/* Content Overlay */}
            <div className="absolute bottom-0 left-0 right-0 bg-muted/95 backdrop-blur-sm p-6 border-t border-border">
              <h3 className="text-foreground text-lg font-bold mb-2 group-hover:text-[#0B3570] transition-colors">
                Quality Compliance
              </h3>
              <p className="text-xs text-muted-foreground leading-relaxed line-clamp-3">
                Full ASTM/ISO certification support. Every batch of sheet comes with complete MTR (Mill Test Report), ensuring 100% transparency and traceability.
              </p>
            </div>
          </div>

          {/* Card 02: Precision Machining (Right Top - Horizontal, spans 8 cols) */}
          <div className="lg:col-span-8 group relative bg-muted border border-border hover:border-[#F97C30] transition-all duration-300 flex flex-col md:flex-row rounded-sm hover:shadow-xl overflow-hidden min-h-[280px]">
            {/* Image Left */}
            <div className="md:w-1/2 bg-[#F8FAFC] relative overflow-hidden border-b md:border-b-0 md:border-r border-border">
              <div className="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10" />
              <div className="w-full h-full min-h-[200px] flex items-center justify-center text-[#0B3570]/30 text-sm font-mono group-hover:scale-105 transition-transform duration-700">
                CNC Machining
              </div>
              <div className="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">
                02
              </div>
            </div>
            {/* Content */}
            <div className="p-8 md:w-1/2 flex flex-col justify-center">
              <h3 className="text-foreground text-lg font-bold mb-3 group-hover:text-[#0B3570] transition-colors">
                Precision Machining
              </h3>
              <p className="text-sm text-muted-foreground leading-relaxed">
                Equipped with automated slitting lines for copper coils and sheets. Burr-free edges with flatness deviation controlled to industry-leading levels (±0.001" Tolerance).
              </p>
            </div>
          </div>

          {/* Card 03: Global Logistics (Right Bottom - Horizontal, spans 8 cols) */}
          <div className="lg:col-span-8 group relative bg-muted border border-border hover:border-[#F97C30] transition-all duration-300 flex flex-col md:flex-row rounded-sm hover:shadow-xl overflow-hidden min-h-[280px]">
            {/* Image Left */}
            <div className="md:w-1/2 bg-[#F8FAFC] relative overflow-hidden border-b md:border-b-0 md:border-r border-border">
              <div className="absolute inset-0 bg-gradient-to-br from-[#0B3570]/5 to-[#0B3570]/10" />
              <div className="w-full h-full min-h-[200px] flex items-center justify-center text-[#0B3570]/30 text-sm font-mono group-hover:scale-105 transition-transform duration-700">
                Global Logistics
              </div>
              <div className="absolute top-4 left-4 font-mono text-4xl font-bold text-[#0B3570]/10 select-none">
                03
              </div>
            </div>
            {/* Content */}
            <div className="p-8 md:w-1/2 flex flex-col justify-center">
              <h3 className="text-foreground text-lg font-bold mb-3 group-hover:text-[#0B3570] transition-colors">
                Global Logistics
              </h3>
              <p className="text-sm text-muted-foreground leading-relaxed">
                ISPM-15 fumigated wooden crates with moisture-proof vacuum packaging and scratch-resistant liner paper, ensuring product integrity during overseas transport.
              </p>
            </div>
          </div>
        </div>

        {/* Mobile CTA */}
        <div className="mt-12 text-center md:hidden">
          <Link
            href="/about"
            className="inline-flex items-center justify-center px-8 py-4 bg-[#0B3570] text-white text-xs font-bold tracking-widest hover:bg-[#0B3570]/90 transition-all rounded-sm w-full"
          >
            WHY CHOOSE US
          </Link>
        </div>
      </div>
    </section>
  );
}
