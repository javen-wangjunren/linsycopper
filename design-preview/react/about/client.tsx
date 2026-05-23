const clients = [
  { name: 'Bosch', industry: 'Automotive', logo: '/logos/bosch.jpg' },
  { name: 'Siemens', industry: 'Industrial', logo: '/logos/siemens.jpg' },
  { name: 'Foxconn', industry: 'Electronics', logo: '/logos/foxconn.jpg' },
  { name: 'BYD', industry: 'EV & Battery', logo: '/logos/byd.jpg' },
  { name: 'Honeywell', industry: 'Aerospace', logo: '/logos/honeywell.jpg' },
  { name: 'Schneider', industry: 'Energy', logo: '/logos/schneider.jpg' },
  { name: 'ABB', industry: 'Robotics', logo: '/logos/abb.jpg' },
  { name: 'Huawei', industry: 'Telecom', logo: '/logos/huawei.jpg' },
];

export default function ClientLogos() {
  return (
    <section className="bg-[#F8F9FA] py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-12 text-center">
          <div className="mb-3 inline-block rounded bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
            Trusted Partners
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Serving Industry Leaders
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            We are proud to supply precision copper materials to leading manufacturers across multiple industries.
          </p>
        </div>

        {/* Logo Grid */}
        <div className="grid grid-cols-2 gap-px bg-[#E5E7EB] border border-[#E5E7EB] rounded-sm overflow-hidden md:grid-cols-4">
          {clients.map((client) => (
            <div
              key={client.name}
              className="group flex flex-col items-center justify-center gap-4 bg-white px-6 py-12 transition-all hover:bg-[#F8F9FA]"
            >
              <img
                src={client.logo}
                alt={`${client.name} logo`}
                className="h-16 w-auto max-w-[150px] object-contain grayscale-0 opacity-80 transition-all duration-300 group-hover:opacity-100"
              />
              <span className="font-mono text-xs uppercase tracking-wider text-[#9CA3AF]">
                {client.industry}
              </span>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
