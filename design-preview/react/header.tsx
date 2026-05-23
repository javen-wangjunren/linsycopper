'use client';

import Link from 'next/link';
import { useState, useRef, useEffect, useCallback } from 'react';
import { Menu, X, ChevronDown, ArrowRight } from 'lucide-react';

// ─── Navigation Data ────────────────────────────────────────────────────────

const NAV_ITEMS = [
  {
    label: 'By Shape',
    href: '/shapes',
    type: 'mega' as const,
    columns: [
      {
        heading: 'Copper Sheet',
        href: '/shapes/copper-sheet',
        items: [
          { label: 'Pure Copper Sheet', href: '/shapes/copper-sheet/pure-copper' },
          { label: 'Brass Sheet', href: '/shapes/copper-sheet/brass' },
          { label: 'Bronze Sheet', href: '/shapes/copper-sheet/bronze' },
          { label: 'Cupronickel Sheet', href: '/shapes/copper-sheet/cupronickel' },
          { label: 'Pre-Patinated Sheet', href: '/shapes/copper-sheet/pre-patinated' },
        ],
      },
      {
        heading: 'Copper Bar',
        href: '/shapes/copper-bar',
        items: [
          { label: 'Pure Copper Bar', href: '/shapes/copper-bar/pure-copper' },
          { label: 'Brass Bar', href: '/shapes/copper-bar/brass' },
          { label: 'Bronze Bar', href: '/shapes/copper-bar/bronze' },
          { label: 'Copper Bus Bar', href: '/shapes/copper-bar/bus-bar' },
          { label: 'Copper Flat Bar', href: '/shapes/copper-bar/flat-bar' },
        ],
      },
      {
        heading: 'Copper Tube',
        href: '/shapes/copper-tube',
        items: [
          { label: 'Pure Copper Tube', href: '/shapes/copper-tube/pure-copper' },
          { label: 'Brass Tube', href: '/shapes/copper-tube/brass' },
          { label: 'Bronze Tube', href: '/shapes/copper-tube/bronze' },
          { label: 'Inner Grooved Tube', href: '/shapes/copper-tube/inner-grooved' },
          { label: 'AC Copper Tube', href: '/shapes/copper-tube/air-conditioning' },
        ],
      },
      {
        heading: 'Copper Wire',
        href: '/shapes/copper-wire',
        items: [
          { label: 'Pure Copper Wire', href: '/shapes/copper-wire/pure-copper' },
          { label: 'Brass Wire', href: '/shapes/copper-wire/brass' },
          { label: 'Bare Copper Wire', href: '/shapes/copper-wire/bare' },
          { label: 'Annealed Copper Wire', href: '/shapes/copper-wire/annealed' },
          { label: 'Electrical Copper Wire', href: '/shapes/copper-wire/electrical' },
        ],
      },
    ],
  },
  {
    label: 'By Material',
    href: '/materials',
    type: 'mega' as const,
    columns: [
      {
        heading: 'Pure Copper',
        href: '/materials/pure-copper',
        items: [
          { label: 'Pure Copper Sheet', href: '/materials/pure-copper/sheet' },
          { label: 'Pure Copper Bar', href: '/materials/pure-copper/bar' },
          { label: 'Pure Copper Tube', href: '/materials/pure-copper/tube' },
          { label: 'Pure Copper Wire', href: '/materials/pure-copper/wire' },
          { label: 'Copper Strip & Coil', href: '/materials/pure-copper/strip-coil' },
        ],
      },
      {
        heading: 'Brass',
        href: '/materials/brass',
        items: [
          { label: 'Brass Sheet', href: '/materials/brass/sheet' },
          { label: 'Brass Tube', href: '/materials/brass/tube' },
          { label: 'Brass Bar', href: '/materials/brass/bar' },
          { label: 'Brass Wire', href: '/materials/brass/wire' },
          { label: 'Brass Coil & Strip', href: '/materials/brass/coil-strip' },
        ],
      },
      {
        heading: 'Bronze',
        href: '/materials/bronze',
        items: [
          { label: 'Bronze Sheet', href: '/materials/bronze/sheet' },
          { label: 'Bronze Tube', href: '/materials/bronze/tube' },
          { label: 'Bronze Bar', href: '/materials/bronze/bar' },
          { label: 'Bronze Wire', href: '/materials/bronze/wire' },
          { label: 'Bronze Strip', href: '/materials/bronze/strip' },
        ],
      },
      {
        heading: 'Cupronickel',
        href: '/materials/cupronickel',
        items: [
          { label: 'Cupronickel Sheet', href: '/materials/cupronickel/sheet' },
          { label: 'Cupronickel Tube', href: '/materials/cupronickel/tube' },
          { label: 'Cupronickel Bar', href: '/materials/cupronickel/bar' },
          { label: 'Cupronickel Wire', href: '/materials/cupronickel/wire' },
        ],
      },
    ],
  },
  {
    label: 'By Grade',
    href: '/grades',
    type: 'mega' as const,
    columns: [
      {
        heading: 'Copper Grades',
        href: '/grades/pure-copper',
        items: [
          { label: 'C10100 — OFE Copper', href: '/grades/pure-copper/c10100' },
          { label: 'C11000 — ETP Copper', href: '/grades/pure-copper/c11000' },
          { label: 'C12200 — DHP Copper', href: '/grades/pure-copper/c12200' },
          { label: 'C14500 — Te-Copper', href: '/grades/pure-copper/c14500' },
          { label: 'View all Copper Grades', href: '/grades/pure-copper' },
        ],
      },
      {
        heading: 'Brass Grades',
        href: '/grades/brass',
        items: [
          { label: 'C26000 — Cartridge Brass', href: '/grades/brass/c26000' },
          { label: 'C36000 — Free-Cutting', href: '/grades/brass/c36000' },
          { label: 'C46400 — Naval Brass', href: '/grades/brass/c46400' },
          { label: 'C28000 — Muntz Metal', href: '/grades/brass/c28000' },
          { label: 'View all Brass Grades', href: '/grades/brass' },
        ],
      },
      {
        heading: 'Bronze Grades',
        href: '/grades/bronze',
        items: [
          { label: 'C51000 — Phosphor Bronze', href: '/grades/bronze/c51000' },
          { label: 'C52100 — Phosphor Bronze', href: '/grades/bronze/c52100' },
          { label: 'C63000 — Al Bronze', href: '/grades/bronze/c63000' },
          { label: 'C65500 — Silicon Bronze', href: '/grades/bronze/c65500' },
          { label: 'View all Bronze Grades', href: '/grades/bronze' },
        ],
      },
    ],
  },
  {
    label: 'Solutions',
    href: '/solutions',
    type: 'dropdown' as const,
    items: [
      { label: 'Marine & Offshore', href: '/solutions/marine' },
      { label: 'Electrical & Power', href: '/solutions/electrical' },
      { label: 'Plumbing & HVAC', href: '/solutions/plumbing-hvac' },
      { label: 'Architecture & Facade', href: '/solutions/architecture' },
      { label: 'Industrial Equipment', href: '/solutions/industrial' },
      { label: 'Renewable Energy', href: '/solutions/renewable-energy' },
    ],
  },
  {
    label: 'Services',
    href: '/services',
    type: 'dropdown' as const,
    items: [
      { label: 'CNC Machining', href: '/services/cnc' },
      { label: 'Sheet Metal Fabrication', href: '/services/sheet-metal' },
      { label: 'Custom Alloy Processing', href: '/services/custom-alloy' },
    ],
  },
  {
    label: 'About',
    href: '/about',
    type: 'link' as const,
  },
];

