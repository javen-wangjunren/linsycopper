'use client';

import Link from 'next/link';
import { ChevronRight } from 'lucide-react';

interface BreadcrumbProps {
  items: Array<{
    label: string;
    href?: string;
  }>;
}

export default function Breadcrumb({ items }: BreadcrumbProps) {
  return (
    <nav className="bg-white border-b border-border" aria-label="Breadcrumb">
      <div className="mx-auto max-w-7xl px-4 py-3">
        <div className="flex items-center gap-2 text-sm">
          {items.map((item, idx) => (
            <div key={idx} className="flex items-center gap-2">
              {idx > 0 && (
                <ChevronRight className="w-4 h-4 text-muted-foreground flex-shrink-0" />
              )}
              {item.href ? (
                <Link
                  href={item.href}
                  className="text-[#0B3570] hover:text-[#0B3570]/80 transition-colors font-medium"
                >
                  {item.label}
                </Link>
              ) : (
                <span className="text-foreground font-medium">{item.label}</span>
              )}
            </div>
          ))}
        </div>
      </div>
    </nav>
  );
}
