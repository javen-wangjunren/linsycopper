'use client';

import { useState, useMemo } from 'react';
import Link from 'next/link';
import { Home, Search, ChevronLeft, ChevronRight, Menu, X, Phone, Upload } from 'lucide-react';

// Data definitions
const shapeCategories = [
  { name: 'Sheet & Plate', slug: 'copper-sheet', active: true },
  { name: 'Round Bar', slug: 'round-bar', active: false },
  { name: 'Tube & Pipe', slug: 'tube-pipe', active: false },
  { name: 'Wire', slug: 'wire', active: false },
  { name: 'Coil & Strip', slug: 'coil-strip', active: false },
];

const materialCategories = [
  { name: 'Pure Copper', slug: 'pure-copper' },
  { name: 'Brass', slug: 'brass' },
  { name: 'Bronze', slug: 'bronze' },
];

const categoryGrades = [
  { name: 'Brass (C20000-C49900)', url: '/grades?category=brass' },
  { name: 'Bronze (C50000-C79900)', url: '/grades?category=bronze' },
  { name: 'Pure Copper (C10000-C15000)', url: '/grades?category=copper' },
];

const detailGrades = [
  { name: 'C11000 ETP Copper', url: '/product/c11000' },
  { name: 'C10100 Oxygen Free', url: '/product/c10100' },
  { name: 'C10200 OF Copper', url: '/product/c10200' },
  { name: 'C26000 Cartridge Brass', url: '/product/c26000' },
  { name: 'C36000 Free Cutting Brass', url: '/product/c36000' },
  { name: 'C51000 Phosphor Bronze', url: '/product/c51000' },
  { name: 'C93200 Bearing Bronze', url: '/product/c93200' },
  { name: 'C17200 Beryllium Copper', url: '/product/c17200' },
  { name: 'C46400 Naval Brass', url: '/product/c46400' },
];

const products = [
  {
    id: 1,
    name: 'Pure Copper Sheet',
    grade: 'C11000',
    image: 'https://images.unsplash.com/photo-1558444479-c8a510525bd8?w=400&h=400&fit=crop',
    category: 'material',
  },
  {
    id: 2,
    name: 'Cartridge Brass Sheet',
    grade: 'C26000',
    image: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=400&fit=crop',
    category: 'material',
  },
  {
    id: 3,
    name: 'Bronze Plate',
    grade: 'C51000',
    image: 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=400&fit=crop',
    category: 'material',
  },
  {
    id: 4,
    name: 'Beryllium Copper Sheet',
    grade: 'C17200',
    image: 'https://images.unsplash.com/photo-1558444479-c8a510525bd8?w=400&h=400&fit=crop',
    category: 'material',
  },
  {
    id: 5,
    name: 'Naval Brass Sheet',
    grade: 'C46400',
    image: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=400&fit=crop',
    category: 'material',
  },
  {
    id: 6,
    name: 'Phosphor Bronze Plate',
    grade: 'C52100',
    image: 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=400&fit=crop',
    category: 'material',
  },
];

