export default function Specifications() {
  const chemicalComposition = [
    { element: 'Cu', min: '99.90', max: '-', note: 'Including Ag' },
    { element: 'Ag', min: '-', max: '0.034', note: 'Included in Cu' },
    { element: 'P', min: '-', max: '0.001', note: 'Trace' },
    { element: 'Pb', min: '-', max: '0.005', note: 'Max' },
    { element: 'Fe', min: '-', max: '0.005', note: 'Max' },
  ];

  const mechanicalProperties = [
    { property: 'Tensile Strength', temper: 'H00 (Soft)', value: '220-275 MPa', standard: 'ASTM B152' },
    { property: 'Tensile Strength', temper: 'H02 (Half Hard)', value: '275-345 MPa', standard: 'ASTM B152' },
    { property: 'Hardness (HRB)', temper: 'H00 (Soft)', value: '40-60', standard: 'ASTM E18' },
    { property: 'Elongation', temper: 'H00 (Soft)', value: '35-45%', standard: 'ASTM B152' },
    { property: 'Yield Strength', temper: 'H02 (Half Hard)', value: '205-250 MPa', standard: 'ASTM B152' },
  ];

  const physicalProperties = [
    { property: 'Density', value: '8.94 g/cm³', temp: '20°C', standard: 'ASTM B152' },
    { property: 'Electrical Conductivity', value: '101% IACS', temp: '20°C', standard: 'ASTM B193' },
    { property: 'Thermal Conductivity', value: '391 W/m·K', temp: '20°C', standard: 'ASTM E1461' },
    { property: 'Coefficient of Thermal Expansion', value: '16.5 × 10⁻⁶/K', temp: '20-300°C', standard: 'ASTM E228' },
    { property: 'Melting Point', value: '1083°C', temp: '-', standard: 'Reference' },
  ];

  return (
    <section id="specifications" className="bg-white py-16">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-12 text-center">
          <h2 className="text-3xl font-bold text-foreground md:text-4xl">
            Technical Specifications
          </h2>
          <p className="mt-3 text-muted-foreground max-w-2xl mx-auto">
            Precision data for engineering decisions. All values tested per ASTM standards.
          </p>
        </div>

        {/* Chemical Composition */}
        <div className="mb-12">
          <h3 className="mb-4 text-xl font-bold text-[#0B3570] flex items-center">
            <span className="inline-flex items-center justify-center w-8 h-8 rounded bg-[#0B3570] text-white text-sm font-mono mr-3">
              01
            </span>
            Chemical Composition
          </h3>
          <div className="overflow-x-auto rounded border border-border">
            <table className="w-full">
              <thead className="bg-[#0B3570] text-white">
                <tr>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Element</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Min (%)</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Max (%)</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Note</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-border">
                {chemicalComposition.map((item, idx) => (
                  <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-muted/50'}>
                    <td className="px-6 py-3 font-mono font-semibold text-foreground">{item.element}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{item.min}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{item.max}</td>
                    <td className="px-6 py-3 text-sm text-muted-foreground">{item.note}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Mechanical Properties */}
        <div className="mb-12">
          <h3 className="mb-4 text-xl font-bold text-[#0B3570] flex items-center">
            <span className="inline-flex items-center justify-center w-8 h-8 rounded bg-[#0B3570] text-white text-sm font-mono mr-3">
              02
            </span>
            Mechanical Properties
          </h3>
          <div className="overflow-x-auto rounded border border-border">
            <table className="w-full">
              <thead className="bg-[#0B3570] text-white">
                <tr>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Property</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Temper</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Value</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Standard</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-border">
                {mechanicalProperties.map((item, idx) => (
                  <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-muted/50'}>
                    <td className="px-6 py-3 font-semibold text-foreground">{item.property}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{item.temper}</td>
                    <td className="px-6 py-3 font-mono text-sm text-[#F97C30] font-semibold">{item.value}</td>
                    <td className="px-6 py-3 font-mono text-xs text-muted-foreground">{item.standard}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Physical Properties */}
        <div>
          <h3 className="mb-4 text-xl font-bold text-[#0B3570] flex items-center">
            <span className="inline-flex items-center justify-center w-8 h-8 rounded bg-[#0B3570] text-white text-sm font-mono mr-3">
              03
            </span>
            Physical Properties
          </h3>
          <div className="overflow-x-auto rounded border border-border">
            <table className="w-full">
              <thead className="bg-[#0B3570] text-white">
                <tr>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Property</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Value</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Temperature</th>
                  <th className="px-6 py-3 text-left text-sm font-semibold">Standard</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-border">
                {physicalProperties.map((item, idx) => (
                  <tr key={idx} className={idx % 2 === 0 ? 'bg-white' : 'bg-muted/50'}>
                    <td className="px-6 py-3 font-semibold text-foreground">{item.property}</td>
                    <td className="px-6 py-3 font-mono text-sm text-[#F97C30] font-semibold">{item.value}</td>
                    <td className="px-6 py-3 font-mono text-sm text-muted-foreground">{item.temp}</td>
                    <td className="px-6 py-3 font-mono text-xs text-muted-foreground">{item.standard}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  );
}
