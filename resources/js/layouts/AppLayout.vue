<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// Dark Mode State
const isDark = ref(false);

onMounted(() => {
    const saved = localStorage.getItem("theme");

    if (saved) {
        isDark.value = saved === "dark";
    } else {
        isDark.value = window.matchMedia("(prefers-color-scheme: dark)").matches;
    }

    applyTheme();
});

const toggleTheme = () => {
    isDark.value = !isDark.value;
    localStorage.setItem("theme", isDark.value ? "dark" : "light");
    applyTheme();
};

const applyTheme = () => {
    const html = document.documentElement;
    if (isDark.value) {
        html.classList.add("dark");
    } else {
        html.classList.remove("dark");
    }
};
</script>

<template>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <!-- Sidebar -->
    <aside class="w-72 bg-white dark:bg-gray-800 shadow-sm border-r border-gray-200 dark:border-gray-700 transition-colors duration-300">
      <div class="flex flex-col h-full">
        
        <!-- Logo/Brand -->
        <div class="p-8 pb-6 border-b border-gray-100 dark:border-gray-700">
          <h2 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-3">
            <span class="text-[#FF385C]">✦</span>
            AirPricing
          </h2>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dashboard</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-6">
          <ul class="space-y-2">
            <li>
              <Link 
                href="/listings" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-[#FF385C] dark:hover:text-[#FF385C] transition-all duration-200 group font-medium"
              >
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#FF385C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Listings
              </Link>
            </li>

            <li>
              <Link 
                href="/pricing-rules" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-[#FF385C] dark:hover:text-[#FF385C] transition-all duration-200 group font-medium"
              >
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#FF385C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pricing Rules
              </Link>
            </li>

            <li>
              <Link 
                href="/calendar-prices" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-[#FF385C] dark:hover:text-[#FF385C] transition-all duration-200 group font-medium"
              >
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#FF385C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Calendar Prices
              </Link>
            </li>
          </ul>
        </nav>

        <!-- Dark Mode Toggle -->
        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
          <button
            @click="toggleTheme"
            class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium text-gray-700 dark:text-gray-200 shadow-sm"
          >
            <span class="text-lg">{{ isDark ? "☀️" : "🌙" }}</span>
            <span>{{ isDark ? "Light Mode" : "Dark Mode" }}</span>
          </button>
        </div>

      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
      <div class="max-w-7xl mx-auto p-8">
        <slot />
      </div>
    </main>

  </div>
</template>