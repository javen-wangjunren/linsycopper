'use client';

import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Upload, X, CheckCircle2 } from 'lucide-react';

export default function ContactFormSection() {
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
    if (file) setFormData({ ...formData, attachment: file });
  };

  const handleRemoveFile = () => {
    setFormData({ ...formData, attachment: null });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
  };

  const inputClass = 'w-full px-4 py-2.5 border border-[#E5E7EB] rounded bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition';

  return (
    <section className="bg-white py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid gap-12 lg:grid-cols-3">

          {/* Form — 2 columns */}
          <div className="lg:col-span-2">
            <form onSubmit={handleSubmit} className="space-y-6">
              <div>
                <h2 className="text-3xl font-bold text-[#1F2937] mb-2">Send us Your Inquiry</h2>
                <p className="text-[#6B7280]">Fill out the form below and our sales team will get back to you within 24 hours.</p>
              </div>

              {/* Name & Company */}
              <div className="grid gap-6 md:grid-cols-2">
                <div>
                  <label htmlFor="name" className="block text-sm font-semibold text-[#1F2937] mb-2">
                    Name <span className="text-[#F97C30]">*</span>
                  </label>
                  <input id="name" type="text" required placeholder="John Smith"
                    value={formData.name} onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className={inputClass} />
                </div>
                <div>
                  <label htmlFor="company" className="block text-sm font-semibold text-[#1F2937] mb-2">
                    Company <span className="text-[#F97C30]">*</span>
                  </label>
                  <input id="company" type="text" required placeholder="Your Company Inc."
                    value={formData.company} onChange={(e) => setFormData({ ...formData, company: e.target.value })}
                    className={inputClass} />
                </div>
              </div>

              {/* Phone & Country */}
              <div className="grid gap-6 md:grid-cols-2">
                <div>
                  <label htmlFor="phone" className="block text-sm font-semibold text-[#1F2937] mb-2">
                    Phone Number <span className="text-[#F97C30]">*</span>
                  </label>
                  <input id="phone" type="tel" required placeholder="+1 (555) 123-4567"
                    value={formData.phone} onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                    className={inputClass} />
                </div>
                <div>
                  <label htmlFor="country" className="block text-sm font-semibold text-[#1F2937] mb-2">
                    Country <span className="text-[#F97C30]">*</span>
                  </label>
                  <input id="country" type="text" required placeholder="United States"
                    value={formData.country} onChange={(e) => setFormData({ ...formData, country: e.target.value })}
                    className={inputClass} />
                </div>
              </div>

              {/* Message */}
              <div>
                <label htmlFor="message" className="block text-sm font-semibold text-[#1F2937] mb-2">
                  Message <span className="text-[#F97C30]">*</span>
                </label>
                <textarea id="message" required rows={4}
                  placeholder="Please specify your requirements, quantity, delivery timeline, or any special requests..."
                  value={formData.message} onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                  className={`${inputClass} resize-none`} />
              </div>

              {/* File Upload */}
              <div>
                <label className="block text-sm font-semibold text-[#1F2937] mb-2">
                  Attachment <span className="text-[#6B7280] font-normal">(Optional)</span>
                </label>
                <label className="w-full px-4 py-3 border-2 border-dashed border-[#F97C30] rounded bg-[#F97C30]/5 cursor-pointer hover:bg-[#F97C30]/10 transition flex items-center justify-center gap-2">
                  <Upload className="w-4 h-4 text-[#F97C30] shrink-0" />
                  <span className="text-sm text-[#6B7280] truncate">
                    {formData.attachment ? formData.attachment.name : 'Click to upload file'}
                  </span>
                  {formData.attachment && (
                    <button type="button" onClick={(e) => { e.preventDefault(); handleRemoveFile(); }}
                      className="ml-auto shrink-0 p-1 rounded hover:bg-red-100 text-red-500 transition">
                      <X className="w-3.5 h-3.5" />
                    </button>
                  )}
                  <input type="file" onChange={handleFileChange} className="hidden"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" />
                </label>
              </div>

              <Button type="submit" size="lg"
                className="bg-[#0B3570] hover:bg-[#0B3570]/90 text-white font-semibold px-8 w-full md:w-auto">
                SUBMIT REQUEST
              </Button>
            </form>
          </div>

          {/* Sidebar — Trust Elements */}
          <div className="lg:col-span-1">
            <div className="sticky top-8 space-y-6">
              <div className="rounded border border-[#E5E7EB] bg-[#F8F9FA] p-6">
                <h3 className="font-bold text-[#1F2937] mb-2">Fast Response</h3>
                <p className="text-sm text-[#6B7280]">
                  Our sales team responds within <span className="font-semibold text-[#0B3570]">24 hours</span> to all inquiries.
                </p>
              </div>
              <div className="rounded border border-[#E5E7EB] bg-white p-6 space-y-4">
                <h3 className="font-bold text-[#1F2937]">Our Commitments</h3>
                {['Full material traceability', 'Mill Test Reports included', 'ISO 9001 certified', 'Competitive pricing'].map((item) => (
                  <div key={item} className="flex items-start gap-3">
                    <CheckCircle2 className="w-5 h-5 text-[#F97C30] shrink-0 mt-0.5" />
                    <span className="text-sm text-[#6B7280]">{item}</span>
                  </div>
                ))}
              </div>
              <div className="rounded border border-[#E5E7EB] bg-white p-6">
                <div className="mb-3 flex gap-1">
                  {[...Array(5)].map((_, i) => (
                    <span key={i} className="text-[#F97C30]">★</span>
                  ))}
                </div>
                <p className="text-sm text-[#6B7280] italic mb-3">
                  &quot;Reliable supplier with excellent customer service. Highly recommended for bulk copper orders.&quot;
                </p>
                <div className="text-xs font-semibold text-[#1F2937]">David Morrison</div>
                <div className="text-xs text-[#6B7280]">AeroTech Manufacturing</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  );
}
