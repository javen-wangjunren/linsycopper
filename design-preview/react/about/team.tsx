import { Linkedin, Mail } from 'lucide-react';

const team = [
  {
    name: 'James Lin',
    position: 'Founder & CEO',
    bio: '25+ years in copper industry. Former procurement director at a Fortune 500 electronics manufacturer.',
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=face',
  },
  {
    name: 'Sarah Chen',
    position: 'Technical Director',
    bio: 'PhD in Materials Science. Expert in copper alloy metallurgy and heat treatment processes.',
    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop&crop=face',
  },
  {
    name: 'Michael Wang',
    position: 'Operations Manager',
    bio: '15 years in precision manufacturing. Lean Six Sigma Black Belt certified.',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=face',
  },
  {
    name: 'Emily Zhang',
    position: 'Sales Director',
    bio: 'Manages global client relationships across 30+ countries. Fluent in English, Mandarin, and German.',
    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop&crop=face',
  },
];

export default function OurTeam() {
  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {/* Section Header */}
        <div className="mb-12 text-center">
          <div className="mb-3 inline-block rounded bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
            Leadership
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Meet Our Team
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Industry experts dedicated to delivering exceptional copper solutions and technical support.
          </p>
        </div>

        {/* Team Grid */}
        <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
          {team.map((member) => (
            <div
              key={member.name}
              className="group relative overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#F97C30] hover:shadow-lg"
            >
              {/* Avatar */}
              <div className="relative aspect-square overflow-hidden bg-[#F2F4F7]">
                <img
                  src={member.avatar}
                  alt={member.name}
                  className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-[#0B3570]/60 to-transparent opacity-0 transition-opacity group-hover:opacity-100" />
                
                {/* Social Links (show on hover) */}
                <div className="absolute bottom-4 left-4 flex gap-2 opacity-0 transition-opacity group-hover:opacity-100">
                  <a
                    href="#"
                    className="flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[#0B3570] transition-colors hover:bg-[#F97C30] hover:text-white"
                  >
                    <Linkedin size={16} />
                  </a>
                  <a
                    href="#"
                    className="flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[#0B3570] transition-colors hover:bg-[#F97C30] hover:text-white"
                  >
                    <Mail size={16} />
                  </a>
                </div>
              </div>

              {/* Info */}
              <div className="p-5">
                <h3 className="font-bold text-[#0B3570]">{member.name}</h3>
                <p className="mb-2 font-mono text-xs uppercase tracking-wider text-[#F97C30]">
                  {member.position}
                </p>
                <p className="text-sm leading-relaxed text-[#6B7280]">
                  {member.bio}
                </p>
              </div>

              {/* Bottom Accent Bar */}
              <div className="h-1 w-0 bg-gradient-to-r from-[#F97C30] to-[#F4BD5D] transition-all duration-300 group-hover:w-full" />
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}
