<script setup>
import { ref, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { 
  ChevronLeftIcon, 
  FunnelIcon, 
  XMarkIcon, 
  MagnifyingGlassIcon,
  CalendarIcon,
  TagIcon,
  SparklesIcon,
  SunIcon,
  FireIcon
} from "@heroicons/vue/24/outline";

const props = defineProps({
  pricingRules: Array,
});

const filters = ref({
  listing_id: "",
  rule_type: "",
});

const showFilters = ref(false);

// Check if filters are active
const hasActiveFilters = computed(() => {
  return filters.value.listing_id || filters.value.rule_type;
});

// Apply filters
const applyFilters = () => {
  router.get("/pricing-rules", filters.value, {
    preserveState: true,
    preserveScroll: true,
  });
  showFilters.value = false;
};

// Clear filters
const resetFilters = () => {
  filters.value = {
    listing_id: "",
    rule_type: "",
  };
  applyFilters();
};

// Get icon for rule type
const getRuleIcon = (ruleType) => {
  const icons = {
    seasonal: SunIcon,
    event: SparklesIcon,
    weekend: CalendarIcon,
    demand: FireIcon,
  };
  return icons[ruleType] || TagIcon;
};

// Get color for rule type
const getRuleColor = (ruleType) => {
  const colors = {
    seasonal: 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
    event: 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
    weekend: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    demand: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  };
  return colors[ruleType] || 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
};

// Format date nicely
const formatDate = (dateString) => {
  const options = { month: 'short', day: 'numeric', year: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

// Format value display
const formatValue = (value, valueType) => {
  if (valueType === 'percentage') {
    return `${value > 0 ? '+' : ''}${value}%`;
  }
  return `${value > 0 ? '+' : ''}${value} MAD`;
};

// Get rule type label
const getRuleTypeLabel = (type) => {
  const labels = {
    seasonal: 'Seasonal',
    event: 'Special Event',
    weekend: 'Weekend',
    demand: 'Demand Surge',
  };
  return labels[type] || type;
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    
    <!-- Header with sticky behavior -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
          
          <!-- Back Link & Title -->
          <div class="flex items-center gap-4">
            <Link
              href="/listings"
              class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors"
            >
              <ChevronLeftIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
            </Link>
            
            <div>
              <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Pricing Rules
              </h1>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                {{ pricingRules.length }} active {{ pricingRules.length === 1 ? 'rule' : 'rules' }}
              </p>
            </div>
          </div>

          <!-- Filter Toggle Button -->
          <button
            @click="showFilters = !showFilters"
            class="flex items-center gap-2 px-4 py-2.5 rounded-full transition-all"
            :class="hasActiveFilters 
              ? 'bg-gray-900 dark:bg-gray-700 text-white border border-gray-900 dark:border-gray-700' 
              : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:border-gray-900 dark:hover:border-gray-400'"
          >
            <FunnelIcon class="w-4 h-4" />
            <span class="font-medium text-sm">Filters</span>
            <span v-if="hasActiveFilters" class="w-1.5 h-1.5 bg-white rounded-full"></span>
          </button>
        </div>

        <!-- Filter Panel (Collapsible) -->
        <transition
          enter-active-class="transition ease-out duration-200"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
          leave-active-class="transition ease-in duration-150"
          leave-from-class="opacity-100 translate-y-0"
          leave-to-class="opacity-0 -translate-y-2"
        >
          <div v-if="showFilters" class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              
              <!-- Listing ID -->
              <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">
                  Listing ID
                </label>
                <div class="relative">
                  <MagnifyingGlassIcon class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                  <input
                    type="text"
                    v-model="filters.listing_id"
                    placeholder="Search by ID"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow"
                  />
                </div>
              </div>

              <!-- Rule Type -->
              <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">
                  Rule Type
                </label>
                <div class="relative">
                  <TagIcon class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
                  <select
                    v-model="filters.rule_type"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow appearance-none cursor-pointer"
                  >
                    <option value="">All types</option>
                    <option value="seasonal">Seasonal</option>
                    <option value="event">Special Event</option>
                    <option value="weekend">Weekend</option>
                    <option value="demand">Demand Surge</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4">
              <button
                v-if="hasActiveFilters"
                @click="resetFilters"
                class="text-sm font-medium text-gray-700 dark:text-gray-300 underline hover:text-gray-900 dark:hover:text-white transition-colors"
              >
                Clear all
              </button>
              <div v-else></div>

              <div class="flex gap-3">
                <button
                  @click="showFilters = false"
                  class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
                >
                  Cancel
                </button>
                <button
                  @click="applyFilters"
                  class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm"
                >
                  Show results
                </button>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
      
      <!-- Active Filters Pills -->
      <div v-if="hasActiveFilters && !showFilters" class="flex flex-wrap gap-2 mb-6">
        <div v-if="filters.listing_id" class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-sm">
          <span class="text-gray-700 dark:text-gray-300">Listing: {{ filters.listing_id }}</span>
          <button @click="filters.listing_id = ''; applyFilters()" class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
            <XMarkIcon class="w-4 h-4 text-gray-500" />
          </button>
        </div>
        <div v-if="filters.rule_type" class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-sm">
          <span class="text-gray-700 dark:text-gray-300">Type: {{ getRuleTypeLabel(filters.rule_type) }}</span>
          <button @click="filters.rule_type = ''; applyFilters()" class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
            <XMarkIcon class="w-4 h-4 text-gray-500" />
          </button>
        </div>
      </div>

      <!-- Rules Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <div
          v-for="rule in pricingRules"
          :key="rule.id"
          class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-200 overflow-hidden group cursor-pointer"
        >
          <!-- Card Content -->
          <div class="p-6">
            
            <!-- Header with Icon & Type Badge -->
            <div class="flex items-start justify-between mb-4">
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                  {{ rule.name }}
                </h3>
                <div :class="['inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium', getRuleColor(rule.rule_type)]">
                  <component :is="getRuleIcon(rule.rule_type)" class="w-3.5 h-3.5" />
                  <span>{{ getRuleTypeLabel(rule.rule_type) }}</span>
                </div>
              </div>
            </div>

            <!-- Price Adjustment - Prominent Display -->
            <div class="mb-5 pb-5 border-b border-gray-100 dark:border-gray-700">
              <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                Price Adjustment
              </p>
              <p class="text-3xl font-bold" :class="rule.value > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                {{ formatValue(rule.value, rule.value_type) }}
              </p>
            </div>

            <!-- Date Range -->
            <div class="flex items-center gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
              <CalendarIcon class="w-4 h-4 flex-shrink-0" />
              <div class="flex items-center gap-2">
                <span>{{ formatDate(rule.start_date) }}</span>
                <span class="text-gray-400">→</span>
                <span>{{ formatDate(rule.end_date) }}</span>
              </div>
            </div>

            <!-- Listing Info -->
            <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
              <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1.5">
                Applied to
              </p>
              <p class="text-sm font-medium text-gray-900 dark:text-white">
                {{ rule.listing.name }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                ID: {{ rule.listing.id }}
              </p>
            </div>
          </div>
        </div>

      </div>

      <!-- Empty State -->
      <div v-if="!pricingRules || pricingRules.length === 0" class="text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
          <TagIcon class="w-12 h-12 text-gray-400" />
        </div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
          No pricing rules found
        </h3>
        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
          {{ hasActiveFilters ? 'Try adjusting your filters to see more results' : 'Create your first pricing rule to optimize your listing rates' }}
        </p>
        <button
          v-if="hasActiveFilters"
          @click="resetFilters"
          class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors"
        >
          Clear filters
        </button>
      </div>
    </div>

  </div>
</template>