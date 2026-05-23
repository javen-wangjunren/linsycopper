const reasons = [
  {
    icon: '01',
    title: 'Fast, Reliable, and Expert Service',
    description: 'Our team delivers quick, dependable copper machining services with honest, expert advice every step of the way.',
  },
  {
    icon: '02',
    title: 'Precision-Focused Solutions, Anytime',
    description: 'We specialize exclusively in high-purity copper alloys, providing tailored solutions whenever you need them, no matter the project scale.',
  },
  {
    icon: '03',
    title: '100% Quality Satisfaction Guarantee',
    description: "If you're not completely happy with our material quality or precision cuts, we'll make it right—your satisfaction is our top priority.",
  },
];

const stats = [
  { value: '25+', label: 'Years Experience' },
  { value: '5,000+', label: 'Tons in Stock' },
  { value: '98%', label: 'On-Time Delivery' },
  { value: 'ISO', label: '9001 Certified' },
];

export default function WhyChooseUs() {
  return (
    <section className="relative overflow-hidden bg-[#F8FAFC] pt-[100px] pb-24">
      {/* Background Technical Grid */}
      <div className="absolute inset-0 opacity-[0.03] pointer-events-none" 
           style={{ backgroundImage: 'radial-gradient(#0B3570 1px, transparent 1px)', backgroundSize: '24px 24px' }}>
      </div>

      <div className="relative mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">

        {/* Top Section: Split Layout */}
        <div className="flex flex-col gap-12 lg:flex-row lg:items-start mb-20">

          {/* Left: Content Area */}
          <div className="flex flex-col gap-8 lg:w-1/2">
            <div className="flex flex-col gap-5">
              <div className="inline-block rounded-sm bg-[#0B3570]/10 px-3 py-1 font-mono text-[10px] font-bold uppercase tracking-[0.2em] text-[#0B3570] w-fit border-l-2 border-[#F97C30]">
                Why Us
              </div>
              <h2 className="text-heading text-balance text-4xl font-bold tracking-tight leading-[1.1] md:text-5xl lg:text-6xl">
                Why Choose <br/><span className="text-[#0B3570]">Linsy Copper?</span>
              </h2>
              <p className="max-w-xl text-[#6B7280] leading-relaxed text-base md:text-lg">
                With over two decades of expertise in copper and alloy distribution, we deliver precision-cut materials with full traceability and unmatched technical support.
              </p>
            </div>

            {/* Stats Dashboard Grid */}
            <div className="grid grid-cols-2 gap-4 w-full max-w-md">
              {stats.map((stat) => (
                <div key={stat.label} className="relative bg-white p-5 border border-[#E5E7EB] rounded-sm group hover:border-[#F97C30] transition-colors">
                  {/* Technical Corner Accent */}
                  <div className="absolute top-0 right-0 w-2 h-2 border-t border-r border-[#E5E7EB] group-hover:border-[#F97C30]"></div>
                  
                  <div className="flex flex-col">
                    <span className="font-mono text-3xl font-bold text-[#0B3570] tracking-tight">{stat.value}</span>
                    <span className="mt-1 text-[10px] font-bold uppercase tracking-wider text-[#9CA3AF]">{stat.label}</span>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* Right: Technical Visual */}
          <div className="lg:w-1/2">
            <div className="relative group">
              {/* Image Container with "Machined" Border */}
              <div className="relative overflow-hidden rounded-sm border-[8px] border-white shadow-xl aspect-[4/3]">
                <img
                  src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=2070"
                  alt="Linsy Copper Expert Service"
                  className="h-full w-full object-cover grayscale-[0.3] contrast-[1.1] transition-transform duration-700 group-hover:scale-105"
                />
                {/* Industrial Overlay */}
                <div className="absolute inset-0 bg-gradient-to-tr from-[#0B3570]/40 via-transparent to-transparent mix-blend-multiply" />
              </div>
              
              {/* Floating Badge (Copper Element) */}
              <div className="absolute -bottom-6 -left-6 hidden md:block bg-[#F97C30] p-6 rounded-sm shadow-2xl text-white">
                <div className="font-mono text-sm font-bold opacity-80 mb-1 uppercase tracking-widest">Quality Assurance</div>
                <div className="text-2xl font-bold leading-none italic">100% Traceable</div>
              </div>
            </div>
          </div>
        </div>

        {/* Bottom Section: 3-Column Advantage Cards */}
        <div className="grid gap-6 md:grid-cols-3 border-t border-[#E5E7EB] pt-16">
          {reasons.map((reason) => (
            <div
              key={reason.title}
              className="group relative flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-2xl"
            >
              {/* Background Index Number (Etched look) */}
              <span className="absolute -right-2 -top-4 font-mono text-8xl font-black text-[#0B3570]/[0.03] transition-colors group-hover:text-[#F97C30]/[0.05] leading-none select-none italic">
                {reason.icon}
              </span>

              <h3 className="text-heading relative mb-4 text-lg font-bold leading-snug text-[#1F2937] group-hover:text-[#0B3570] transition-colors">
                {reason.title}
                <div className="absolute -left-8 top-1/2 w-4 h-[2px] bg-[#F97C30] opacity-0 group-hover:opacity-100 transition-all"></div>
              </h3>
              
              <p className="relative text-[#6B7280] leading-relaxed text-sm flex-1">
                {reason.description}
              </p>
              
              {/* Bottom Progress Indicator */}
              <div className="mt-8 h-[2px] w-full bg-[#F3F4F6] overflow-hidden">
                <div className="h-full w-0 bg-[#F97C30] transition-all duration-500 group-hover:w-full" />
              </div>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
