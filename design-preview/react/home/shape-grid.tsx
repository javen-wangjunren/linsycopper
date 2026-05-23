import { Button } from '@/components/ui/button';

const shapes = [
  {
    name: 'Copper Sheet',
    image: 'https://images.unsplash.com/photo-1558346489-19413928158b?auto=format&fit=crop&q=80&w=400',
  },
  {
    name: 'Copper Bar',
    image: 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&q=80&w=400',
  },
  {
    name: 'Copper Tube',
    image: 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=400',
  },
  {
    name: 'Copper Coil',
    image: 'https://images.unsplash.com/photo-1531287333317-190696328905?auto=format&fit=crop&q=80&w=400',
  },
  {
    name: 'Copper Wire',
    image: 'https://images.unsplash.com/photo-1611601679655-7c8bc197f0c6?auto=format&fit=crop&q=80&w=400',
  },
  {
    name: 'Copper Strip',
    image: 'https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?auto=format&fit=crop&q=80&w=400',
  },
];

export default function ByShapeGrid() {
  return (
    <section className="bg-white pt-[100px] pb-16 md:pb-24">
      <div className="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="mb-4 flex items-end justify-between">
          <div>
            <p className="mb-2 font-mono text-sm font-semibold uppercase tracking-wider text-[#F97C30]">
              BROWSE BY SHAPE
            </p>
            <h2 className="text-heading text-3xl font-bold text-[#1F2937] md:text-4xl">
              Find Copper Materials by Form
            </h2>
          </div>
          <Button
            variant="outline"
            className="hidden rounded-sm border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white md:flex bg-transparent"
          >
            View All Shapes →
          </Button>
        </div>
        <p className="mb-12 max-w-2xl text-base leading-relaxed text-[#6B7280]">
          Every form factor available in our complete inventory. Select your preferred shape to browse available grades and specifications.
        </p>

        {/* Shape Grid */}
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {shapes.map((shape, index) => (
            <div
              key={index}
              className="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg flex flex-col"
            >
              {/* Image Section - Top Half */}
              <div className="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                <img
                  src={shape.image}
                  alt={shape.name}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
              </div>

              {/* Card Content - Bottom Half */}
              <div className="flex flex-col flex-grow p-6 text-center">
                {/* Title */}
                <h3 className="text-heading mb-6 text-xl font-bold text-[#1F2937]">{shape.name}</h3>

                {/* CTA */}
                <button className="w-full rounded-sm bg-[#F2F4F7] py-3 text-sm font-semibold text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
                  View details
                </button>
              </div>

              {/* Accent Bar */}
              <div className="h-1 w-full bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] opacity-0 transition-opacity group-hover:opacity-100" />
            </div>
          ))}
        </div>

        {/* Mobile CTA */}
        <div className="mt-8 flex justify-center md:hidden">
          <Button
            variant="outline"
            className="rounded-sm border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white bg-transparent"
          >
            View All Shapes →
          </Button>
        </div>
      </div>
    </section>
  );
}
