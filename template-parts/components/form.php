<?php
/**
 * Component: Consult Form (Atom)
 * ==========================================================================
 * Location: template-parts/components/form.php
 * 
 * Logic:
 * - Pure form component (Inputs + Submit Logic).
 * - NO external layout containers (Sections/Padding).
 * - Uses Alpine.js for state management.
 * 
 * @package GeneratePress_Child
 */
?>

<!-- Turnstile Callback (Global) -->
<script>
	if (typeof turnstileCallback === 'undefined') {
		function turnstileCallback(token) {
			document.dispatchEvent(new CustomEvent('turnstile-verified', { detail: { token: token } }));
		}
	}
</script>

<form
    x-data="{
        formData: {
            name: '',
            company: '',
            phone: '',
            country: '',
            message: '',
            website_url: '', // Honeypot
            'cf-turnstile-response': ''
        },
        attachment: null,
        fileName: '',
        loading: false,
        errorMessage: '',
        
        init() {
            document.addEventListener('turnstile-verified', (e) => {
                this.formData['cf-turnstile-response'] = e.detail.token;
                this.errorMessage = '';
            });
        },
        
        handleFile(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    this.errorMessage = 'File is too large. Max size is 5MB.';
                    event.target.value = '';
                    return;
                }
                this.attachment = file;
                this.fileName = file.name;
                this.errorMessage = '';
            }
        },
        
        removeFile() {
            this.attachment = null;
            this.fileName = '';
            this.$refs.fileInput.value = '';
        },

        async submitForm() {
            if (this.loading) return;
            
            // Validation
            if (!this.formData.name || !this.formData.company || !this.formData.phone || !this.formData.country || !this.formData.message) {
                this.errorMessage = 'Please fill in all required fields.';
                return;
            }
            if (this.formData.website_url) return; // Honeypot
            if (!this.formData['cf-turnstile-response']) {
                this.errorMessage = 'Please complete the security check.';
                return;
            }

            this.loading = true;
            this.errorMessage = '';

            const data = new FormData();
            for (const key in this.formData) {
                data.append(key, this.formData[key]);
            }
            if (this.attachment) data.append('attachment', this.attachment);
            data.append('_wpnonce', '<?php echo wp_create_nonce( 'consult_nonce' ); ?>');

            try {
                const response = await fetch('/wp-json/linsy/v1/consult', {
                    method: 'POST',
                    body: data
                });
                const result = await response.json();
                if (response.ok) {
                    window.location.href = '/thank-you';
                } else {
                    throw new Error(result.message || 'Submission failed.');
                }
            } catch (error) {
                console.error(error);
                this.errorMessage = error.message || 'Something went wrong.';
            } finally {
                this.loading = false;
            }
        }
    }"
    @submit.prevent="submitForm"
    class="relative"
>
    <!-- Error Message -->
    <div x-show="errorMessage" x-transition class="mb-6 p-4 bg-red-50 text-red-600 rounded-sm text-sm border border-red-200">
        <span x-text="errorMessage"></span>
    </div>

    <!-- Form Fields Grid -->
    <div class="grid gap-6 md:grid-cols-2 mb-6">
        
        <!-- Field: Name -->
        <div class="flex flex-col">
            <label for="name" class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
                Name <span class="text-[#F97C30]">*</span>
            </label>
            <input
                id="name"
                type="text"
                x-model="formData.name"
                required
                class="px-4 py-3 border border-gray-200 rounded-sm bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition w-full text-sm placeholder:text-gray-400"
                placeholder="John Smith"
            />
        </div>

        <!-- Field: Company -->
        <div class="flex flex-col">
            <label for="company" class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
                Company <span class="text-[#F97C30]">*</span>
            </label>
            <input
                id="company"
                type="text"
                x-model="formData.company"
                required
                class="px-4 py-3 border border-gray-200 rounded-sm bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition w-full text-sm placeholder:text-gray-400"
                placeholder="Your Company Inc."
            />
        </div>

        <!-- Field: Phone -->
        <div class="flex flex-col">
            <label for="phone" class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
                Phone <span class="text-[#F97C30]">*</span>
            </label>
            <input
                id="phone"
                type="tel"
                x-model="formData.phone"
                required
                class="px-4 py-3 border border-gray-200 rounded-sm bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition w-full text-sm placeholder:text-gray-400"
                placeholder="+1 (555) 123-4567"
            />
        </div>

        <!-- Field: Country -->
        <div class="flex flex-col">
            <label for="country" class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
                Country <span class="text-[#F97C30]">*</span>
            </label>
            <input
                id="country"
                type="text"
                x-model="formData.country"
                required
                class="px-4 py-3 border border-gray-200 rounded-sm bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition w-full text-sm placeholder:text-gray-400"
                placeholder="United States"
            />
        </div>

        <!-- Honeypot -->
        <div class="hidden" aria-hidden="true">
            <input type="text" x-model="formData.website_url" tabindex="-1" autocomplete="off">
        </div>
    </div>

    <!-- Field: Message -->
    <div class="mb-6 flex flex-col">
        <label for="message" class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
            Message <span class="text-[#F97C30]">*</span>
        </label>
        <textarea
            id="message"
            rows="4"
            x-model="formData.message"
            required
            class="px-4 py-3 border border-gray-200 rounded-sm bg-white focus:border-[#F97C30] focus:ring-1 focus:ring-[#F97C30] outline-none transition resize-none w-full text-sm placeholder:text-gray-400"
            placeholder="Requirements, quantity, delivery timeline..."
        ></textarea>
    </div>

    <!-- Field: File Upload -->
    <div class="mb-8 flex flex-col">
        <label class="text-xs font-bold uppercase tracking-wider text-[#1F2937] mb-2">
            Attachment <span class="text-[#6B7280] normal-case font-normal">(Optional)</span>
        </label>
        <div class="flex items-center gap-3">
            <label class="flex-1 px-4 py-3 border border-dashed border-[#F97C30] rounded-sm bg-[#F97C30]/5 cursor-pointer hover:bg-[#F97C30]/10 transition flex items-center justify-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-[#F97C30] group-hover:scale-110 transition-transform"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                <span class="text-xs font-bold uppercase tracking-wide text-[#0B3570]" x-text="fileName ? fileName : 'Click to upload file'"></span>
                <input type="file" x-ref="fileInput" @change="handleFile" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" />
            </label>
            
            <template x-if="attachment">
                <button type="button" @click="removeFile" class="p-3 rounded-sm bg-red-50 text-red-500 hover:bg-red-100 transition border border-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M18 6 6 18"/><path d="m6 6 18 18"/></svg>
                </button>
            </template>
        </div>
    </div>

    <!-- Turnstile -->
    <div class="mb-6">
        <div class="cf-turnstile" data-sitekey="<?php echo esc_attr( defined( 'TURNSTILE_SITE_KEY' ) ? TURNSTILE_SITE_KEY : '' ); ?>" data-callback="turnstileCallback"></div>
    </div>
    
    <!-- Submit Button -->
    <button
        type="submit"
        :disabled="loading"
        class="lc-btn-primary lc-contact-submit w-full text-sm uppercase px-8 py-4 rounded-sm transition-all hover:-translate-y-0.5 shadow-md flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none"
    >
        <span x-show="!loading">Submit Request</span>
        <span x-show="loading" class="flex items-center gap-2">
            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            Processing...
        </span>
    </button>
</form>
