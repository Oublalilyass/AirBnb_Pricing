<script setup>
import { ArrowLeftIcon, MapPinIcon, CurrencyDollarIcon } from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  listing: Object,
});
</script>

<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Back Button -->
      <button
        @click="$inertia.visit('/listings')"
        class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors mb-6 group"
      >
        <ArrowLeftIcon class="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
        <span class="font-medium">Back to Listings</span>
      </button>

      <!-- Header Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
          <!-- Left Side -->
          <div class="flex-1">
            <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-3">
              {{ listing.name }}
            </h1>
            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
              <MapPinIcon class="w-5 h-5" />
              <span class="text-base">{{ listing.location }}</span>
            </div>
          </div>

          <!-- Right Side - Pricing -->
          <div class="lg:text-right bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 lg:min-w-[280px]">
            <div class="flex items-center justify-end gap-2 mb-2">
              <CurrencyDollarIcon class="w-6 h-6 text-[#FF385C]" />
              <span class="text-3xl font-semibold text-gray-900 dark:text-white">
                ${{ listing.base_price }}
              </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Base Price</p>
            <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
              <p class="text-sm text-gray-600 dark:text-gray-300">
                <span class="font-medium">Min:</span> ${{ listing.min_price }}
                <span class="mx-2">•</span>
                <span class="font-medium">Max:</span> ${{ listing.max_price }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Pricing Rules Section -->
      <div>
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
          Pricing Rules
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="rule in listing.pricing_rules"
            :key="rule.id"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md hover:border-[#FF385C] dark:hover:border-[#FF385C] transition-all duration-200 cursor-pointer group"
          >
            <!-- Rule Header -->
            <div class="mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-[#FF385C] transition-colors">
                {{ rule.name }}
              </h3>
            </div>

            <!-- Rule Details -->
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">Rule Type</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">
                  {{ rule.rule_type }}
                </span>
              </div>

              <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-gray-400">Value</span>
                <span class="text-sm font-medium text-gray-900 dark:text-white">
                  {{ rule.value }}
                  <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ rule.value_type }})</span>
                </span>
              </div>

              <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-xs text-gray-500 dark:text-gray-400">Start Date</span>
                  <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                    {{ rule.start_date }}
                  </span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-xs text-gray-500 dark:text-gray-400">End Date</span>
                  <span class="text-xs font-medium text-gray-700 dark:text-gray-300">
                    {{ rule.end_date }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>