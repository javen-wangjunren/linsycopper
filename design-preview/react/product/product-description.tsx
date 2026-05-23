import { CheckCircle2 } from 'lucide-react';

export default function ProductDescription() {
  const features = [
    'Manufactured to ASTM B152 standards',
    'Available in multiple tempers (H00 to H04)',
    'Custom cutting and sizing available',
    'Full material test reports (MTR) included',
    'Precision tolerance: ±0.001"',
    'Surface finishes: Mill, Polished, or Custom',
  ];

  const availableSizes = [
    { thickness: '0.016" - 0.125"', width: 'Up to 48"', length: 'Up to 144"' },
    { thickness: '0.125" - 0.250"', width: 'Up to 48"', length: 'Up to 120"' },
    { thickness: '0.250" - 0.500"', width: 'Up to 36"', length: 'Up to 96"' },
  ];

  return (
    <section id="description" className="bg-white py-16">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-12">
          <h2 className="text-3xl font-bold text-foreground md:text-4xl mb-4">
            Product Overview
          </h2>
          <div className="prose prose-lg max-w-none">
            <p className="text-muted-foreground leading-relaxed mb-4">
              C11000, also known as Electrolytic Tough Pitch (ETP) Copper, is the most widely used grade 
              of copper. With a minimum copper content of 99.9% and excellent electrical conductivity 
              (101% IACS), it serves as the industry standard for electrical and electronic applications.
            </p>
            <p className="text-muted-foreground leading-relaxed mb-4">
              This high-purity copper sheet is manufactured through continuous casting and rolling 
              processes, ensuring consistent mechanical properties and surface finish. Its outstanding 
              thermal conductivity (391 W/m·K) makes it ideal for heat exchangers, while its formability 
              allows for complex stamping and bending operations.
            </p>
            <p className="text-muted-foreground leading-relaxed">
              Suitable for both indoor and outdoor applications, C11000 offers good corrosion resistance 
              and can be easily joined through welding, brazing, or soldering. All material is certified 
              to ASTM B152 and ships with complete documentation including Material Test Reports (MTR) 
              and Certificates of Compliance (COC).
            </p>
          </div>
        </div>

        {/* Key Features */}
        <div className="mb-12 rounded border border-border bg-muted/30 p-6">
          <h3 className="text-xl font-bold text-[#0B3570] mb-4">Key Features</h3>
          <div className="grid gap-3 sm:grid-cols-2">
            {features.map((feature, idx) => (
              <div key={idx} className="flex items-start gap-2">
                <CheckCircle2 className="w-5 h-5 text-[#F97C30] flex-shrink-0 mt-0.5" />
                <span className="text-sm text-foreground">{feature}</span>
              </div>
            ))}
          </div>
        </div>

        {/* Available Sizes */}
        <div>
          <h3 className="text-xl font-bold text-[#0B3570] mb-4">Available Sizes</h3>
          <div className="overflow-x-auto rounded border border-border">
            <table className="w-full">
              <thead className="bg-[#0B3570] text-white">
                <tr>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Thickness Range</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Width (Max)</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Length (Max)</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-border">
                {availableSizes.map((size, idx) => (
                  <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-muted/50'}>
                    <td className="px-6 py-3 font-mono text-sm font-semibold text-foreground">{size.thickness}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{size.width}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{size.length}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <p className="mt-4 text-sm text-muted-foreground">
            * Custom sizes available upon request. Contact our sales team for special requirements.
          </p>
        </div>
      </div>
    </section>
  );
}
