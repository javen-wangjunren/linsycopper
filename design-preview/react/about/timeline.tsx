const milestones = [
  {
    year: '1998',
    title: 'Company Founded',
    description: 'Linsy Copper was established in Dongguan, China, starting as a small copper trading business with a vision to serve global manufacturers.',
    image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800&h=600',
  },
  {
    year: '2005',
    title: 'First Factory Built',
    description: 'Opened our first 5,000 sqm precision cutting and processing facility, expanding capabilities to include custom machining services.',
    image: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&q=80&w=800&h=600',
  },
  {
    year: '2010',
    title: 'ISO 9001 Certified',
    description: 'Achieved ISO 9001:2008 certification, establishing rigorous quality management systems across all operations.',
    image: 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=800&h=600',
  },
  {
    year: '2015',
    title: 'Global Expansion',
    description: 'Expanded export operations to 30+ countries, becoming a trusted supplier for aerospace, automotive, and electronics industries.',
    image: 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=800&h=600',
  },
  {
    year: '2020',
    title: 'New HQ & R&D Center',
    description: 'Relocated to a modern 20,000 sqm facility featuring advanced CNC equipment and dedicated materials research laboratory.',
    image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=800&h=600',
  },
  {
    year: '2024',
    title: 'Industry 4.0 Upgrade',
    description: 'Implemented smart manufacturing systems with real-time quality monitoring and automated inventory management.',
    image: 'https://images.unsplash.com/photo-1565514020179-026b92b84bb6?auto=format&fit=crop&q=80&w=800&h=600',
  },
];

export default function CompanyTimeline() {
  return (
    <section className="bg-white py-16 md:py-24 font-sans">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-20 text-center">
          <div className="mb-4 inline-flex items-center gap-2 rounded-sm bg-[#0B3570]/5 px-3 py-1 font-mono text-[11px] font-bold uppercase tracking-[0.1em] text-[#0B3570]">
            <span className="h-1.5 w-1.5 bg-[#F97C30]"></span>
            Our Journey
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl lg:text-5xl">
            25+ Years of Excellence
          </h2>
          <p className="mx-auto mt-6 max-w-2xl text-pretty text-lg leading-relaxed text-[#6B7280]">
            From a small trading company to a global copper solutions provider, our journey is defined by continuous innovation and customer trust.
          </p>
        </div>

        {/* Timeline Container */}
        <div className="relative">
          {/* Central Vertical Line (Industrial Gray) */}
          <div className="absolute left-4 top-0 h-full w-px bg-[#E5E7EB] md:left-1/2 md:-translate-x-1/2" aria-hidden="true" />

          <div className="space-y-16 md:space-y-24">
            {milestones.map((milestone, index) => {
              const isEven = index % 2 === 0;
              return (
                <div
                  key={milestone.year}
                  className={`relative flex flex-col md:flex-row items-center ${
                    isEven ? '' : 'md:flex-row-reverse'
                  }`}
                >
                  {/* Content Side (Text) */}
                  <div className={`w-full md:w-1/2 ${isEven ? 'md:pr-16 md:text-left pl-12 md:pl-0' : 'md:pl-16 md:text-left pl-12 md:pr-0'}`}>
                    <div className="max-w-xl">
                      <h3 className="mb-4 text-2xl font-bold leading-tight text-[#1F2937] md:text-3xl lg:text-4xl">
                        <span className="mr-2 font-mono text-[#0B3570]">{milestone.year}</span>
                        {milestone.title}
                      </h3>
                      <p className="text-base leading-relaxed text-[#6B7280]">
                        {milestone.description}
                      </p>
                    </div>
                  </div>

                  {/* Center Dot: Action Orange */}
                  <div className="absolute left-4 top-8 h-4 w-4 -translate-x-1/2 rounded-full border-4 border-white bg-[#F97C30] shadow-sm md:left-1/2 md:top-1/2 md:-translate-y-1/2" aria-hidden="true" />

                  {/* Image Side */}
                  <div className={`w-full md:w-1/2 mt-8 md:mt-0 ${isEven ? 'md:pl-16 pl-12 md:pr-0' : 'md:pr-16 pl-12 md:pl-0'}`}>
                    {milestone.image ? (
                      <div className="relative aspect-[4/3] w-full overflow-hidden rounded-sm bg-gray-100 shadow-md transition-all duration-500 hover:shadow-xl group">
                        <img
                          src={milestone.image}
                          alt={milestone.title}
                          className="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                      </div>
                    ) : (
                      <div className="hidden md:block h-20" />
                    )}
                  </div>
                </div>
              );
            })}
          </div>
        </div>

      </div>
    </section>
  );
}
