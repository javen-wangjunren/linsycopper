<?php
/**
 * Product Sticky Navigation (Scroll Spy)
 * 
 * Logic:
 * 1. Sticky Positioning: Stays at the top when scrolling past hero.
 * 2. Scroll Spy: Uses IntersectionObserver (via Alpine.js) to highlight active section.
 * 3. Smooth Scroll: Native CSS scroll-behavior or JS fallback.
 * 
 * @package GeneratePress_Child
 */
?>

<!-- 
	Copper UI: Sticky Nav 
	z-index: 40 (Below header which is usually 50)
-->
<div 
	x-data="{ 
		activeTab: 'description', 
		tabs: [
			{ id: 'description', label: 'Description' },
			{ id: 'applications', label: 'Applications' },
			{ id: 'specifications', label: 'Specifications' },
			{ id: 'manufacturing', label: 'Manufacturing' }
		],
		initObserver() {
			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						this.activeTab = entry.target.id;
					}
				});
			}, {
				threshold: 0.3,
				rootMargin: '-100px 0px -66% 0px' 
			});

			this.tabs.forEach(tab => {
				const el = document.getElementById(tab.id);
				if (el) observer.observe(el);
			});
		},
		scrollTo(id) {
			const el = document.getElementById(id);
			if (el) {
				const offset = 80; // Sticky header height
				const top = el.getBoundingClientRect().top + window.pageYOffset - offset;
				window.scrollTo({ top: top, behavior: 'smooth' });
				this.activeTab = id;
			}
		}
	}" 
	x-init="initObserver()"
	class="sticky top-0 z-40 bg-white border-b border-border shadow-sm w-full"
>
	<div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
		<nav class="flex space-x-1 overflow-x-auto no-scrollbar" aria-label="Tabs">
			<template x-for="tab in tabs" :key="tab.id">
				<button
					type="button"
					@click="scrollTo(tab.id)"
					class="nav_tab"
					:class="activeTab === tab.id ? 'nav_tab--active' : ''"
					x-text="tab.label"
				>
				</button>
			</template>
		</nav>
	</div>
</div>
