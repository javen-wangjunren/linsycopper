import { CheckCircle, FileText, Shield } from 'lucide-react';

const certifications = [
  {
    name: 'ISO 9001:2015',
    description: 'Quality Management System',
    image: 'https://images.unsplash.com/photo-1633158829585-23ba8f7c8acc?auto=format&fit=crop&q=80&w=600&h=800',
  },
  {
    name: 'RoHS Compliance',
    description: 'Environmental Standards',
    image: 'https://images.unsplash.com/photo-1589118949245-7d38baf380d6?auto=format&fit=crop&q=80&w=600&h=800',
  },
  {
    name: 'ASTM Certified',
    description: 'Material Specifications',
    image: 'https://images.unsplash.com/photo-1581092334651-dd3c644388f0?auto=format&fit=crop&q=80&w=600&h=800',
  },
];

export default function Certifications() {
  return (
    <section className="bg-[#F8F9FA] py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-12 text-center">
          <div className="mb-3 inline-block rounded bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
            Quality Assurance
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Certifications & Standards
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Our commitment to quality is backed by industry-recognized certifications and rigorous compliance standards.
          </p>
        </div>

        {/* Certifications — 3 columns, 3:4 aspect ratio certificates */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {certifications.map((cert) => (
            <div
              key={cert.name}
              className="group flex flex-col"
            >
              {/* Certificate Image — 3:4 ratio, full width */}
              <div className="relative w-full overflow-hidden rounded-sm bg-[#E5E7EB] shadow-md transition-all duration-300 group-hover:shadow-xl"
                style={{ aspectRatio: '3 / 4' }}
              >
                <img
                  src={cert.image}
                  alt={cert.name}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-103"
                />
                {/* Subtle top gradient for readability */}
                <div className="absolute inset-0 bg-gradient-to-b from-black/5 to-transparent pointer-events-none" />
              </div>

              {/* Label below certificate */}
              <div className="mt-4 flex items-center justify-between">
                <div>
                  <h3 className="text-base font-bold text-[#0B3570]">
                    {cert.name}
                  </h3>
                  <p className="mt-0.5 font-mono text-xs uppercase tracking-wider text-[#6B7280]">
                    {cert.description}
                  </p>
                </div>
                {/* Orange accent line on hover */}
                <div className="h-8 w-1 rounded-full bg-[#E5E7EB] transition-colors duration-300 group-hover:bg-[#F97C30]" />
              </div>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
