<script setup>
import { ref, computed } from "vue";
import { 
  ChevronLeftIcon,
  PlusIcon,
  MagnifyingGlassIcon,
  AdjustmentsHorizontalIcon,
  SparklesIcon,
  FunnelIcon,
  XMarkIcon,
  CalendarIcon,
  TagIcon,
  SunIcon,
  FireIcon,
} from "@heroicons/vue/24/outline";
import AppLayout from "@/layouts/AppLayout.vue";
import { router, Link } from '@inertiajs/vue3';
import CreateForm from './CreateForm.vue';

const props = defineProps({
  pricingRules: {
    type: Array,
    default: () => [],
  },
  listings: {
    type: Array,
    default: () => [],
  },
});

const searchQuery = ref("");
const sortBy = ref("recent");
const filters = ref({
  listing_id: "",
  rule_type: "",
});

const showFilters = ref(false);
const showCreateForm = ref(false);

// Check if filters are active
const hasActiveFilters = computed(() => {
  return filters.value.listing_id || filters.value.rule_type;
});

// Filter and sort pricing rules
const filteredRules = computed(() => {
  let results = props.pricingRules || [];
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    results = results.filter(rule => 
      rule.name?.toLowerCase().includes(query) ||
      rule.listing?.name?.toLowerCase().includes(query) ||
      rule.listing?.location?.toLowerCase().includes(query)
    );
  }
  
  // Filter by listing_id
  if (filters.value.listing_id) {
    results = results.filter(rule => 
      rule.listing_id?.toString() === filters.value.listing_id.toString()
    );
  }
  
  // Filter by rule_type
  if (filters.value.rule_type) {
    results = results.filter(rule => rule.rule_type === filters.value.rule_type);
  }
  
  // Sort rules
  results = [...results].sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return (a.name || '').localeCompare(b.name || '');
      case 'value-high':
        return (b.value || 0) - (a.value || 0);
      case 'value-low':
        return (a.value || 0) - (b.value || 0);
      case 'recent':
      default:
        return new Date(b.created_at) - new Date(a.created_at);
    }
  });
  
  return results;
});

// Get icon for rule type
const getRuleIcon = (ruleType) => {
  const icons = {
    seasonal: SunIcon,
    season: SunIcon,
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
    season: 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
    event: 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
    weekend: 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    demand: 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
  };
  return colors[ruleType] || 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
};

// Format date nicely
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const options = { month: 'short', day: 'numeric', year: 'numeric' };
  return new Date(dateString).toLocaleDateString('en-US', options);
};

// Format value display
const formatValue = (value, valueType) => {
  if (valueType === 'percentage') {
    return `${value > 0 ? '+' : ''}${value}%`;
  }
  return `${value > 0 ? '+' : ''}$${new Intl.NumberFormat('en-US').format(value)}`;
};

// Get rule type label
const getRuleTypeLabel = (type) => {
  const labels = {
    seasonal: 'Seasonal',
    season: 'Seasonal',
    event: 'Special Event',
    weekend: 'Weekend',
    demand: 'Demand Surge',
  };
  return labels[type] || type;
};

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

// Navigation helpers
const goToDashboard = () => {
  router.visit('/dashboard');
};
</script>