type NavItem = (typeof NAV_ITEMS)[number];

// ─── Full-Width Mega Menu ────────────────────────────────────────────────────

function MegaMenuPanel({
  item,
  visible,
  onMouseEnter,
  onMouseLeave,
  top,
}: {
  item: Extract<NavItem, { type: 'mega' }>;
  visible: boolean;
  onMouseEnter: () => void;
  onMouseLeave: () => void;
  top: number;
}) {
  return (
    /* Full viewport-width panel anchored below the sticky header */
    <div
      role="region"
      aria-label={`${item.label} menu`}
      onMouseEnter={onMouseEnter}
      onMouseLeave={onMouseLeave}
      className={`
        fixed left-0 right-0 z-40
        transition-all duration-200 ease-out
        ${visible
          ? 'opacity-100 translate-y-0 pointer-events-auto'
          : 'opacity-0 -translate-y-2 pointer-events-none'
        }
      `}
      style={{ top: `${top}px` }}
    >
      {/* Full-width backdrop shadow line */}
      <div className="w-full bg-white border-b border-[#E5E7EB] shadow-[0_12px_32px_rgba(11,53,112,0.12)]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

          {/* Panel header row */}
          <div className="flex items-center justify-between py-3 border-b border-[#E5E7EB]">
            <div className="flex items-center gap-2">
              <span className="w-1 h-4 bg-[#F97C30] rounded-sm inline-block" />
              <span className="text-xs font-semibold text-[#0B3570]">
                Shop {item.label}
              </span>
            </div>
            <Link
              href={item.href}
              className="flex items-center gap-1 text-xs font-semibold text-[#F97C30] hover:text-[#e06b20] transition-colors"
            >
              View all {item.label}
              <ArrowRight className="w-3 h-3" />
            </Link>
          </div>

          {/* Columns */}
          <div
            className="grid py-6 gap-x-6"
            style={{ gridTemplateColumns: `repeat(${item.columns.length}, 1fr)` }}
          >
            {item.columns.map((col) => (
              <div key={col.href} className="flex flex-col gap-2">
                {/* Column heading — links to L2 category */}
                <Link
                  href={col.href}
                  className="text-sm font-semibold text-[#0B3570] hover:text-[#F97C30] transition-colors pb-2 border-b border-[#E5E7EB]"
                >
                  {col.heading}
                </Link>
                {/* Sub-items — L2 product type links */}
                <ul className="flex flex-col gap-1">
                  {col.items.map((sub) => (
                    <li key={sub.href}>
                      <Link
                        href={sub.href}
                        className="text-sm text-[#6B7280] hover:text-[#F97C30] transition-colors leading-relaxed block py-0.5 font-mono"
                      >
                        {sub.label}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>

        </div>
      </div>
    </div>
  );
}

// ─── Simple Dropdown ─────────────────────────────────────────────────────────

function DropdownPanel({
  item,
  visible,
}: {
  item: Extract<NavItem, { type: 'dropdown' }>;
  visible: boolean;
}) {
  return (
    <div
      className={`
        absolute left-1/2 -translate-x-1/2 top-[calc(100%+8px)] w-56 z-40
        transition-all duration-200 ease-out
        ${visible
          ? 'opacity-100 translate-y-0 pointer-events-auto'
          : 'opacity-0 -translate-y-2 pointer-events-none'
        }
      `}
    >
      <div className="bg-white border border-[#E5E7EB] rounded-sm shadow-[0_8px_24px_rgba(11,53,112,0.12)] overflow-hidden py-1">
        {item.items.map((child) => (
          <Link
            key={child.href}
            href={child.href}
            className="flex items-center gap-2 px-4 py-2.5 text-sm text-[#1F2937] hover:bg-[#F2F4F7] hover:text-[#F97C30] transition-colors"
          >
            {child.label}
          </Link>
        ))}
        <div className="border-t border-[#E5E7EB] mt-1 pt-1">
          <Link
            href={item.href}
            className="flex items-center gap-1 px-4 py-2 text-xs font-semibold text-[#F97C30] hover:bg-[#F2F4F7] transition-colors"
          >
            All {item.label}
            <ArrowRight className="w-3 h-3" />
          </Link>
        </div>
      </div>
    </div>
  );
}

// ─── Mobile Accordion Item ───────────────────────────────────────────────────

function MobileAccordion({
  item,
  onClose,
}: {
  item: NavItem;
  onClose: () => void;
}) {
  const [open, setOpen] = useState(false);
  const hasSub = item.type === 'mega' || item.type === 'dropdown';

  if (!hasSub) {
    return (
      <Link
        href={item.href}
        onClick={onClose}
        className="flex items-center justify-between py-3.5 border-b border-white/10 text-sm font-semibold text-white hover:text-[#F4BD5D] transition-colors"
      >
        {item.label}
      </Link>
    );
  }

  // Flatten sub-items for mobile rendering
  const subSections =
    item.type === 'mega'
      ? item.columns.map((col) => ({
          heading: col.heading,
          href: col.href,
          children: col.items,
        }))
      : [{ heading: null, href: null, children: item.items }];

  return (
    <div className="border-b border-white/10">
      <button
        onClick={() => setOpen((v) => !v)}
        className="flex items-center justify-between w-full py-3.5 text-sm font-semibold text-white hover:text-[#F4BD5D] transition-colors"
        aria-expanded={open}
      >
        {item.label}
        <ChevronDown
          className={`w-4 h-4 transition-transform duration-200 ${open ? 'rotate-180' : ''}`}
        />
      </button>

      {/* Animated accordion body */}
      <div
        className={`overflow-hidden transition-all duration-200 ease-out ${
          open ? 'max-h-[800px] opacity-100' : 'max-h-0 opacity-0'
        }`}
      >
        <div className="pb-4 pl-3 flex flex-col gap-3 border-l-2 border-[#F97C30]/40 ml-1 mb-1">
          {subSections.map((section, si) => (
            <div key={si} className="flex flex-col gap-1">
              {section.heading && (
                <Link
                  href={section.href!}
                  onClick={onClose}
                  className="mt-1 text-xs font-semibold text-[#F4BD5D]"
                >
                  {section.heading}
                </Link>
              )}
              {section.children.map((child) => (
                <Link
                  key={child.href}
                  href={child.href}
                  onClick={onClose}
                  className="text-sm text-white/65 hover:text-white transition-colors py-0.5 font-mono"
                >
                  {child.label}
                </Link>
              ))}
            </div>
          ))}
          {/* Link to parent category page */}
          <Link
            href={item.href}
            onClick={onClose}
            className="flex items-center gap-1 text-xs font-semibold text-[#F97C30] mt-1"
          >
            View all {item.label}
            <ArrowRight className="w-3 h-3" />
          </Link>
        </div>
      </div>
    </div>
  );
}

// ─── Main Header ─────────────────────────────────────────────────────────────

export default function Header() {
  const [mobileOpen, setMobileOpen] = useState(false);
  const [activeIndex, setActiveIndex] = useState<number | null>(null);
  const [headerBottom, setHeaderBottom] = useState(60);
  const headerRef = useRef<HTMLElement>(null);
  const closeTimer = useRef<ReturnType<typeof setTimeout> | null>(null);

  // Track header bottom position for mega menu fixed positioning
  useEffect(() => {
    const updateBottom = () => {
      if (headerRef.current) {
        const rect = headerRef.current.getBoundingClientRect();
        setHeaderBottom(rect.bottom);
      }
    };
    // Small delay to ensure layout is complete before first measurement
    const raf = requestAnimationFrame(updateBottom);
    window.addEventListener('resize', updateBottom);
    window.addEventListener('scroll', updateBottom, { passive: true });
    return () => {
      cancelAnimationFrame(raf);
      window.removeEventListener('resize', updateBottom);
      window.removeEventListener('scroll', updateBottom);
    };
  }, []);

  // Lock body scroll when mobile menu is open
  useEffect(() => {
    document.body.style.overflow = mobileOpen ? 'hidden' : '';
    return () => { document.body.style.overflow = ''; };
  }, [mobileOpen]);

  const handleEnter = useCallback((index: number) => {
    if (closeTimer.current) clearTimeout(closeTimer.current);
    setActiveIndex(index);
  }, []);

  const handleLeave = useCallback(() => {
    closeTimer.current = setTimeout(() => setActiveIndex(null), 300);
  }, []);

  const closeMobile = useCallback(() => setMobileOpen(false), []);

  return (
    <>
      {/* ── Main nav bar ─────────────────────────────────────────────── */}
      <header
        ref={headerRef}
        className="sticky top-0 z-50 bg-[#0B3570] shadow-[0_2px_16px_rgba(11,53,112,0.3)]"
      >
        <nav
          className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
          aria-label="Main navigation"
        >
          <div className="flex h-[60px] items-center justify-between gap-8">

            {/* Logo */}
            <Link
              href="/"
              className="flex items-center gap-2.5 flex-shrink-0 hover:opacity-85 transition-opacity"
              aria-label="Linsy Copper — home"
            >
              <div className="w-8 h-8 bg-[#F97C30] rounded-sm flex items-center justify-center font-bold text-white text-base leading-none select-none">
                C
              </div>
              <span className="font-bold text-[17px] text-white tracking-tight hidden sm:inline">
                Linsy<span className="text-[#F4BD5D]">Copper</span>
              </span>
            </Link>

            {/* Desktop nav items — centered */}
            <div className="hidden lg:flex items-center gap-0.5 flex-1 justify-center">
              {NAV_ITEMS.map((item, index) => {
                const hasSub = item.type !== 'link';
                const isActive = activeIndex === index;

                return (
                  <div
                    key={item.href}
                    className="relative"
                    onMouseEnter={() => hasSub && handleEnter(index)}
                    onMouseLeave={() => hasSub && handleLeave()}
                  >
                    {/* Transparent bridge: fills the gap between nav bar bottom and mega panel top */}
                    {item.type === 'mega' && isActive && (
                      <div className="absolute left-0 right-0 top-full h-3 z-50" />
                    )}
                    <Link
                      href={item.href}
                      className={`
                        flex items-center gap-1 px-3.5 py-2 text-sm font-semibold rounded-sm
                        transition-colors duration-150
                        ${isActive
                          ? 'text-[#F4BD5D] bg-white/10'
                          : 'text-white/85 hover:text-white hover:bg-white/8'
                        }
                      `}
                    >
                      {item.label}
                      {hasSub && (
                        <ChevronDown
                          className={`w-3.5 h-3.5 transition-transform duration-200 ${
                            isActive ? 'rotate-180' : ''
                          }`}
                        />
                      )}
                    </Link>

                    {/* Dropdown for Solutions / Services */}
                    {item.type === 'dropdown' && (
                      <DropdownPanel item={item} visible={isActive} />
                    )}
                  </div>
                );
              })}
            </div>

            {/* CTA button + mobile toggle */}
            <div className="flex items-center gap-3 flex-shrink-0">
              <Link
                href="/contact"
                className="hidden lg:inline-flex items-center gap-1.5 px-5 py-2 bg-[#F97C30] text-white text-sm font-semibold rounded-sm
                  hover:bg-[#e06b20] active:bg-[#c85e1b] transition-colors
                  shadow-[0_2px_8px_rgba(249,124,48,0.40)]"
              >
                Request a Quote
              </Link>
              <button
                type="button"
                aria-label={mobileOpen ? 'Close menu' : 'Open menu'}
                aria-expanded={mobileOpen}
                className="lg:hidden p-2 rounded-sm text-white hover:bg-white/10 transition-colors"
                onClick={() => setMobileOpen((v) => !v)}
              >
                {mobileOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
              </button>
            </div>
          </div>
        </nav>

        {/* ── Mobile drawer ──────────────────────────────────────────── */}
        <div
          className={`
            lg:hidden bg-[#0B3570] border-t border-white/10
            overflow-y-auto overscroll-contain
            transition-all duration-300 ease-out
            ${mobileOpen ? 'max-h-[75vh] opacity-100' : 'max-h-0 opacity-0'}
          `}
        >
          <div className="mx-auto max-w-7xl px-4 sm:px-6 py-2 flex flex-col">
            {NAV_ITEMS.map((item) => (
              <MobileAccordion key={item.href} item={item} onClose={closeMobile} />
            ))}
            <div className="py-5">
              <Link
                href="/contact"
                onClick={closeMobile}
                className="block w-full text-center py-3 bg-[#F97C30] text-white text-sm font-semibold rounded-sm
                  hover:bg-[#e06b20] transition-colors shadow-[0_2px_8px_rgba(249,124,48,0.35)]"
              >
                Request a Quote
              </Link>
            </div>
          </div>
        </div>
      </header>

      {/* ── Full-width Mega Menu panels (rendered outside sticky header) ── */}
      {NAV_ITEMS.map((item, index) =>
        item.type === 'mega' ? (
          <MegaMenuPanel
            key={item.href}
            item={item}
            visible={activeIndex === index}
            onMouseEnter={() => handleEnter(index)}
            onMouseLeave={handleLeave}
            top={headerBottom}
          />
        ) : null
      )}

      {/* Mega menu backdrop overlay */}
      <div
        aria-hidden="true"
        className={`
          fixed inset-0 z-30 bg-black/20 backdrop-blur-[1px]
          transition-opacity duration-200
          ${activeIndex !== null && NAV_ITEMS[activeIndex]?.type === 'mega'
            ? 'opacity-100 pointer-events-auto'
            : 'opacity-0 pointer-events-none'
          }
        `}
        onMouseEnter={handleLeave}
      />
    </>
  );
}
