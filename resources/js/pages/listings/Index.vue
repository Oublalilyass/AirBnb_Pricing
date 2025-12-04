<script setup>
import { ArrowLeftIcon, MapPinIcon, CurrencyDollarIcon, PlusIcon } from "@heroicons/vue/24/outline";
import AppLayout from "@/layouts/app/AppSidebarLayout.vue";

defineProps({
  listings: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <AppLayout>
    <!-- Page Container with Airbnb spacing -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Back Button -->
        <button @click="$inertia.visit('/dashboard')" class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 
                 hover:text-gray-900 dark:hover:text-white transition-colors mb-6 group">
          <ArrowLeftIcon class="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
          <span class="font-medium">Back to Dashboard</span>
        </button>

        <!-- Page Header with Add Button -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-2">
              Your Listings
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
              {{ listings.length }} {{ listings.length === 1 ? 'property' : 'properties' }} available
            </p>
          </div>

          <!-- Add Listing Button -->
          <button @click="$inertia.get('/listings/create')" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium
                   bg-gradient-to-r from-[#FF385C] to-[#E61E4D]
                   text-white hover:from-[#E61E4D] hover:to-[#D70466]
                   transform hover:scale-[1.02] active:scale-[0.98]
                   transition-all duration-200 shadow-md hover:shadow-lg
                   whitespace-nowrap">
            <PlusIcon class="w-5 h-5" />
            <span>Add Listing</span>
          </button>
        </div>

        <!-- Listings Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div v-for="listing in listings" :key="listing.id" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden 
                   shadow-sm border border-gray-200 dark:border-gray-700
                   hover:shadow-lg transition-all duration-300 cursor-pointer"
            @click="$inertia.visit(`/listings/${listing.id}`)">
            <!-- Image Placeholder with Gradient -->
            <div class="relative h-48 bg-gradient-to-br from-[#FF385C] to-[#E61E4D] 
                        overflow-hidden">
              <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-white/90 text-center">
                  <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Card Content -->
            <div class="p-5">
              <!-- Title -->
              <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 
                         group-hover:text-[#FF385C] transition-colors line-clamp-1">
                {{ listing.name ?? "Listing #" + listing.id }}
              </h2>

              <!-- Location -->
              <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 mb-3">
                <MapPinIcon class="w-4 h-4 flex-shrink-0" />
                <span class="text-sm line-clamp-1">{{ listing.location }}</span>
              </div>

              <!-- Divider -->
              <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

              <!-- Price -->
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <CurrencyDollarIcon class="w-5 h-5 text-gray-400 dark:text-gray-500" />
                  <span class="text-xl font-semibold text-gray-900 dark:text-white">
                    ${{ listing.base_price }}
                  </span>
                </div>
                <span class="text-sm text-gray-500 dark:text-gray-400">per night</span>
              </div>

              <!-- View Button -->
              <button @click.stop="$inertia.visit(`/listings/${listing.id}`)" class="mt-5 w-full px-4 py-2.5 rounded-lg font-medium
                       bg-gradient-to-r from-[#FF385C] to-[#E61E4D]
                       text-white hover:from-[#E61E4D] hover:to-[#D70466]
                       transform hover:scale-[1.02] active:scale-[0.98]
                       transition-all duration-200 shadow-sm hover:shadow-md">
                View Details
              </button>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="listings.length === 0" class="text-center py-16">
          <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
            No listings yet
          </h3>
          <p class="text-gray-600 dark:text-gray-400 mb-6">
            Start by creating your first property listing
          </p>
          <button @click="$inertia.get('/listings/create')" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium
                   bg-gradient-to-r from-[#FF385C] to-[#E61E4D]
                   text-white hover:from-[#E61E4D] hover:to-[#D70466]
                   transform hover:scale-[1.02] active:scale-[0.98]
                   transition-all duration-200 shadow-md hover:shadow-lg">
            <PlusIcon class="w-5 h-5" />
            <span>Create Your First Listing</span>
          </button>
        </div>

      </div>
    </div>
  </AppLayout>
</template>