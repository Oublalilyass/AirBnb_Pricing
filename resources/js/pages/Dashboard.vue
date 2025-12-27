<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

import {
  HomeIcon,
  TagIcon,
  CalendarIcon,
  ChartBarIcon,
  ArrowTrendingUpIcon,
  CurrencyDollarIcon,
  SparklesIcon,
  PlusIcon,
  BanknotesIcon,
  UserGroupIcon,
  ClockIcon,
} from '@heroicons/vue/24/outline'

type Stats = {
  listings_count: number
  active_rules: number
  calendar_prices: number
}

const { stats } = defineProps<{
  stats: Stats
}>()

const formatNumber = (num: number) =>
  new Intl.NumberFormat('en-US').format(num ?? 0)

const breadcrumbs = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
]

// Quick actions for the dashboard
const quickActions = [
  {
    title: 'Add New Listing',
    description: 'List a new property',
    icon: PlusIcon,
    href: '/listings/create',
    color: 'bg-blue-500 dark:bg-blue-600',
  },
  {
    title: 'Create Pricing Rule',
    description: 'Automate your pricing',
    icon: TagIcon,
    href: '/pricing-rules/create',
    color: 'bg-purple-500 dark:bg-purple-600',
  },
  {
    title: 'View Calendar',
    description: 'Check availability',
    icon: CalendarIcon,
    href: '/calendar-prices',
    color: 'bg-green-500 dark:bg-green-600',
  },
]