<template>
  <AppLayout>
    <!-- Page Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
      
      <!-- Header Section with Background -->
      <div class="relative overflow-hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <!-- Decorative background -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10">
          <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl"></div>
          <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-8">
          
          <!-- Back Button -->
          <button 
            @click="goToDashboard"
            class="inline-flex items-center gap-2 mb-6 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all group"
          >
            <ChevronLeftIcon class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:-translate-x-1 transition-transform" />
            <span class="font-medium text-gray-700 dark:text-gray-300 text-sm">Back to Dashboard</span>
          </button>

          <!-- Page Header -->
          <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
            <div class="flex-1">
              <div class="inline-flex items-center gap-2 px-3 py-1 bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm font-medium mb-3">
                <TagIcon class="w-4 h-4" />
                Pricing Automation
              </div>
              <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                Pricing Rules
              </h1>
              <div class="flex items-center gap-4 text-gray-600 dark:text-gray-400">
                <div class="flex items-center gap-2">
                  <SparklesIcon class="w-5 h-5 text-purple-500" />
                  <span class="font-semibold text-gray-900 dark:text-white">{{ filteredRules.length }}</span>
                  <span>{{ filteredRules.length === 1 ? 'rule' : 'rules' }}</span>
                </div>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <span>Automate your pricing strategy</span>
              </div>
            </div>

            <!-- Add Rule Button -->
            <button 
              @click="showCreateForm = true"
              class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105 whitespace-nowrap"
            >
              <PlusIcon class="w-5 h-5" />
              <span>Create New Rule</span>
            </button>
          </div>

          <!-- Search and Filter Bar -->
          <div v-if="(props.pricingRules && props.pricingRules.length > 0)" class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="flex-1 relative group">
              <MagnifyingGlassIcon class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-300 transition-colors" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by name, listing name or location..."
                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-all placeholder:text-gray-400"
              />
            </div>

            <!-- Sort Dropdown -->
            <div class="relative sm:w-56 group">
              <AdjustmentsHorizontalIcon class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none group-focus-within:text-gray-600 dark:group-focus-within:text-gray-300 transition-colors" />
              <select
                v-model="sortBy"
                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white appearance-none cursor-pointer transition-all"
              >
                <option value="recent">Most Recent</option>
                <option value="name">Name: A to Z</option>
                <option value="value-high">Value: High to Low</option>
                <option value="value-low">Value: Low to High</option>
              </select>
            </div>

            <!-- Filter Toggle Button -->
            <button
              @click="showFilters = !showFilters"
              class="flex items-center gap-2 px-4 py-3.5 border-2 rounded-xl transition-all whitespace-nowrap"
              :class="hasActiveFilters 
                ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 border-gray-900 dark:border-white' 
                : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'"
            >
              <FunnelIcon class="w-5 h-5" />
              <span class="font-medium">Filters</span>
              <span v-if="hasActiveFilters" class="w-1.5 h-1.5 bg-white dark:bg-gray-900 rounded-full"></span>
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
                      class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow"
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
                      class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow appearance-none cursor-pointer"
                    >
                      <option value="">All types</option>
                      <option value="seasonal">Seasonal</option>
                      <option value="season">Season</option>
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
                    class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors"
                  >
                    Cancel
                  </button>
                  <button
                    @click="applyFilters"
                    class="px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm"
                  >
                    Show results
                  </button>
                </div>
              </div>
            </div>
          </transition>

          <!-- Active Filters Pills -->
          <div v-if="hasActiveFilters && !showFilters" class="flex flex-wrap gap-2 mt-4">
            <div v-if="filters.listing_id" class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-full text-sm">
              <span class="text-gray-700 dark:text-gray-300">Listing: {{ filters.listing_id }}</span>
              <button @click="filters.listing_id = ''; applyFilters()" class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
                <XMarkIcon class="w-4 h-4 text-gray-500" />
              </button>
            </div>
            <div v-if="filters.rule_type" class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-full text-sm">
              <span class="text-gray-700 dark:text-gray-300">Type: {{ getRuleTypeLabel(filters.rule_type) }}</span>
              <button @click="filters.rule_type = ''; applyFilters()" class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
                <XMarkIcon class="w-4 h-4 text-gray-500" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">

        <!-- Rules Grid -->
        <div v-if="filteredRules.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          
          <div
            v-for="rule in filteredRules"
            :key="rule.id"
            class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-xl transition-all duration-300"
          >
            <!-- Card Content -->
            <div class="p-6">
              
              <!-- Header with Icon & Type Badge -->
              <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    {{ rule.name || `Rule #${rule.id}` }}
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
                  {{ rule.listing?.name || `Listing #${rule.listing_id}` }}
                </p>
                <p v-if="rule.listing?.location" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                  {{ rule.listing.location }}
                </p>
              </div>
            </div>
          </div>

        </div>

        <!-- No Search Results -->
        <div v-else-if="(props.pricingRules && props.pricingRules.length > 0) && filteredRules.length === 0" class="text-center py-20">
          <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <MagnifyingGlassIcon class="w-12 h-12 text-gray-400" />
            </div>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            No rules found
          </h3>
          <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
            We couldn't find any pricing rules matching your search or filters
          </p>
          <button
            @click="searchQuery = ''; resetFilters()"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
          >
            Clear search & filters
          </button>
        </div>

        <!-- Empty State - No Rules -->
        <div v-else class="text-center py-20">
          <div class="relative w-40 h-40 mx-auto mb-8">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-blue-100 dark:from-purple-900/30 dark:to-blue-900/30 rounded-full blur-2xl"></div>
            <div class="relative w-40 h-40 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center">
              <TagIcon class="w-20 h-20 text-gray-400 dark:text-gray-500" />
            </div>
          </div>
          
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm font-medium mb-4">
            <SparklesIcon class="w-4 h-4" />
            Get Started
          </div>

          <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
            Start automating your pricing
          </h3>
          <p class="text-lg text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-10">
            Create pricing rules to automatically adjust your rates based on seasons, events, weekends, and demand
          </p>
          
          <button 
            @click="showCreateForm = true"
            class="inline-flex items-center gap-3 px-10 py-5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-lg font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
          >
            <PlusIcon class="w-6 h-6" />
            <span>Create your first pricing rule</span>
          </button>
        </div>

      </div>
    </div>

    <!-- Create Form Modal -->
    <CreateForm 
      v-if="showCreateForm"
      :listings="listings"
      @close="showCreateForm = false"
    />
  </AppLayout>
</template>

<style scoped>
/* Smooth transitions */
* {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom select arrow */
select {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.75rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}

/* Dark mode select arrow */
:deep(.dark) select {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%9ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
}
</style>