<script setup>
import { ref, computed } from "vue";
import { 
  ChevronLeftIcon,
  MapPinIcon, 
  PlusIcon,
  HomeIcon,
  MagnifyingGlassIcon,
  AdjustmentsHorizontalIcon,
  SparklesIcon,
  CheckCircleIcon,
  ClockIcon,
} from "@heroicons/vue/24/outline";
import AppLayout from "@/layouts/app/AppSidebarLayout.vue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
  listings: {
    type: Array,
    required: true,
  },
});

const searchQuery = ref("");
const sortBy = ref("recent");
const viewMode = ref("grid"); // grid or list

// Filter and sort listings
const filteredListings = computed(() => {
  let results = props.listings;
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    results = results.filter(listing => 
      listing.name?.toLowerCase().includes(query) ||
      listing.location?.toLowerCase().includes(query)
    );
  }
  
  // Sort listings
  results = [...results].sort((a, b) => {
    switch (sortBy.value) {
      case 'price-low':
        return a.base_price - b.base_price;
      case 'price-high':
        return b.base_price - a.base_price;
      case 'name':
        return (a.name || '').localeCompare(b.name || '');
      case 'recent':
      default:
        return b.id - a.id;
    }
  });
  
  return results;
});

// Format price with commas
const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US').format(price);
};

// Navigation helpers
const goToCreateListing = () => {
  router.visit('/listings/create');
};

const goToListing = (listingId) => {
  router.visit(`/listings/${listingId}`);
};

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
          <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
          <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl"></div>
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
              <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium mb-3">
                <HomeIcon class="w-4 h-4" />
                Property Portfolio
              </div>
              <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                Your Listings
              </h1>
              <div class="flex items-center gap-4 text-gray-600 dark:text-gray-400">
                <div class="flex items-center gap-2">
                  <CheckCircleIcon class="w-5 h-5 text-green-500" />
                  <span class="font-semibold text-gray-900 dark:text-white">{{ props.listings.length }}</span>
                  <span>{{ props.listings.length === 1 ? 'property' : 'properties' }}</span>
                </div>
                <span class="text-gray-300 dark:text-gray-600">•</span>
                <span>Manage your rental portfolio</span>
              </div>
            </div>

            <!-- Add Listing Button -->
            <button 
              @click="goToCreateListing" 
              class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105 whitespace-nowrap"
            >
              <PlusIcon class="w-5 h-5" />
              <span>Add New Listing</span>
            </button>
          </div>

          <!-- Search and Filter Bar -->
          <div v-if="props.listings.length > 0" class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="flex-1 relative group">
              <MagnifyingGlassIcon class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-gray-600 dark:group-focus-within:text-gray-300 transition-colors" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by name or location..."
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
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name">Name: A to Z</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">

        <!-- Listings Grid -->
        <div v-if="filteredListings.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          
          <div 
            v-for="listing in filteredListings" 
            :key="listing.id" 
            @click="goToListing(listing.id)"
            class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-xl transition-all duration-300 cursor-pointer"
          >
            <!-- Image Container -->
            <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
              <!-- Background Icon -->
              <div class="absolute inset-0 flex items-center justify-center">
                <HomeIcon class="w-20 h-20 text-gray-300 dark:text-gray-600 group-hover:scale-110 transition-transform" />
              </div>
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
              
              <!-- Status Badge -->
              <div class="absolute top-3 right-3 px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">
                Active
              </div>
            </div>

            <!-- Card Content -->
            <div class="p-5">
              
              <!-- Location -->
              <div class="flex items-center gap-1.5 mb-2">
                <MapPinIcon class="w-4 h-4 text-gray-500 dark:text-gray-400 flex-shrink-0" />
                <span class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                  {{ listing.location }}
                </span>
              </div>

              <!-- Title -->
              <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3 line-clamp-2 min-h-[3rem] group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors">
                {{ listing.name ?? `Listing #${listing.id}` }}
              </h3>

              <!-- Price -->
              <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-baseline gap-1">
                  <span class="text-2xl font-bold text-gray-900 dark:text-white">
                    ${{ formatPrice(listing.base_price) }}
                  </span>
                  <span class="text-sm text-gray-500 dark:text-gray-400">
                    / night
                  </span>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- No Search Results -->
        <div v-else-if="props.listings.length > 0 && filteredListings.length === 0" class="text-center py-20">
          <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <MagnifyingGlassIcon class="w-12 h-12 text-gray-400" />
            </div>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            No listings found
          </h3>
          <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
            We couldn't find any listings matching "<span class="font-semibold text-gray-700 dark:text-gray-300">{{ searchQuery }}</span>"
          </p>
          <button
            @click="searchQuery = ''"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
          >
            Clear search
          </button>
        </div>

        <!-- Empty State - No Listings -->
        <div v-else class="text-center py-20">
          <div class="relative w-40 h-40 mx-auto mb-8">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full blur-2xl"></div>
            <div class="relative w-40 h-40 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center">
              <HomeIcon class="w-20 h-20 text-gray-400 dark:text-gray-500" />
            </div>
          </div>
          
          <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium mb-4">
            <SparklesIcon class="w-4 h-4" />
            Get Started
          </div>

          <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
            Welcome to your hosting journey
          </h3>
          <p class="text-lg text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-10">
            List your space and start earning by hosting guests from around the world
          </p>
          
          <!-- Features List -->
          <div class="max-w-2xl mx-auto mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center mb-4">
                  <span class="text-white font-bold text-lg">1</span>
                </div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 text-lg">Add your space</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Share details about your property and amenities</p>
              </div>
              
              <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl bg-purple-500 flex items-center justify-center mb-4">
                  <span class="text-white font-bold text-lg">2</span>
                </div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 text-lg">Set your price</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Choose competitive nightly rates that work for you</p>
              </div>
              
              <div class="flex flex-col items-center text-center p-6 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-600 hover:shadow-lg transition-all">
                <div class="w-12 h-12 rounded-xl bg-green-500 flex items-center justify-center mb-4">
                  <span class="text-white font-bold text-lg">3</span>
                </div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2 text-lg">Start hosting</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Welcome your first guests and earn income</p>
              </div>
            </div>
          </div>

          <button 
            @click="goToCreateListing" 
            class="inline-flex items-center gap-3 px-10 py-5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-lg font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:scale-105"
          >
            <PlusIcon class="w-6 h-6" />
            <span>Create your first listing</span>
          </button>
        </div>

      </div>
    </div>
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