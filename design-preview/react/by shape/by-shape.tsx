import Link from 'next/link';
import { 
  Square, 
  Circle, 
  Cylinder,
  Box,
  Hexagon,
  Workflow,
  Factory,
  Zap,
  Waves
} from 'lucide-react';

export default function ShapesPage() {
  const shapes = [
    {
      id: 'bar',
      name: 'Copper Round Bar',
      description: 'Available in round, square, hex, and rectangle and in a variety of thicknesses and widths',
      icon: Circle,
      grades: ['C36000', 'C14500', 'C17200', 'C18200'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=400&h=300&fit=crop',
    },
    {
      id: 'sheet',
      name: 'Sheets & Plates',
      description: 'Large inventories in brass, bronze, and copper alloy sheet and alloy plate',
      icon: Square,
      grades: ['C11000', 'C10100', 'C26000', 'C46400'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?w=400&h=300&fit=crop',
    },
    {
      id: 'wire',
      name: 'Wire',
      description: 'Copper alloy wire in a variety of alloys and specifications',
      icon: Waves,
      grades: ['C11000', 'C26000', 'C51000', 'C17200'],
      inStock: false,
      image: 'https://images.unsplash.com/photo-1585435557515-e4e8f6b3b1c1?w=400&h=300&fit=crop',
    },
    {
      id: 'pipe',
      name: 'Pipe',
      description: 'Large inventories of copper alloy pipe for industrial applications',
      icon: Cylinder,
      grades: ['C12200', 'C14200', 'C23000', 'C44300'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=400&h=300&fit=crop',
    },
    {
      id: 'tube',
      name: 'Tubes',
      description: 'Precision copper alloy tube for demanding applications',
      icon: Cylinder,
      grades: ['C12200', 'C70600', 'C44300', 'C71500'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1587293852726-70cdb56c2866?w=400&h=300&fit=crop',
    },
    {
      id: 'profile',
      name: 'Profile',
      description: 'Custom alloy profile shapes and sizes in copper, bronze, and brass alloys',
      icon: Hexagon,
      grades: ['C36000', 'C26000', 'C46400', 'C17200'],
      inStock: false,
      image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=400&h=300&fit=crop',
    },
    {
      id: 'rolled',
      name: 'Rolled Products',
      description: 'Large range of brass, phosphor bronze, and copper rolled products',
      icon: Factory,
      grades: ['C11000', 'C51000', 'C26000', 'C10100'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=400&h=300&fit=crop',
    },
    {
      id: 'forgings',
      name: 'Forgings',
      description: 'Copper and bronze forgings in accordance to your specifications',
      icon: Box,
      grades: ['C36000', 'C46400', 'C95400', 'C93200'],
      inStock: true,
      image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=400&h=300&fit=crop',
    },
    {
      id: 'rwma',
      name: 'RWMA/Welding Alloys',
      description: 'Wide range of Resistance Welding Products for industrial use',
      icon: Zap,
      grades: ['C18200', 'C14500', 'C15760', 'C18000'],
      inStock: false,
      image: 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=400&h=300&fit=crop',
    },
  ];

  return (
    <main className="bg-white">
      {/* Breadcrumb Navigation */}
      <section className="border-b border-[#E5E7EB] bg-white">
        <div className="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
          <nav className="flex items-center gap-2 font-mono text-xs font-semibold uppercase tracking-wider text-[#6B7280]">
            <Link href="/" className="flex items-center hover:text-[#F97C30] transition-colors">
              <svg className="mr-1.5 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
              </svg>
              Home
            </Link>
            <span>/</span>
            <Link href="/catalog" className="hover:text-[#F97C30] transition-colors">
              Catalog
            </Link>
            <span>/</span>
            <span className="text-[#0B3570]">Copper Alloy Shapes</span>
          </nav>
        </div>
      </section>

      {/* Hero Section */}
      <section className="bg-white py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
            <div className="max-w-3xl">
              <p className="mb-4 font-mono text-sm font-semibold uppercase tracking-wider text-[#F97C30]">
                PRODUCT CATALOG
              </p>
              <h1 className="mb-6 text-4xl font-bold leading-tight text-[#1F2937] md:text-5xl">
                Our Metal Alloy <span className="text-[#0B3570]">Shapes</span>
              </h1>
              <p className="text-lg leading-relaxed text-[#6B7280]">
                We maintain huge inventories of metal shapes, including bar, pipe, tube, sheet/plate, wire, forgings, and
                profiles according to your requirements. Along with our extensive bronze, brass, and copper shapes inventory, we can
                provide material cut to your specification on our state-of-the-art cutting equipment.
              </p>
            </div>
            <div className="flex shrink-0 flex-col gap-4">
              <div className="mb-2 text-right">
                <p className="font-mono text-xs font-semibold uppercase tracking-wider text-[#F97C30]">
                  Need Help?
                </p>
              </div>
              <Link
                href="/contact"
                className="rounded-sm bg-[#0B3570] px-8 py-4 text-center font-mono text-xs font-bold uppercase tracking-widest text-white shadow-lg transition-all hover:bg-[#0B3570]/90 active:scale-95"
              >
                Contact Us
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Shapes Grid */}
      <section className="bg-[#F2F4F7] py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            {shapes.map((shape) => {
              const Icon = shape.icon;
              return (
                <div
                  key={shape.id}
                  className="group flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-xl"
                >
                  {/* Image Section */}
                  <div className="relative aspect-[4/3] overflow-hidden border-b border-[#E5E7EB] bg-[#F2F4F7]">
                    <img
                      src={shape.image || "/placeholder.svg"}
                      alt={shape.name}
                      className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                    {shape.inStock && (
                      <div className="absolute right-0 top-0 bg-[#0B3570] px-3 py-1.5 font-mono text-[9px] font-bold uppercase tracking-widest text-white">
                        Ready to Ship
                      </div>
                    )}
                    {/* Icon Overlay */}
                    <div className="absolute bottom-4 left-4">
                      <div className="flex h-12 w-12 items-center justify-center rounded-sm bg-white/90 backdrop-blur-sm">
                        <Icon className="h-6 w-6 text-[#0B3570]" />
                      </div>
                    </div>
                  </div>

                  {/* Content Section */}
                  <div className="flex flex-1 flex-col p-8">
                    <h3 className="mb-4 text-xl font-bold uppercase tracking-tight text-[#0B3570]">
                      {shape.name}
                    </h3>
                    <p className="mb-6 text-sm leading-relaxed text-[#6B7280]">
                      {shape.description}
                    </p>

                    {/* Best Selling Grades */}
                    <div className="mb-8 flex-1">
                      <span className="mb-3 block font-mono text-[10px] font-bold uppercase tracking-widest text-[#6B7280]">
                        Best Selling Grade
                      </span>
                      <div className="grid grid-cols-2 gap-2">
                        {shape.grades.map((grade) => (
                          <div
                            key={grade}
                            className="bg-[#F2F4F7] py-2 text-center font-mono text-[11px] font-bold text-[#0B3570]"
                          >
                            {grade}
                          </div>
                        ))}
                      </div>
                    </div>

                    {/* CTA Button */}
                    <button className="w-full rounded-sm bg-[#0B3570] py-3.5 font-mono text-[10px] font-bold uppercase tracking-widest text-white transition-colors hover:bg-[#F97C30]">
                      View Specifications
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="bg-white py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-sm border-2 border-[#0B3570] bg-gradient-to-br from-[#0B3570] to-[#0B3570]/90 p-8 text-center md:p-12">
            <h3 className="mb-4 text-balance text-2xl font-bold text-white md:text-3xl">
              Can't Find the Shape You Need?
            </h3>
            <p className="mb-6 text-pretty text-white/90">
              Our technical team can help you find the right material and shape for your specific application. Contact us today for expert guidance.
            </p>
            <div className="flex justify-center">
              <Link
                href="/contact"
                className="rounded-sm bg-[#F97C30] px-8 py-3 font-semibold text-white transition-all hover:bg-[#F4BD5D] hover:shadow-lg"
              >
                Contact Sales Team
              </Link>
            </div>
          </div>
        </div>
      </section>
    </main>
  );
}
