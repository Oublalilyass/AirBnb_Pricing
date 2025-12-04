<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-2">
          {{ listing ? 'Edit Listing' : 'Create a New Listing' }}
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
          {{ listing ? 'Update your property details' : 'Add a new property to your portfolio' }}
        </p>
      </div>

      <!-- Form Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
        <form @submit.prevent="save" class="space-y-6">
          <!-- Name Field -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
              Property Name
            </label>
            <input id="name" v-model="form.name" type="text" required placeholder="e.g., Modern Downtown Apartment"
              class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                     bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                     placeholder-gray-400 dark:placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                     transition-all duration-200">
          </div>

          <!-- Location Field -->
          <div>
            <label for="location" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
              Location
            </label>
            <input id="location" v-model="form.location" type="text" placeholder="e.g., New York, NY" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                     bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                     placeholder-gray-400 dark:placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                     transition-all duration-200">
          </div>

          <!-- Base Price Field -->
          <div>
            <label for="base_price" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
              Base Price per Night
            </label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                $
              </span>
              <input id="base_price" v-model="form.base_price" type="number" required min="0" step="1" placeholder="100"
                class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                       placeholder-gray-400 dark:placeholder-gray-500
                       focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                       transition-all duration-200">
            </div>
          </div>

          <!-- Min & Max Price Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Min Price -->
            <div>
              <label for="min_price" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                Minimum Price
              </label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                  $
                </span>
                <input id="min_price" v-model="form.min_price" type="number" min="0" step="1" placeholder="50" class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                         placeholder-gray-400 dark:placeholder-gray-500
                         focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                         transition-all duration-200">
              </div>
            </div>

            <!-- Max Price -->
            <div>
              <label for="max_price" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                Maximum Price
              </label>
              <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                  $
                </span>
                <input id="max_price" v-model="form.max_price" type="number" min="0" step="1" placeholder="200" class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                         placeholder-gray-400 dark:placeholder-gray-500
                         focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                         transition-all duration-200">
              </div>
            </div>
          </div>

          <!-- Capacity Field -->
          <div>
            <label for="capacity" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
              Guest Capacity
            </label>
            <input id="capacity" v-model="form.capacity" type="number" required min="1" placeholder="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                     bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                     placeholder-gray-400 dark:placeholder-gray-500
                     focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:border-transparent
                     transition-all duration-200">
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
              Maximum number of guests allowed
            </p>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" class="flex-1 px-6 py-3 rounded-xl font-medium
                     bg-gradient-to-r from-[#FF385C] to-[#E61E4D]
                     text-white hover:from-[#E61E4D] hover:to-[#D70466]
                     transform hover:scale-[1.02] active:scale-[0.98]
                     transition-all duration-200 shadow-md hover:shadow-lg
                     focus:outline-none focus:ring-2 focus:ring-[#FF385C] focus:ring-offset-2">
              {{ listing ? 'Update Listing' : 'Create Listing' }}
            </button>

            <button type="button" @click="handleCancel" class="px-6 py-3 rounded-xl font-medium
                     bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300
                     hover:bg-gray-200 dark:hover:bg-gray-600
                     transition-all duration-200
                     focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
              Cancel
            </button>
          </div>
        </form>
      </div>

      <!-- Helper Text -->
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">
          All fields are required. Make sure to provide accurate information.
        </p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default defineComponent({
  props: ['listing'],
  emits: ['saved', 'close'],
  methods: {
    handleCancel() {
      console.log("Hello");
      this.$inertia.visit('/listings');
    }
  },
  setup(props, { emit }) {
    const form = useForm({
      name: props.listing?.name || '',
      location: props.listing?.location || '',
      base_price: props.listing?.base_price || '',
      min_price: props.listing?.min_price || '',
      max_price: props.listing?.max_price || '',
      capacity: props.listing?.capacity || '',
    });

    const save = () => {
      console.log('Attempting to save:', form.data());

      if (props.listing) {
        form.put(`/listings/${props.listing.id}`, {
          onSuccess: () => {
            console.log('Listing updated successfully');
            emit('saved');
            emit('close');
          },
          onError: (errors) => {
            console.error('Validation errors:', errors);
          }
        });
      } else {
        form.post('/listings', {
          onSuccess: () => {
            console.log('Listing created successfully');
            emit('saved');
            emit('close');
          },
          onError: (errors) => {
            console.error('Validation errors:', errors);
          }
        });
      }
    };

    return { form, save };
  },
});
</script>