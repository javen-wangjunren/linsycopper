import Link from 'next/link';
import { Linkedin, Twitter } from 'lucide-react';

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-[#0B3570] text-gray-300 border-t border-white/10">
      {/* Main Footer Content */}
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
          {/* Brand & About */}
          <div>
            <div className="flex items-center gap-2 mb-6">
              <div className="w-10 h-10 bg-[#F97C30] rounded-sm flex items-center justify-center font-bold text-lg">
                C
              </div>
              <span className="text-xl font-bold text-white">
                COPPER<span className="text-[#F4BD5D]">CORP</span>
              </span>
            </div>
            <p className="text-sm leading-relaxed opacity-80 mb-6">
              Leading supplier of copper, brass, and bronze alloys. Serving aerospace, marine, and industrial markets globally since 1998.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="w-8 h-8 bg-white/10 rounded flex items-center justify-center hover:bg-[#F97C30] transition-colors">
                <Linkedin className="w-4 h-4" />
              </a>
              <a href="#" className="w-8 h-8 bg-white/10 rounded flex items-center justify-center hover:bg-[#F97C30] transition-colors">
                <Twitter className="w-4 h-4" />
              </a>
            </div>
          </div>

          {/* Products */}
          <div>
            <h4 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Products</h4>
            <ul className="space-y-3 text-sm">
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Copper Alloys
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Brass Alloys
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Bronze Alloys
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Copper Nickel
                </Link>
              </li>
            </ul>
          </div>

          {/* Company */}
          <div>
            <h4 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Company</h4>
            <ul className="space-y-3 text-sm">
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  About Us
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Quality & ISO
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Line Card (PDF)
                </Link>
              </li>
              <li>
                <Link href="/" className="hover:text-[#F4BD5D] transition-colors">
                  Contact
                </Link>
              </li>
            </ul>
          </div>

          {/* Contact Sales */}
          <div>
            <h4 className="text-white font-bold mb-6 uppercase text-sm tracking-wider">Contact Sales</h4>
            <ul className="space-y-4 text-sm">
              <li className="flex items-start gap-3">
                {/* Map pin SVG */}
                <svg className="w-4 h-4 mt-0.5 shrink-0 text-[#F97C30]" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                  <circle cx="12" cy="9" r="2.5"/>
                </svg>
                <div>
                  <div>1234 Industrial Blvd</div>
                  <div>Metal City, TX 77000</div>
                </div>
              </li>
              <li className="flex items-center gap-3">
                {/* Phone SVG */}
                <svg className="w-4 h-4 shrink-0 text-[#F97C30]" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6.18 6.18l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.02z"/>
                </svg>
                <a href="tel:+18001234567" className="font-mono text-white hover:text-[#F4BD5D] transition-colors">
                  +1 (800) 123-4567
                </a>
              </li>
              <li className="flex items-center gap-3">
                {/* Email SVG */}
                <svg className="w-4 h-4 shrink-0 text-[#F97C30]" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <rect width="20" height="16" x="2" y="4" rx="2"/>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <a href="mailto:sales@coppercorp.com" className="hover:text-[#F4BD5D] transition-colors">
                  sales@coppercorp.com
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t border-white/10">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
          <div className="text-center text-sm text-gray-400">
            © {currentYear} CopperCorp Inc. All rights reserved.
          </div>
        </div>
      </div>
    </footer>
  );
}
