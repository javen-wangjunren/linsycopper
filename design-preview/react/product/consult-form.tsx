'use client';

import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Upload, X } from 'lucide-react';

interface ConsultFormProps {
  productName?: string;
  productCode?: string;
}

export default function ConsultForm({
  productName = 'C11000 Pure Copper Sheet',
  productCode = 'C11000',
}: ConsultFormProps) {
  const [formData, setFormData] = useState({
    name: '',
    company: '',
    phone: '',
    country: '',
    message: '',
    attachment: null as File | null,
  });

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setFormData({ ...formData, attachment: file });
    }
  };

  const handleRemoveFile = () => {
    setFormData({ ...formData, attachment: null });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    console.log('[v0] Form submitted:', formData);
  };

  return (
    <section className="relative pb-32">
      {/* Dark Background Banner with overlay pattern */}
      <div className="absolute inset-0 top-1/3 bg-[#0B3570] h-2/3 overflow-hidden">
        {/* Diagonal striped pattern overlay */}
        <div className="absolute inset-0 opacity-10">
          <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <pattern id="diagonal-stripes" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse" patternTransform="rotate(-45)">
                <line x1="0" y1="0" x2="0" y2="20" stroke="white" strokeWidth="10" />
              </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#diagonal-stripes)" />
          </svg>
        </div>
      </div>

      {/* Content Container */}
      <div className="mx-auto max-w-6xl px-4 relative z-10">
        {/* Form Card - Overlapping Effect */}
        <div className="mx-auto max-w-4xl -mb-16">
          <form
            onSubmit={handleSubmit}
            className="bg-white rounded-lg shadow-2xl p-8 md:p-10 relative"
          >
            {/* Header */}
            <div className="mb-8">
              <h2 className="text-3xl font-bold text-[#0B3570] mb-2">
                Get Free Quote Now
              </h2>
              <p className="text-muted-foreground">
                Leave your contact information, we will contact you ASAP!
              </p>
            </div>

            {/* Form Grid */}
            <div className="grid gap-6 md:grid-cols-2 mb-6">
              {/* Name */}
              <div className="flex flex-col">
                <label htmlFor="name" className="text-sm font-semibold text-foreground mb-2">
                  Name <span className="text-[#F97C30]">*</span>
                </label>
                <input
                  id="name"
                  type="text"
                  required
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="px-4 py-2.5 border border-border rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition"
                  placeholder="John Smith"
                />
              </div>

              {/* Company */}
              <div className="flex flex-col">
                <label htmlFor="company" className="text-sm font-semibold text-foreground mb-2">
                  Company <span className="text-[#F97C30]">*</span>
                </label>
                <input
                  id="company"
                  type="text"
                  required
                  value={formData.company}
                  onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                  className="px-4 py-2.5 border border-border rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition"
                  placeholder="Your Company Inc."
                />
              </div>

              {/* Phone Number */}
              <div className="flex flex-col">
                <label htmlFor="phone" className="text-sm font-semibold text-foreground mb-2">
                  Phone Number <span className="text-[#F97C30]">*</span>
                </label>
                <input
                  id="phone"
                  type="tel"
                  required
                  value={formData.phone}
                  onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                  className="px-4 py-2.5 border border-border rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition"
                  placeholder="+1 (555) 123-4567"
                />
              </div>

              {/* Country */}
              <div className="flex flex-col">
                <label htmlFor="country" className="text-sm font-semibold text-foreground mb-2">
                  Country <span className="text-[#F97C30]">*</span>
                </label>
                <input
                  id="country"
                  type="text"
                  required
                  value={formData.country}
                  onChange={(e) => setFormData({ ...formData, country: e.target.value })}
                  className="px-4 py-2.5 border border-border rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition"
                  placeholder="United States"
                />
              </div>
            </div>

            {/* Message */}
            <div className="mb-6 flex flex-col">
              <label htmlFor="message" className="text-sm font-semibold text-foreground mb-2">
                Message <span className="text-[#F97C30]">*</span>
              </label>
              <textarea
                id="message"
                required
                rows={4}
                value={formData.message}
                onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                className="px-4 py-2.5 border border-border rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition resize-none"
                placeholder="Please specify your requirements, quantity, delivery timeline, or any special requests..."
              />
            </div>

            {/* File Upload */}
            <div className="mb-8 flex flex-col">
              <label className="text-sm font-semibold text-foreground mb-2">
                Attachment <span className="text-muted-foreground">(Optional)</span>
              </label>
              <div className="flex items-center gap-3">
                <label className="flex-1 px-4 py-2.5 border-2 border-dashed border-[#F97C30] rounded bg-[#F97C30]/5 cursor-pointer hover:bg-[#F97C30]/10 transition flex items-center justify-center gap-2">
                  <Upload className="w-4 h-4 text-[#F97C30]" />
                  <span className="text-sm text-muted-foreground">
                    {formData.attachment ? formData.attachment.name : 'Click to upload file'}
                  </span>
                  <input
                    type="file"
                    onChange={handleFileChange}
                    className="hidden"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png"
                  />
                </label>
                {formData.attachment && (
                  <button
                    type="button"
                    onClick={handleRemoveFile}
                    className="p-2 rounded bg-red-100 text-red-600 hover:bg-red-200 transition"
                  >
                    <X className="w-4 h-4" />
                  </button>
                )}
              </div>
            </div>

            {/* Submit Button */}
            <Button
              type="submit"
              size="lg"
              className="bg-[#0B3570] hover:bg-[#0B3570]/90 text-white font-semibold px-8"
            >
              SUBMIT REQUEST
            </Button>
          </form>
        </div>
      </div>
    </section>
  );
}
