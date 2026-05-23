import { ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import Link from 'next/link';

const grades = [
  {
    code: 'C11000',
    name: 'Electrolytic Tough Pitch',
    stock: 'In Stock',
    equivalents: [
      { standard: 'EN', code: 'Cu-ETP' },
      { standard: 'JIS', code: 'C1100' },
      { standard: 'ASTM', code: 'C11000' },
    ],
  },
  {
    code: 'C17200',
    name: 'Beryllium Copper',
    stock: 'Ready to Ship',
    equivalents: [
      { standard: 'EN', code: 'CuBe2' },
      { standard: 'JIS', code: 'C1720' },
      { standard: 'DIN', code: '2.1247' },
    ],
  },
  {
    code: 'C26000',
    name: 'Cartridge Brass',
    stock: 'In Stock',
    equivalents: [
      { standard: 'EN', code: 'CuZn30' },
      { standard: 'JIS', code: 'C2600' },
      { standard: 'ISO', code: 'CuZn30' },
    ],
  },
  {
    code: 'C12200',
    name: 'Phosphorus Deoxidized',
    stock: 'Ready to Ship',
    equivalents: [
      { standard: 'EN', code: 'Cu-DHP' },
      { standard: 'JIS', code: 'C1220' },
      { standard: 'ASTM', code: 'C12200' },
    ],
  },
  {
    code: 'C10100',
    name: 'Oxygen-Free Copper',
    stock: 'In Stock',
    equivalents: [
      { standard: 'EN', code: 'Cu-OFE' },
      { standard: 'JIS', code: 'C1011' },
      { standard: 'ASTM', code: 'C10100' },
    ],
  },
  {
    code: 'C46400',
    name: 'Naval Brass',
    stock: 'In Stock',
    equivalents: [
      { standard: 'EN', code: 'CuZn38Sn1' },
      { standard: 'JIS', code: 'C4640' },
      { standard: 'ASTM', code: 'C46400' },
    ],
  },
];

export default function BestSellingGrade() {
  return (
    <section className="bg-white pt-[100px] pb-24">
      <div className="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="mb-12 flex flex-col items-center justify-between gap-4 md:flex-row">
          <div>
            <div className="mb-2 inline-block rounded-sm bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
              Popular Materials
            </div>
            <h2 className="text-heading text-balance text-3xl font-bold tracking-tight md:text-4xl">
              Best-Selling Copper Grades
            </h2>
            <p className="mt-2 text-pretty text-[#6B7280]">
              Fast shipping on our most requested alloys
            </p>
          </div>
          <Button
            variant="outline"
            className="group rounded-sm border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white bg-transparent"
          >
            View All Grades
            <ArrowRight className="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
          </Button>
        </div>

        {/* Grades Grid */}
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {grades.map((grade) => (
            <Link
              key={grade.code}
              href={`/product/${grade.code.toLowerCase()}`}
              className="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg block"
            >
              {/* Stock Badge */}
              <div className="absolute right-4 top-4 rounded-sm bg-[#10B981] px-2 py-1 font-mono text-[10px] font-bold text-white uppercase">
                {grade.stock}
              </div>

              <div className="p-6">
                {/* Grade Code */}
                <div className="mb-6">
                  <div className="mb-1 font-mono text-3xl font-bold text-[#0B3570]">
                    {grade.code}
                  </div>
                  <div className="text-sm font-medium text-[#6B7280]">
                    {grade.name}
                  </div>
                </div>

                {/* International Equivalents */}
                <div className="mb-6 space-y-3">
                  <div className="mb-3 font-mono text-[11px] font-bold uppercase tracking-wider text-[#9CA3AF] flex items-center gap-2">
                    <span className="flex-none">International Equivalents</span>
                    <div className="h-px flex-1 bg-[#E5E7EB]"></div>
                  </div>
                  
                  <div className="space-y-2">
                    {grade.equivalents.map((equiv) => (
                      <div key={equiv.standard} className="flex items-center justify-between text-sm">
                        <span className="font-mono font-bold text-[#6B7280] bg-[#F3F4F6] px-1.5 py-0.5 rounded-sm text-[10px] min-w-[40px] text-center">
                          {equiv.standard}
                        </span>
                        <div className="mx-3 flex-1 border-b border-dashed border-[#E5E7EB]"></div>
                        <span className="font-mono font-bold text-[#1F2937]">
                          {equiv.code}
                        </span>
                      </div>
                    ))}
                  </div>
                </div>

                {/* View More CTA */}
                <div className="pt-4 border-t border-[#F3F4F6]">
                  <Button
                    className="w-full rounded-sm bg-[#F2F4F7] text-[#0B3570] font-bold text-sm transition-colors hover:bg-[#0B3570] hover:text-white group-hover:bg-[#0B3570] group-hover:text-white"
                  >
                    View Technical Specs
                    <ArrowRight className="ml-2 h-4 w-4" />
                  </Button>
                </div>
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
