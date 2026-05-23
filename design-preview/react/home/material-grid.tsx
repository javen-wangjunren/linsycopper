'use client';

import Image from 'next/image';
import { ArrowRight } from 'lucide-react';
import Link from 'next/link';

const MATERIALS = [
  {
    id: 'copper',
    title: 'Pure Copper',
    slug: 'pure-copper',
    image: 'https://images.unsplash.com/photo-1605557202138-097824c360c4?auto=format&fit=crop&q=80&w=800',
  },
  {
    id: 'brass',
    title: 'Brass Alloys',
    slug: 'brass-alloys',
    image: 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&q=80&w=800',
  },
  {
    id: 'bronze',
    title: 'Bronze Alloys',
    slug: 'bronze-alloys',
    image: 'https://images.unsplash.com/photo-1615465692683-0498b824a733?auto=format&fit=crop&q=80&w=800',
  },
];

export default function MaterialGrid() {
  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-12 text-center">
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Browse by Material Type
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Premium grades available in bar, sheet, plate, and tube.
          </p>
        </div>

        {/* Material Cards Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {MATERIALS.map((item) => (
            <Link
              key={item.id}
              href={`/materials/${item.slug}`}
              className="group relative overflow-hidden rounded border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg"
            >
              {/* Material Image */}
              <div className="relative h-56 w-full overflow-hidden bg-[#F2F4F7]">
                <img
                  src={item.image}
                  alt={item.title}
                  className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                />
              </div>

              {/* Material Info */}
              <div className="p-6">
                <h3 className="text-lg font-bold text-[#0B3570] mb-4">
                  {item.title}
                </h3>

                {/* CTA Button */}
                <button className="w-full bg-[#F2F4F7] text-[#0B3570] font-semibold py-2 px-4 rounded-sm transition-colors hover:bg-[#0B3570] hover:text-white group-hover:bg-[#0B3570] group-hover:text-white flex items-center justify-center gap-2">
                  View Details
                  <ArrowRight size={16} />
                </button>
              </div>

              {/* Bottom Accent Bar */}
              <div className="h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full" />
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
