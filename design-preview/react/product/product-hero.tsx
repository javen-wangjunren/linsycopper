'use client';

import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Download, ZoomIn } from 'lucide-react';

interface ProductHeroProps {
  productName: string;
  productCode: string;
  tags?: string[];
  quickSpecs?: { label: string; value: string }[];
  images?: string[];
}

export default function ProductHero({
  productName = 'C11000 Pure Copper Sheet',
  productCode = 'C11000',
  tags = ['IN STOCK', 'ASTM COMPLIANT', 'CUSTOMIZABLE'],
  quickSpecs = [
    { label: 'Purity', value: '>99.9% Cu' },
    { label: 'Conductivity', value: '101% IACS' },
    { label: 'Temper', value: 'H00-H04' },
  ],
  images = [],
}: ProductHeroProps) {
  const [selectedImage, setSelectedImage] = useState(0);
  const [isZoomed, setIsZoomed] = useState(false);

  const placeholderImages = images.length > 0 ? images : [
    '/placeholder-copper-1.jpg',
    '/placeholder-copper-2.jpg',
    '/placeholder-copper-3.jpg',
    '/placeholder-copper-4.jpg',
  ];

  return (
    <section className="bg-white border-b border-border">
      <div className="mx-auto max-w-7xl px-4 py-12 md:py-16">
        <div className="grid gap-8 md:grid-cols-2 lg:gap-12">
          {/* Left: Image Gallery */}
          <div className="flex gap-4">
            {/* Thumbnail Column */}
            <div className="flex flex-col gap-2">
              {placeholderImages.map((img, idx) => (
                <button
                  key={idx}
                  onClick={() => setSelectedImage(idx)}
                  className={`w-20 h-20 rounded overflow-hidden border-2 transition-all flex-shrink-0 ${
                    selectedImage === idx
                      ? 'border-[#F97C30] ring-2 ring-[#F97C30]/20'
                      : 'border-border hover:border-[#F97C30]/50'
                  }`}
                >
                  <div className="w-full h-full bg-gradient-to-br from-[#C87533]/10 to-[#B87333]/20 flex items-center justify-center">
                    <span className="font-mono text-xs text-muted-foreground">{idx + 1}</span>
                  </div>
                </button>
              ))}
            </div>

            {/* Main Image */}
            <div 
              className="relative flex-1 aspect-square overflow-hidden rounded bg-muted cursor-zoom-in"
              onClick={() => setIsZoomed(!isZoomed)}
            >
              <div className="absolute inset-0 bg-gradient-to-br from-[#C87533]/20 to-[#B87333]/40 flex items-center justify-center">
                <span className="font-mono text-6xl font-bold text-white/30">{productCode}</span>
              </div>
              <button className="absolute top-4 right-4 p-2 rounded bg-white/90 hover:bg-white transition-colors">
                <ZoomIn className="w-5 h-5 text-[#0B3570]" />
              </button>
            </div>
          </div>

          {/* Right: Product Info */}
          <div className="flex flex-col space-y-6">
            {/* Title */}
            <div>
              <h1 className="text-3xl font-bold text-foreground md:text-4xl">
                {productName}
              </h1>
            </div>

            {/* Quick Specs */}
            <div className="grid grid-cols-3 gap-4 p-4 rounded border border-border bg-muted/50">
              {quickSpecs.map((spec, idx) => (
                <div key={idx} className="text-center">
                  <div className="font-mono text-xl font-bold text-[#0B3570]">
                    {spec.value}
                  </div>
                  <div className="mt-1 text-xs text-muted-foreground uppercase tracking-wide">
                    {spec.label}
                  </div>
                </div>
              ))}
            </div>

            {/* Description */}
            <p className="text-muted-foreground leading-relaxed">
              High conductivity copper sheet manufactured to ASTM B152 standards. Ideal for electrical 
              applications, heat exchangers, and architectural projects. Available in various thicknesses 
              and custom sizes.
            </p>

            {/* CTA Buttons */}
            <div className="flex flex-col gap-3 sm:flex-row">
              <Button 
                size="lg" 
                className="flex-1 bg-[#F97C30] hover:bg-[#F97C30]/90 text-white font-semibold"
              >
                GET A QUOTE
              </Button>
              <Button 
                size="lg" 
                variant="outline"
                className="flex-1 border-[#0B3570] text-[#0B3570] hover:bg-[#0B3570] hover:text-white font-semibold bg-transparent"
              >
                <Download className="mr-2 h-4 w-4" />
                DOWNLOAD DATASHEET
              </Button>
            </div>

            {/* Additional Info */}
            <div className="pt-4 border-t border-border space-y-2 text-sm">
              <div className="flex justify-between">
                <span className="text-muted-foreground">Lead Time:</span>
                <span className="font-semibold text-foreground">3-5 Business Days</span>
              </div>
              <div className="flex justify-between">
                <span className="text-muted-foreground">Minimum Order:</span>
                <span className="font-semibold text-foreground">25 lbs</span>
              </div>
              <div className="flex justify-between">
                <span className="text-muted-foreground">Custom Cutting:</span>
                <span className="font-semibold text-[#F97C30]">Available</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
