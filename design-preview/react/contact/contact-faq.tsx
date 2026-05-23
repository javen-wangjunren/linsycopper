import { ChevronDown } from 'lucide-react';
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from '@/components/ui/accordion';

const faqs = [
  {
    question: 'What is your minimum order quantity (MOQ)?',
    answer: 'Our standard MOQ is 500 pounds for most grades. For high-volume customers, we offer flexible terms. Contact our sales team for custom requirements and volume discounts.',
  },
  {
    question: 'What are your typical lead times?',
    answer: 'Stock items ship within 2-3 business days. Custom cuts and machining typically require 5-10 business days depending on specification complexity. Rush orders available upon request.',
  },
  {
    question: 'Do you provide Mill Test Reports (MTR)?',
    answer: 'Yes, every shipment includes full material certification and Mill Test Reports. Complete chemical composition, mechanical properties, and traceability data provided with each order.',
  },
  {
    question: 'Which payment methods do you accept?',
    answer: 'We accept wire transfer, credit cards, ACH transfers, and letters of credit for qualified customers. Payment terms available for established accounts. Contact sales for discussion.',
  },
  {
    question: 'Do you ship internationally?',
    answer: 'Yes, we ship to 50+ countries worldwide. International orders typically require 2-3 weeks including customs clearance. We handle all export documentation and can arrange freight insurance.',
  },
  {
    question: 'What quality certifications do you hold?',
    answer: 'We are ISO 9001:2015 certified, RoHS compliant, and meet ASTM B152, B194, and other international standards. All materials come with full traceability and compliance documentation.',
  },
];

export default function ContactFAQ() {
  return (
    <section className="bg-[#F8F9FA] py-16 md:py-24">
      <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div className="mb-12 text-center">
          <div className="mb-3 inline-block rounded bg-[#0B3570]/10 px-3 py-1 font-mono text-xs font-semibold uppercase tracking-wider text-[#0B3570]">
            FAQ
          </div>
          <h2 className="text-balance text-3xl font-bold tracking-tight text-[#1F2937] md:text-4xl">
            Frequently Asked Questions
          </h2>
          <p className="mx-auto mt-3 max-w-2xl text-pretty text-[#6B7280]">
            Find answers to common questions about our products, services, and ordering process
          </p>
        </div>

        {/* Accordion */}
        <div className="rounded border border-[#E5E7EB] bg-white">
          <Accordion type="single" collapsible className="w-full">
            {faqs.map((faq, index) => (
              <AccordionItem
                key={index}
                value={`item-${index}`}
                className="border-b border-[#E5E7EB] last:border-b-0 px-6 py-4"
              >
                <AccordionTrigger className="text-left font-semibold text-[#1F2937] hover:text-[#0B3570] transition-colors">
                  {faq.question}
                </AccordionTrigger>
                <AccordionContent className="pt-4 text-[#6B7280] leading-relaxed">
                  {faq.answer}
                </AccordionContent>
              </AccordionItem>
            ))}
          </Accordion>
        </div>
      </div>
    </section>
  );
}
