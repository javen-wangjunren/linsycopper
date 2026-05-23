import ProductHero from '@/components/product/product-hero';
import ProductTabs from '@/components/product/product-tabs';
import ProductDescription from '@/components/product/product-description';
import Applications from '@/components/product/applications';
import Specifications from '@/components/product/specifications';
import TrustGallery from '@/components/product/trust-gallery';
import ConsultForm from '@/components/product/consult-form';
import Breadcrumb from '@/components/breadcrumb';

export default function ProductPage({ params }: { params: { slug: string } }) {
  const productCode = params.slug.toUpperCase();
  
  return (
    <main className="bg-white">
      <Breadcrumb 
        items={[
          { label: 'Home', href: '/' },
          { label: 'Pure Copper Grade', href: '/products' },
          { label: productCode },
        ]}
      />
      <ProductHero />
      <ProductTabs />
      <ProductDescription />
      <Applications />
      <Specifications />
      <TrustGallery />
      <ConsultForm />
    </main>
  );
}

export function generateMetadata() {
  return {
    title: 'C11000 Pure Copper Sheet - Premium Copper Materials',
    description: 'High conductivity C11000 (ETP) copper sheet. ASTM B152 certified. Available in custom sizes with full MTR documentation.',
  };
}