// Recent activity items (placeholder data)
const recentActivity = [
  {
    title: 'Pricing rule applied',
    description: 'Weekend pricing updated for 3 properties',
    time: '2 hours ago',
    icon: TagIcon,
    color: 'text-purple-600 dark:text-purple-400',
  },
  {
    title: 'New listing created',
    description: 'Downtown Apartment was added',
    time: '5 hours ago',
    icon: HomeIcon,
    color: 'text-blue-600 dark:text-blue-400',
  },
  {
    title: 'Calendar synced',
    description: 'Prices updated for next 30 days',
    time: '1 day ago',
    icon: CalendarIcon,
    color: 'text-green-600 dark:text-green-400',
  },
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
      
      <!-- Hero Header -->
      <div class="relative overflow-hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <!-- Decorative background pattern -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10">
          <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
          <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-12">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div class="flex-1">
              <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium mb-4">
                <SparklesIcon class="w-4 h-4" />
                Property Management Hub
              </div>
              <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-3">
                Welcome back! 👋
              </h1>
              <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl">
                Manage your properties, optimize pricing, and track performance all in one place
              </p>
            </div>

            <div class="flex flex-wrap gap-3">
              <Link
                href="/listings"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
              >
                <HomeIcon class="w-5 h-5" />
                Manage Listings
              </Link>
              
              <Link
                href="/listings/create"
                class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-2 border-gray-200 dark:border-gray-700 rounded-xl font-semibold hover:border-gray-300 dark:hover:border-gray-600 transition-all hover:scale-105"
              >
                <PlusIcon class="w-5 h-5" />
                Add New
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 space-y-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Listings Card -->
          <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:border-blue-300 dark:hover:border-blue-600 transition-all hover:shadow-xl overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 dark:bg-blue-500/20 rounded-full filter blur-2xl group-hover:w-40 group-hover:h-40 transition-all"></div>
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl group-hover:scale-110 transition-transform">
                  <HomeIcon class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                  Active
                </span>
              </div>
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Total Listings
              </p>
              <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ formatNumber(stats.listings_count) }}
              </h2>
              <Link 
                href="/listings"
                class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:gap-2 transition-all"
              >
                View all
                <ArrowTrendingUpIcon class="w-4 h-4" />
              </Link>
            </div>
          </div>

          <!-- Rules Card -->
          <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:border-purple-300 dark:hover:border-purple-600 transition-all hover:shadow-xl overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 dark:bg-purple-500/20 rounded-full filter blur-2xl group-hover:w-40 group-hover:h-40 transition-all"></div>
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-xl group-hover:scale-110 transition-transform">
                  <TagIcon class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                </div>
                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full">
                  Automated
                </span>
              </div>
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Pricing Rules
              </p>
              <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ formatNumber(stats.active_rules) }}
              </h2>
              <Link 
                href="/pricing-rules"
                class="inline-flex items-center gap-1 text-sm font-semibold text-purple-600 dark:text-purple-400 hover:gap-2 transition-all"
              >
                Manage rules
                <ArrowTrendingUpIcon class="w-4 h-4" />
              </Link>
            </div>
          </div>

          <!-- Prices Card -->
          <div class="group relative bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:border-green-300 dark:hover:border-green-600 transition-all hover:shadow-xl overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 dark:bg-green-500/20 rounded-full filter blur-2xl group-hover:w-40 group-hover:h-40 transition-all"></div>
            <div class="relative">
              <div class="flex items-start justify-between mb-4">
                <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-xl group-hover:scale-110 transition-transform">
                  <CalendarIcon class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                  Dynamic
                </span>
              </div>
              <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                Calendar Prices
              </p>
              <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                {{ formatNumber(stats.calendar_prices) }}
              </h2>
              <Link 
                href="/calendar-prices"
                class="inline-flex items-center gap-1 text-sm font-semibold text-green-600 dark:text-green-400 hover:gap-2 transition-all"
              >
                View calendar
                <ArrowTrendingUpIcon class="w-4 h-4" />
              </Link>
            </div>
          </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          
          <!-- Quick Actions -->
          <div class="bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-6">
              <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <SparklesIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
              </div>
              <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                Quick Actions
              </h3>
            </div>
            
            <div class="space-y-3">
              <div 
                v-for="action in quickActions" 
                :key="action.title"
                class="group"
              >
                <Link
                  :href="action.href"
                  class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-md transition-all"
                >
                  <div :class="[action.color, 'p-3 rounded-lg text-white group-hover:scale-110 transition-transform']">
                    <component :is="action.icon" class="w-5 h-5" />
                  </div>
                  <div class="flex-1">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-0.5">
                      {{ action.title }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                      {{ action.description }}
                    </p>
                  </div>
                  <ArrowTrendingUpIcon class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 group-hover:translate-x-1 transition-all" />
                </Link>
              </div>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 p-6 hover:shadow-xl transition-all">
            <div class="flex items-center gap-3 mb-6">
              <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <ClockIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
              </div>
              <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                Recent Activity
              </h3>
            </div>
            
            <div class="space-y-4">
              <div 
                v-for="(activity, index) in recentActivity" 
                :key="index"
                class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
              >
                <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg h-fit">
                  <component :is="activity.icon" :class="[activity.color, 'w-5 h-5']" />
                </div>
                <div class="flex-1 min-w-0">
                  <h4 class="font-semibold text-gray-900 dark:text-white mb-1">
                    {{ activity.title }}
                  </h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    {{ activity.description }}
                  </p>
                  <p class="text-xs text-gray-500 dark:text-gray-500">
                    {{ activity.time }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Analytics Preview -->
        <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 rounded-2xl border-2 border-gray-700 dark:border-gray-600 p-12 text-center">
          <!-- Decorative elements -->
          <div class="absolute top-0 left-1/4 w-64 h-64 bg-blue-500/20 rounded-full filter blur-3xl"></div>
          <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-purple-500/20 rounded-full filter blur-3xl"></div>
          
          <div class="relative">
            <div class="inline-flex p-4 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
              <ChartBarIcon class="w-12 h-12 text-white" />
            </div>
            <h3 class="text-3xl font-bold text-white mb-3">
              Analytics & Insights
            </h3>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto mb-8">
              Track revenue, occupancy rates, and market trends. Advanced analytics and forecasting tools are coming soon to help you maximize your earnings.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
              <div class="px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                📊 Revenue Tracking
              </div>
              <div class="px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                📈 Market Analysis
              </div>
              <div class="px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium">
                🎯 Performance Insights
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Smooth transitions for all interactive elements */
* {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for dark mode */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background-color: rgb(243 244 246);
}

:deep(.dark) ::-webkit-scrollbar-track {
  background-color: rgb(31 41 55);
}

::-webkit-scrollbar-thumb {
  background-color: rgb(209 213 219);
  border-radius: 9999px;
}

:deep(.dark) ::-webkit-scrollbar-thumb {
  background-color: rgb(75 85 99);
}

::-webkit-scrollbar-thumb:hover {
  background-color: rgb(156 163 175);
}

:deep(.dark) ::-webkit-scrollbar-thumb:hover {
  background-color: rgb(107 114 128);
}
</style>