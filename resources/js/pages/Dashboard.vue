<script setup>
import { Link, Head } from "@inertiajs/vue3";
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

import { 
  HomeIcon, 
  TagIcon, 
  CalendarIcon,
  ChartBarIcon,
  ArrowTrendingUpIcon,
  CurrencyDollarIcon,
  SparklesIcon
} from "@heroicons/vue/24/outline";

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      listings_count: 0,
      active_rules: 0,
      calendar_prices: 0
    })
  },
});

// Format large numbers with commas
const formatNumber = (num) => {
  return new Intl.NumberFormat('en-US').format(num || 0);
};

const breadcrumbs = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
      
      <!-- Header Section -->
      <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            
            <!-- Title & Greeting -->
            <div>
              <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-2">
                Dashboard
              </h1>
              <p class="text-gray-600 dark:text-gray-400">
                Welcome back! Here's an overview of your properties
              </p>
            </div>

            <!-- CTA Button -->
            <Link
              href="/listings"
              class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-sm whitespace-nowrap"
            >
              <HomeIcon class="w-5 h-5" />
              <span>Manage Listings</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          
          <!-- Total Listings Card -->
          <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <HomeIcon class="w-6 h-6 text-blue-600 dark:text-blue-400" />
              </div>
              <div class="flex items-center gap-1 text-green-600 dark:text-green-400 text-sm font-medium">
                <ArrowTrendingUpIcon class="w-4 h-4" />
                <span>Active</span>
              </div>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
              Total Listings
            </p>
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
              {{ formatNumber(props.stats?.listings_count) }}
            </h2>
            
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
              <Link 
                href="/listings"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition-colors"
              >
                View all listings →
              </Link>
            </div>
          </div>

          <!-- Active Rules Card -->
          <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <TagIcon class="w-6 h-6 text-purple-600 dark:text-purple-400" />
              </div>
              <div class="flex items-center gap-1 text-purple-600 dark:text-purple-400 text-sm font-medium">
                <SparklesIcon class="w-4 h-4" />
                <span>Optimized</span>
              </div>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
              Active Pricing Rules
            </p>
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
              {{ formatNumber(props.stats?.active_rules) }}
            </h2>
            
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
              <Link 
                href="/pricing-rules"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition-colors"
              >
                Manage rules →
              </Link>
            </div>
          </div>

          <!-- Dynamic Prices Card -->
          <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <CalendarIcon class="w-6 h-6 text-green-600 dark:text-green-400" />
              </div>
              <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400 text-sm font-medium">
                <CurrencyDollarIcon class="w-4 h-4" />
                <span>Generated</span>
              </div>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
              Dynamic Prices
            </p>
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white">
              {{ formatNumber(props.stats?.calendar_prices) }}
            </h2>
            
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
              <Link 
                href="/calendar-prices"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition-colors"
              >
                View calendar →
              </Link>
            </div>
          </div>

        </div>

        <!-- Analytics Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12">
          <div class="text-center max-w-2xl mx-auto">
            
            <!-- Icon -->
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
              <ChartBarIcon class="w-10 h-10 text-gray-500 dark:text-gray-400" />
            </div>

            <!-- Title & Description -->
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-3">
              Analytics Coming Soon
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 text-lg">
              Get insights into your pricing performance with advanced analytics and revenue forecasting
            </p>

            <!-- Feature List -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left mb-8">
              <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-8 h-8 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                  <ArrowTrendingUpIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Pricing Trends</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Track performance over time</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-8 h-8 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                  <CalendarIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Seasonality Graphs</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Identify peak booking periods</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-8 h-8 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                  <ChartBarIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Market Demand</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Understand booking patterns</p>
                </div>
              </div>

              <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-8 h-8 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center flex-shrink-0">
                  <CurrencyDollarIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Revenue Forecast</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Project future earnings</p>
                </div>
              </div>
            </div>

            <!-- CTA -->
            <div class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-400">
              <SparklesIcon class="w-5 h-5" />
              <span class="font-medium">Stay tuned for updates</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </AppLayout>
</template>