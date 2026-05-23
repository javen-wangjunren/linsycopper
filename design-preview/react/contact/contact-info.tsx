import { Phone, Mail, MapPin, Clock } from 'lucide-react';

const contactMethods = [
  {
    icon: Phone,
    title: 'Phone',
    value: '+1 (555) 123-4567',
    description: 'Monday-Friday, 9AM-6PM EST',
  },
  {
    icon: Mail,
    title: 'Email',
    value: 'sales@linsycopper.com',
    description: 'Respond within 24 hours',
  },
  {
    icon: MapPin,
    title: 'Address',
    value: '123 Industrial Ave, Suite 200',
    description: 'New York, NY 10001, USA',
  },
  {
    icon: Clock,
    title: 'Business Hours',
    value: 'Mon - Fri: 9:00 AM - 6:00 PM',
    description: 'EST (Holidays Excluded)',
  },
];

export default function ContactInfo() {
  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12 text-center">
          <h1 className="text-balance text-4xl font-bold tracking-tight text-[#1F2937] md:text-5xl">
            Get in <span className="text-[#F97C30]">Touch</span>
          </h1>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Multiple ways to reach our sales and support team
          </p>
        </div>

        {/* Contact Cards Grid */}
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
          {contactMethods.map((method) => (
            <div
              key={method.title}
              className="group flex flex-col items-center rounded border border-[#E5E7EB] bg-white p-6 text-center transition-all hover:border-[#F97C30] hover:shadow-lg"
            >
              <div className="mb-4 flex h-12 w-12 items-center justify-center rounded bg-[#0B3570]/10 text-[#0B3570] transition-colors group-hover:bg-[#F97C30] group-hover:text-white">
                <method.icon size={24} strokeWidth={2} />
              </div>
              <h3 className="mb-2 font-semibold text-[#1F2937]">{method.title}</h3>
              <p className="mb-3 text-sm font-mono font-bold text-[#0B3570]">{method.value}</p>

              {/* Bottom accent bar */}
              <div className="mt-4 h-0.5 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full" />
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