export default function CopperSheetPage() {
  const [drawerOpen, setDrawerOpen] = useState(false);
  const [activeTab, setActiveTab] = useState<'material' | 'feature'>('material');
  const [gradeSearchTerm, setGradeSearchTerm] = useState('');
  const [currentPage, setCurrentPage] = useState(1);

  // Grade search filtering logic
  const filteredGrades = useMemo(() => {
    if (!gradeSearchTerm.trim()) {
      return { type: 'categories', items: categoryGrades };
    }
    
    const term = gradeSearchTerm.toUpperCase();
    const matches = detailGrades.filter(g => 
      g.name.toUpperCase().includes(term)
    );
    
    return { type: 'details', items: matches };
  }, [gradeSearchTerm]);

  // Highlight matching text
  const highlightMatch = (text: string, term: string) => {
    if (!term.trim()) return text;
    const regex = new RegExp(`(${term})`, 'gi');
    const parts = text.split(regex);
    return parts.map((part, i) => 
      regex.test(part) ? (
        <span key={i} className="font-bold text-[#F97C30]">{part}</span>
      ) : (
        <span key={i}>{part}</span>
      )
    );
  };

  return (
    <main className="bg-white">
      {/* Hero Section */}
      <section className="overflow-hidden bg-[#0B3570]">
        <div className="mx-auto flex max-w-[1440px] flex-col items-stretch md:flex-row">
          <div className="z-10 flex flex-col justify-center p-8 text-left md:w-1/2 md:py-16 lg:px-24 lg:py-20">
            <nav className="mb-6 font-mono text-[10px] uppercase tracking-widest text-white/60">
              <Link href="/" className="text-white transition hover:text-[#F4BD5D]">Home</Link>
              {' / '}
              <Link href="/shapes" className="text-white transition hover:text-[#F4BD5D]">Catalog</Link>
              {' / '}
              <span className="text-white">Copper Sheet & Plate</span>
            </nav>
            <h1 className="mb-6 text-4xl font-bold uppercase leading-tight tracking-tight text-white md:text-5xl lg:text-6xl">
              Copper <span className="text-[#F4BD5D]">Sheet & Plate</span>
            </h1>
            <p className="mb-8 max-w-xl text-lg leading-relaxed text-blue-100/80">
              Leading copper alloy manufacturer providing high-quality sheet and plate products that meet ASTM/ISO standards. We maintain full-size inventory of pure copper, brass, and bronze alloys with precision cutting services.
            </p>
            <div>
              <Link
                href="#contact-form"
                className="inline-block transform bg-[#F97C30] px-8 py-4 font-mono text-[11px] font-bold uppercase tracking-widest text-white shadow-lg transition hover:-translate-y-1 hover:bg-orange-600"
              >
                Request a Quote
              </Link>
            </div>
          </div>
          <div className="relative min-h-[350px] w-full md:w-1/2">
            <img
              src="https://images.unsplash.com/photo-1558444479-c8a510525bd8?auto=format&fit=crop&q=80&w=1200"
              alt="Copper Sheet Inventory"
              className="h-full w-full object-cover"
            />
            <div className="absolute inset-0 hidden bg-gradient-to-r from-[#0B3570] via-transparent to-transparent md:block" />
          </div>
        </div>
      </section>

      {/* Mobile Filter Toggle */}
      <div className="sticky top-0 z-40 flex items-center justify-between border-b border-gray-100 bg-white px-6 py-4 lg:hidden">
        <span className="font-mono text-xs font-bold uppercase tracking-widest text-[#0B3570]">Filter Catalog</span>
        <button
          onClick={() => setDrawerOpen(true)}
          className="rounded bg-[#0B3570] p-2 text-white"
        >
          <Menu className="h-5 w-5" />
        </button>
      </div>

      {/* Main Content Area */}
      <div className="relative mx-auto flex max-w-[1440px] flex-col gap-12 px-6 py-12 lg:flex-row">
        {/* Mobile Drawer Overlay */}
        {drawerOpen && (
          <div
            className="fixed inset-0 z-50 bg-[#0B3570]/60 lg:hidden"
            onClick={() => setDrawerOpen(false)}
          />
        )}

        {/* Sidebar */}
        <aside
          className={`fixed inset-y-0 left-0 z-50 w-72 -translate-x-full overflow-y-auto bg-white p-8 transition-transform lg:static lg:z-auto lg:w-72 lg:flex-shrink-0 lg:translate-x-0 lg:p-0 ${
            drawerOpen ? 'translate-x-0' : ''
          }`}
        >
          {/* Mobile Close Button */}
          <div className="mb-8 flex items-center justify-between lg:hidden">
            <span className="text-sm font-bold uppercase text-[#0B3570]">Filters</span>
            <button
              onClick={() => setDrawerOpen(false)}
              className="font-mono text-gray-400"
            >
              CLOSE <X className="inline h-4 w-4" />
            </button>
          </div>

          <div className="space-y-10">
            {/* Shapes Filter */}
            <div>
              <Link
                href="/shapes"
                className="mb-4 block border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-[0.2em] text-[#0B3570] transition hover:text-[#F97C30]"
              >
                Copper Shapes
              </Link>
              <nav className="flex flex-col border-l border-gray-100">
                {shapeCategories.map((shape) => (
                  <Link
                    key={shape.slug}
                    href={`/shapes/${shape.slug}`}
                    className={`px-4 py-2 text-sm transition hover:bg-gray-50 ${
                      shape.active
                        ? 'border-l-2 border-[#F97C30] bg-slate-50 font-bold text-[#0B3570]'
                        : 'text-gray-500'
                    }`}
                  >
                    {shape.name}
                  </Link>
                ))}
              </nav>
            </div>

            {/* Materials Filter */}
            <div>
              <Link
                href="/materials"
                className="mb-4 block border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-[0.2em] text-[#0B3570] transition hover:text-[#F97C30]"
              >
                Copper Material
              </Link>
              <nav className="flex flex-col border-l border-gray-100">
                {materialCategories.map((material) => (
                  <Link
                    key={material.slug}
                    href={`/materials/${material.slug}`}
                    className="px-4 py-2 text-sm text-gray-500 transition hover:bg-gray-50"
                  >
                    {material.name}
                  </Link>
                ))}
              </nav>
            </div>

            {/* Grade Search Filter */}
            <div>
              <div className="mb-4 flex items-center justify-between border-b border-gray-100 pb-2">
                <Link
                  href="/grades"
                  className="text-xs font-bold uppercase tracking-[0.2em] text-[#0B3570] transition hover:text-[#F97C30]"
                >
                  Copper Grade
                </Link>
                <Search className="h-3 w-3 text-gray-400" />
              </div>
              <div className="mb-4">
                <input
                  type="text"
                  value={gradeSearchTerm}
                  onChange={(e) => setGradeSearchTerm(e.target.value)}
                  placeholder="Type C110 to search..."
                  className="w-full border border-gray-200 bg-[#F2F4F7] px-3 py-2 font-mono text-[11px] outline-none transition-colors placeholder:text-gray-400 focus:border-[#F97C30]"
                />
              </div>
              <nav className="flex flex-col border-l border-gray-100 font-mono text-[11px]">
                {filteredGrades.type === 'categories' ? (
                  filteredGrades.items.map((item) => (
                    <Link
                      key={item.name}
                      href={item.url}
                      className="border-l border-transparent px-4 py-2 text-gray-500 transition hover:bg-gray-50 hover:text-[#0B3570]"
                    >
                      {item.name}
                    </Link>
                  ))
                ) : filteredGrades.items.length > 0 ? (
                  filteredGrades.items.map((item) => (
                    <Link
                      key={item.name}
                      href={item.url}
                      className="border-l border-transparent px-4 py-2 text-gray-500 transition hover:bg-gray-50 hover:text-[#0B3570]"
                    >
                      {highlightMatch(item.name, gradeSearchTerm)}
                    </Link>
                  ))
                ) : (
                  <div className="px-4 py-4 text-center text-gray-400">
                    <p className="mb-2">No match found</p>
                    <a
                      href="#contact-form"
                      className="text-[#F97C30] underline transition hover:text-[#0B3570]"
                    >
                      Consult our experts
                    </a>
                  </div>
                )}
              </nav>
            </div>
          </div>
        </aside>

        {/* Product Grid Area */}
        <div className="flex-1">
          {/* Tabs */}
          <div className="mb-8 flex space-x-8 overflow-x-auto border-b border-gray-200">
            <button
              onClick={() => setActiveTab('material')}
              className={`whitespace-nowrap pb-3 text-sm uppercase tracking-widest transition ${
                activeTab === 'material'
                  ? 'border-b-2 border-[#0B3570] font-bold text-[#0B3570]'
                  : 'text-gray-400 hover:text-[#0B3570]'
              }`}
            >
              By Material
            </button>
            <button
              onClick={() => setActiveTab('feature')}
              className={`whitespace-nowrap pb-3 text-sm uppercase tracking-widest transition ${
                activeTab === 'feature'
                  ? 'border-b-2 border-[#0B3570] font-bold text-[#0B3570]'
                  : 'text-gray-400 hover:text-[#0B3570]'
              }`}
            >
              By Feature & Application
            </button>
          </div>

          {/* Product Grid */}
          <div className="mb-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            {products.map((product) => (
              <div
                key={product.id}
                className="group overflow-hidden border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:border-[#F97C30] hover:shadow-2xl"
              >
                <div className="relative flex aspect-square items-center justify-center overflow-hidden bg-[#F2F4F7] p-8">
                  <img
                    src={product.image || "/placeholder.svg"}
                    alt={product.name}
                    className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                  />
                  <div className="absolute right-4 top-4 rounded bg-[#0B3570] px-2 py-1 font-mono text-[10px] font-bold text-white">
                    {product.grade}
                  </div>
                </div>
                <div className="p-6 text-center">
                  <h4 className="mb-6 text-lg font-bold uppercase leading-tight text-[#0B3570] transition-colors group-hover:text-[#F97C30]">
                    {product.name}
                  </h4>
                  <Link
                    href={`/product/${product.grade.toLowerCase()}`}
                    className="block w-full bg-[#0B3570] py-3 font-mono text-[10px] font-bold uppercase tracking-widest text-white transition hover:bg-[#F97C30]"
                  >
                    View Specifications
                  </Link>
                </div>
              </div>
            ))}
          </div>

          {/* Pagination */}
          <div className="flex items-center justify-center space-x-2 border-t border-gray-100 py-8 font-mono">
            <button
              onClick={() => setCurrentPage(Math.max(1, currentPage - 1))}
              className="p-2 text-[#0B3570] transition hover:text-[#F97C30]"
            >
              <ChevronLeft className="h-5 w-5" />
            </button>
            {[1, 2, 3].map((page) => (
              <button
                key={page}
                onClick={() => setCurrentPage(page)}
                className={`flex h-10 w-10 items-center justify-center text-sm transition ${
                  currentPage === page
                    ? 'bg-[#0B3570] text-white'
                    : 'text-[#0B3570] hover:bg-[#F2F4F7]'
                }`}
              >
                {page}
              </button>
            ))}
            <button
              onClick={() => setCurrentPage(Math.min(3, currentPage + 1))}
              className="p-2 text-[#0B3570] transition hover:text-[#F97C30]"
            >
              <ChevronRight className="h-5 w-5" />
            </button>
          </div>
        </div>
      </div>

      {/* Technical Guide Section */}
      <section className="border-t border-gray-200 bg-white py-16 md:py-24">
        <div className="mx-auto grid max-w-[1280px] grid-cols-1 items-center gap-16 px-6 lg:grid-cols-2">
          <div>
            <h2 className="mb-6 text-3xl font-bold uppercase text-[#0B3570]">
              Technical Guide: <span className="text-[#F97C30]">Copper Sheet Alloys</span>
            </h2>
            <p className="mb-6 leading-relaxed text-gray-600">
              At our facility, we maintain massive inventories of brass, bronze, and specialty copper alloys to ensure immediate availability for global industrial demands.
            </p>
            <h3 className="mb-4 text-xl font-bold text-[#0B3570]">Key Properties and Benefits</h3>
            <ul className="mb-8 space-y-4 text-gray-600">
              <li className="flex items-start">
                <span className="mr-2 text-[#F97C30]">&#9654;</span>
                <span><strong>Conductivity:</strong> 101% IACS conductivity, essential for electrical assemblies.</span>
              </li>
              <li className="flex items-start">
                <span className="mr-2 text-[#F97C30]">&#9654;</span>
                <span><strong>Precision:</strong> Grain structure optimization for advanced deep drawing.</span>
              </li>
              <li className="flex items-start">
                <span className="mr-2 text-[#F97C30]">&#9654;</span>
                <span><strong>Corrosion Resistance:</strong> Excellent performance in marine environments.</span>
              </li>
            </ul>

            <h3 className="mb-4 text-xl font-bold text-[#0B3570]">Applications</h3>
            <div className="grid grid-cols-2 gap-4">
              <div className="bg-[#F2F4F7] p-4 font-mono text-[11px] font-bold uppercase tracking-widest text-[#0B3570]">
                Electric & Electronics
              </div>
              <div className="bg-[#F2F4F7] p-4 font-mono text-[11px] font-bold uppercase tracking-widest text-[#0B3570]">
                Architecture & Decor
              </div>
              <div className="bg-[#F2F4F7] p-4 font-mono text-[11px] font-bold uppercase tracking-widest text-[#0B3570]">
                Marine Hardware
              </div>
              <div className="bg-[#F2F4F7] p-4 font-mono text-[11px] font-bold uppercase tracking-widest text-[#0B3570]">
                Industrial Equipment
              </div>
            </div>
          </div>
          <div className="relative h-[450px]">
            <img
              src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=1200"
              alt="Precision Copper Plate Measuring"
              className="h-full w-full object-cover"
            />
            <div className="absolute -bottom-4 -right-4 bg-[#0B3570] p-6 text-center text-white shadow-xl">
              <div className="font-mono text-2xl font-bold text-[#F4BD5D]">ASTM</div>
              <div className="text-[9px] font-bold uppercase tracking-widest text-blue-200">
                Standard Compliant
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Expert Consultation Section */}
      <section id="contact-form" className="relative overflow-hidden bg-[#0B3570]">
        <div className="absolute inset-0 z-0">
          <img
            src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&q=80&w=1600"
            alt="Industrial Background"
            className="h-full w-full object-cover opacity-30 grayscale"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-[#0B3570] via-[#0B3570]/80 to-transparent" />
        </div>

        <div className="relative z-10 mx-auto flex max-w-[1280px] flex-col items-center gap-16 px-6 py-20 lg:flex-row">
          {/* Left Content */}
          <div className="text-white lg:w-5/12">
            <h2 className="mb-6 text-4xl font-bold uppercase leading-none tracking-tight md:text-5xl">
              Consult <span className="text-[#F4BD5D]">Our Experts</span>
            </h2>
            <p className="mb-8 text-lg leading-relaxed text-blue-100/80">
              Give us a call at{' '}
              <a href="tel:3462305191" className="font-bold text-white underline transition hover:text-[#F97C30]">
                346.230.5191
              </a>{' '}
              or leave us a message below. Our material engineers are ready to assist with your specific project requirements.
            </p>

            <div className="grid grid-cols-2 gap-8 border-t border-white/10 pt-8">
              <div>
                <div className="font-mono text-xl font-bold text-[#F4BD5D]">1,000+ TONS</div>
                <div className="text-[9px] font-bold uppercase tracking-widest opacity-60">Ready Stock</div>
              </div>
              <div>
                <div className="font-mono text-xl font-bold text-[#F4BD5D]">ISO 9001</div>
                <div className="text-[9px] font-bold uppercase tracking-widest opacity-60">Certified Quality</div>
              </div>
              <div>
                <div className="font-mono text-xl font-bold text-[#F4BD5D]">25+ Years</div>
                <div className="text-[9px] font-bold uppercase tracking-widest opacity-60">Industry Experience</div>
              </div>
              <div>
                <div className="font-mono text-xl font-bold text-[#F4BD5D]">48-Hour</div>
                <div className="text-[9px] font-bold uppercase tracking-widest opacity-60">Quote Turnaround</div>
              </div>
            </div>
          </div>

          {/* Contact Form */}
          <div className="w-full rounded-sm border-t-4 border-[#F97C30] bg-white p-8 shadow-2xl md:p-10 lg:w-7/12">
            <div className="mb-8">
              <h3 className="text-2xl font-bold text-[#0B3570] mb-2">Get Free Quote Now</h3>
              <p className="text-sm text-blue-100/70">Leave your contact information, we will contact you ASAP!</p>
            </div>
            <form className="space-y-6">
              <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div className="flex flex-col gap-1.5">
                  <label className="text-sm font-semibold text-foreground">
                    Name <span className="text-[#F97C30]">*</span>
                  </label>
                  <input
                    type="text"
                    placeholder="John Smith"
                    required
                    className="px-4 py-2.5 border border-border rounded bg-white outline-none transition focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30]"
                  />
                </div>
                <div className="flex flex-col gap-1.5">
                  <label className="text-sm font-semibold text-foreground">
                    Company <span className="text-[#F97C30]">*</span>
                  </label>
                  <input
                    type="text"
                    placeholder="Your Company Inc."
                    required
                    className="px-4 py-2.5 border border-border rounded bg-white outline-none transition focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30]"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div className="flex flex-col gap-1.5">
                  <label className="text-sm font-semibold text-foreground">
                    Phone Number <span className="text-[#F97C30]">*</span>
                  </label>
                  <input
                    type="tel"
                    placeholder="+1 (555) 123-4567"
                    required
                    className="px-4 py-2.5 border border-border rounded bg-white outline-none transition focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30]"
                  />
                </div>
                <div className="flex flex-col gap-1.5">
                  <label className="text-sm font-semibold text-foreground">
                    Country <span className="text-[#F97C30]">*</span>
                  </label>
                  <input
                    type="text"
                    placeholder="United States"
                    required
                    className="px-4 py-2.5 border border-border rounded bg-white outline-none transition focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30]"
                  />
                </div>
              </div>

              <div className="flex flex-col gap-1.5">
                <label className="text-sm font-semibold text-foreground">
                  Message <span className="text-[#F97C30]">*</span>
                </label>
                <textarea
                  rows={4}
                  placeholder="Please specify your requirements, quantity, delivery timeline, or any special requests..."
                  required
                  className="px-4 py-2.5 border border-border rounded bg-white outline-none transition focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] resize-none"
                />
              </div>

              <div className="flex flex-col gap-1.5">
                <label className="text-sm font-semibold text-foreground">
                  Attachment <span className="font-normal text-muted-foreground">(Optional)</span>
                </label>
                <label className="w-full px-4 py-3 border-2 border-dashed border-[#F97C30] rounded bg-[#F97C30]/5 cursor-pointer hover:bg-[#F97C30]/10 transition flex items-center justify-center gap-2">
                  <Upload className="w-4 h-4 text-[#F97C30] shrink-0" />
                  <span className="text-sm text-muted-foreground">Click to upload file</span>
                  <input type="file" className="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" />
                </label>
              </div>

              <button
                type="submit"
                className="bg-[#0B3570] px-10 py-3 font-semibold text-sm uppercase tracking-widest text-white shadow-xl transition-all hover:-translate-y-0.5 hover:bg-[#F97C30]"
              >
                Submit Request
              </button>
            </form>
          </div>
        </div>
      </section>
    </main>
  );
}
