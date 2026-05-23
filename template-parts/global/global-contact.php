<?php
/**
 * Render: Global Contact Section (Full Module)
 * ==========================================================================
 * Location: template-parts/global/global-contact.php
 * 
 * Logic:
 * 1. Fetches global data from Options Page ('option').
 * 2. Renders layout: Left (Info) + Right (Consult Form Atom).
 * 3. Uses 'form-consult' atom for the form part.
 * 
 * @package GeneratePress_Child
 */

// 1. Fetch Global Data
$title     = get_field( 'global_contact_title', 'option' );
$desc      = get_field( 'global_contact_desc', 'option' );
$bg_id     = get_field( 'global_contact_bg', 'option' );
$strengths = get_field( 'global_contact_strengths', 'option' );

// 2. Fallback Defaults (Safe Mode)
if ( empty( $title ) ) $title = 'Consult Our Experts';
if ( empty( $desc ) ) $desc   = 'Give us a call at <a href="tel:3462305191" class="font-bold text-white underline transition hover:text-[#F97C30]">346.230.5191</a> or leave us a message below.';
?>

<!-- Copper UI: Vertical Rhythm -->
<section id="contact-form" class="relative overflow-hidden bg-[#0B3570] font-sans">
    
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <?php if ( $bg_id ) : ?>
            <?php echo wp_get_attachment_image( $bg_id, 'full', false, array( 'class' => 'h-full w-full object-cover opacity-30 grayscale' ) ); ?>
        <?php else : ?>
            <img src="https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&q=80&w=1600" alt="Industrial Background" class="h-full w-full object-cover opacity-30 grayscale">
        <?php endif; ?>
        
        <!-- Blue Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#0B3570] via-[#0B3570]/90 to-transparent"></div>
    </div>

    <div class="relative z-10 mx-auto flex max-w-[1280px] flex-col items-center gap-16 px-6 py-20 lg:flex-row">
        
        <!-- Left Content -->
        <div class="text-white lg:w-5/12">
            <!-- Heading -->
            <h2 class="mb-6 text-4xl font-bold uppercase leading-none tracking-tight md:text-5xl text-heading text-white">
                <?php echo esc_html( $title ); ?>
            </h2>
            
            <!-- Description -->
            <div class="mb-10 text-lg leading-relaxed text-blue-100/80">
                <?php echo wp_kses_post( $desc ); ?>
            </div>

            <!-- Strengths Grid -->
            <?php if ( ! empty( $strengths ) ) : ?>
            <div class="grid grid-cols-2 gap-y-8 gap-x-12 border-t border-white/10 pt-10">
                <?php foreach ( $strengths as $item ) : ?>
                <div>
                    <!-- Copper UI: Font Logic (Mono for Data) -->
                    <div class="font-mono text-2xl font-bold text-[#F4BD5D]">
                        <?php echo esc_html( $item['strength_value'] ); ?>
                    </div>
                    <!-- Copper UI: Micro Typography -->
                    <div class="mt-1 text-[10px] font-bold uppercase tracking-widest opacity-60">
                        <?php echo esc_html( $item['strength_label'] ); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: Contact Form -->
        <!-- Copper UI: Micro-Radius (rounded-sm) & Interaction Border -->
        <div class="w-full rounded-sm border-t-4 border-[#F97C30] bg-white p-8 shadow-2xl md:p-10 lg:w-7/12">
            
            <!-- Render the Form Atom -->
            <?php get_template_part( 'template-parts/components/form' ); ?>
            
        </div>

    </div>
</section>
