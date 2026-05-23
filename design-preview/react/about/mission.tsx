import { Target, Eye, Heart } from 'lucide-react';

const values = [
  {
    icon: Target,
    title: 'Our Mission',
    description: 'To provide precision-engineered copper and alloy solutions that empower manufacturers worldwide to build products of exceptional quality and reliability.',
  },
  {
    icon: Eye,
    title: 'Our Vision',
    description: 'To be the most trusted copper materials partner globally, recognized for technical excellence, supply chain reliability, and unwavering commitment to customer success.',
  },
  {
    icon: Heart,
    title: 'Our Values',
    description: 'Integrity in every transaction. Precision in every cut. Partnership in every relationship. We believe long-term trust is built through consistent excellence.',
  },
];

export default function MissionValues() {
  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Three Column Grid */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {values.map((item) => (
            <div
              key={item.title}
              className="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white p-8 transition-all hover:border-[#F97C30] hover:shadow-lg"
            >
              {/* Icon */}
              <div className="mb-6 flex h-12 w-12 items-center justify-center rounded bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
                <item.icon size={24} strokeWidth={1.5} />
              </div>

              {/* Content */}
              <h3 className="mb-3 text-lg font-bold text-[#0B3570]">
                {item.title}
              </h3>
              <p className="text-sm leading-relaxed text-[#6B7280]">
                {item.description}
              </p>

              {/* Bottom Accent Bar */}
              <div className="absolute bottom-0 left-0 h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full" />
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
