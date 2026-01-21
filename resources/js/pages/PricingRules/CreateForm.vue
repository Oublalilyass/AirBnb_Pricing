<script setup>
import { ref, computed } from "vue";
import { 
  XMarkIcon,
  CalendarIcon,
  TagIcon,
  HomeIcon,
  CurrencyDollarIcon,
} from "@heroicons/vue/24/outline";
import { router } from '@inertiajs/vue3';

const props = defineProps({
  listings: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['close']);

const form = ref({
  listing_id: '',
  rule_type: '',
  name: '',
  value: '',
  value_type: 'percentage',
  start_date: '',
  end_date: '',
});

const errors = ref({});
const isSubmitting = ref(false);

// Rule type options
const ruleTypes = [
  { value: 'season', label: 'Seasonal' },
  { value: 'weekend', label: 'Weekend' },
  { value: 'event', label: 'Special Event' },
  { value: 'demand', label: 'Demand Surge' },
];

// Value type options
const valueTypes = [
  { value: 'percentage', label: 'Percentage (%)' },
  { value: 'fixed', label: 'Fixed Amount ($)' },
];

// Reset form
const resetForm = () => {
  form.value = {
    listing_id: '',
    rule_type: '',
    name: '',
    value: '',
    value_type: 'percentage',
    start_date: '',
    end_date: '',
  };
  errors.value = {};
};

// Handle form submission
const submitForm = () => {
  errors.value = {};
  isSubmitting.value = true;

  router.post('/pricing-rules', form.value, {
    preserveScroll: true,
    onSuccess: (page) => {
      resetForm();
      emit('close');
      // Optionally reload the page to show the new rule
      router.reload({ only: ['pricingRules'] });
    },
    onError: (errs) => {
      errors.value = errs;
      isSubmitting.value = false;
    },
    onFinish: () => {
      isSubmitting.value = false;
    },
  });
};

// Handle cancel
const cancel = () => {
  resetForm();
  emit('close');
};
</script>

<template>
  <!-- Modal Overlay -->
  <div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
      <!-- Backdrop -->
      <div 
        class="fixed inset-0 bg-gray-900/50 dark:bg-gray-900/80 backdrop-blur-sm transition-opacity"
        @click="cancel"
      ></div>

      <!-- Modal Content -->
      <div class="relative w-full max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
        
        <!-- Header -->
        <div class="relative bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/30 dark:to-blue-900/30 border-b border-gray-200 dark:border-gray-700 px-6 py-5">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                <TagIcon class="w-6 h-6 text-white" />
              </div>
              <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                  Create New Pricing Rule
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                  Automate your pricing strategy
                </p>
              </div>
            </div>
            <button
              @click="cancel"
              class="p-2 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors"
            >
              <XMarkIcon class="w-6 h-6 text-gray-600 dark:text-gray-400" />
            </button>
          </div>
        </div>

        <!-- Form Content -->
        <form @submit.prevent="submitForm" class="p-6 space-y-6">
          
          <!-- Listing Selection -->
          <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
              <HomeIcon class="w-5 h-5 text-gray-500" />
              Listing
              <span class="text-red-500">*</span>
            </label>
            <select
              v-model="form.listing_id"
              required
              class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all"
              :class="{ 'border-red-500': errors.listing_id }"
            >
              <option value="">Select a listing</option>
              <option 
                v-for="listing in listings" 
                :key="listing.id" 
                :value="listing.id"
              >
                {{ listing.name }} - {{ listing.location }}
              </option>
            </select>
            <p v-if="errors.listing_id" class="mt-2 text-sm text-red-600 dark:text-red-400">
              {{ errors.listing_id }}
            </p>
          </div>

          <!-- Rule Name -->
          <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
              <TagIcon class="w-5 h-5 text-gray-500" />
              Rule Name
              <span class="text-red-500">*</span>
            </label>
            <input
              v-model="form.name"
              type="text"
              required
              placeholder="e.g., Summer Peak Season"
              class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all placeholder:text-gray-400"
              :class="{ 'border-red-500': errors.name }"
            />
            <p v-if="errors.name" class="mt-2 text-sm text-red-600 dark:text-red-400">
              {{ errors.name }}
            </p>
          </div>

          <!-- Rule Type -->
          <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
              <TagIcon class="w-5 h-5 text-gray-500" />
              Rule Type
              <span class="text-red-500">*</span>
            </label>
            <select
              v-model="form.rule_type"
              required
              class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all appearance-none"
              :class="{ 'border-red-500': errors.rule_type }"
            >
              <option value="">Select rule type</option>
              <option 
                v-for="type in ruleTypes" 
                :key="type.value" 
                :value="type.value"
              >
                {{ type.label }}
              </option>
            </select>
            <p v-if="errors.rule_type" class="mt-2 text-sm text-red-600 dark:text-red-400">
              {{ errors.rule_type }}
            </p>
          </div>

          <!-- Value Type and Value -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Value Type -->
            <div>
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <CurrencyDollarIcon class="w-5 h-5 text-gray-500" />
                Adjustment Type
                <span class="text-red-500">*</span>
              </label>
              <select
                v-model="form.value_type"
                required
                class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all appearance-none"
                :class="{ 'border-red-500': errors.value_type }"
              >
                <option 
                  v-for="type in valueTypes" 
                  :key="type.value" 
                  :value="type.value"
                >
                  {{ type.label }}
                </option>
              </select>
              <p v-if="errors.value_type" class="mt-2 text-sm text-red-600 dark:text-red-400">
                {{ errors.value_type }}
              </p>
            </div>

            <!-- Value -->
            <div>
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <CurrencyDollarIcon class="w-5 h-5 text-gray-500" />
                Value
                <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <span 
                  v-if="form.value_type === 'percentage'" 
                  class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium"
                >
                  %
                </span>
                <span 
                  v-else 
                  class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium"
                >
                  $
                </span>
                <input
                  v-model="form.value"
                  type="number"
                  step="0.01"
                  required
                  :placeholder="form.value_type === 'percentage' ? 'e.g., 15' : 'e.g., 50'"
                  class="w-full pl-10 pr-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all placeholder:text-gray-400"
                  :class="{ 'border-red-500': errors.value }"
                />
              </div>
              <p v-if="errors.value" class="mt-2 text-sm text-red-600 dark:text-red-400">
                {{ errors.value }}
              </p>
              <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <span v-if="form.value_type === 'percentage'">
                  Enter a percentage (e.g., 15 for +15% increase, -10 for -10% decrease)
                </span>
                <span v-else>
                  Enter a fixed amount (e.g., 50 for +$50 increase, -25 for -$25 decrease)
                </span>
              </p>
            </div>
          </div>

          <!-- Date Range -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Start Date -->
            <div>
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <CalendarIcon class="w-5 h-5 text-gray-500" />
                Start Date
              </label>
              <input
                v-model="form.start_date"
                type="date"
                class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all"
                :class="{ 'border-red-500': errors.start_date }"
              />
              <p v-if="errors.start_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                {{ errors.start_date }}
              </p>
            </div>

            <!-- End Date -->
            <div>
              <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <CalendarIcon class="w-5 h-5 text-gray-500" />
                End Date
              </label>
              <input
                v-model="form.end_date"
                type="date"
                :min="form.start_date"
                class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent dark:bg-gray-800 dark:text-white transition-all"
                :class="{ 'border-red-500': errors.end_date }"
              />
              <p v-if="errors.end_date" class="mt-2 text-sm text-red-600 dark:text-red-400">
                {{ errors.end_date }}
              </p>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button
              type="button"
              @click="cancel"
              class="px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors"
              :disabled="isSubmitting"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
              :disabled="isSubmitting"
            >
              <span v-if="isSubmitting">Creating...</span>
              <span v-else>Create Rule</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
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
