<script setup>
import { ref, computed } from "vue";
import { 
  ChevronLeftIcon,
  MapPinIcon, 
  PlusIcon,
  HomeIcon,
  MagnifyingGlassIcon,
  AdjustmentsHorizontalIcon
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

// Filter listings based on search
const filteredListings = computed(() => {
  if (!searchQuery.value) return props.listings;
  
  const query = searchQuery.value.toLowerCase();
  return props.listings.filter(listing => 
    listing.name?.toLowerCase().includes(query) ||
    listing.location?.toLowerCase().includes(query)
  );
});

// Format price with commas
const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US').format(price);
};
</script>

<template>
  <AppLayout>
    <!-- Page Container -->
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
      
      <!-- Header Section with Background -->
      <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
          
          <!-- Back Button -->
          <button 
            @click="router.visit('/dashboard')"
            class="inline-flex items-center gap-2 mb-6 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors group"
          >
            <ChevronLeftIcon class="w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:-translate-x-1 transition-transform" />
            <span class="font-medium text-gray-700 dark:text-gray-300 text-sm">Back</span>
          </button>

          <!-- Page Header -->
          <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
              <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-2">
                Your Listings
              </h1>
              <p class="text-gray-600 dark:text-gray-400">
                {{ props.listings.length }} {{ props.listings.length === 1 ? 'property' : 'properties' }} • Manage your rental portfolio
              </p>
            </div>

            <!-- Add Listing Button -->
            <button 
              @click="$inertia.get('/listings/create')" 
              class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-sm whitespace-nowrap"
            >
              <PlusIcon class="w-5 h-5" />
              <span>Add listing</span>
            </button>
          </div>

          <!-- Search and Filter Bar -->
          <div v-if="props.listings.length > 0" class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="flex-1 relative">
              <MagnifyingGlassIcon class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by name or location..."
                class="w-full pl-11 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow"
              />
            </div>

            <!-- Sort Dropdown -->
            <div class="relative sm:w-48">
              <AdjustmentsHorizontalIcon class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" />
              <select
                v-model="sortBy"
                class="w-full pl-11 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white appearance-none cursor-pointer transition-shadow"
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
            @click="$inertia.visit(`/listings/${listing.id}`)"
            class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-300 cursor-pointer"
          >
            <!-- Image Container -->
            <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
              <!-- Gradient Overlay with Icon -->
              <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-gray-300 dark:text-gray-600">
                  <HomeIcon class="w-20 h-20" />
                </div>
              </div>
              
              <!-- Hover Overlay -->
              <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
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
              <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3 line-clamp-2 min-h-[3rem]">
                {{ listing.name ?? `Listing #${listing.id}` }}
              </h3>

              <!-- Price -->
              <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <div class="flex items-baseline gap-1">
                  <span class="text-xl font-semibold text-gray-900 dark:text-white">
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
          <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
            <MagnifyingGlassIcon class="w-12 h-12 text-gray-400" />
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
            No listings found
          </h3>
          <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-6">
            We couldn't find any listings matching "{{ searchQuery }}"
          </p>
          <button
            @click="searchQuery = ''"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors"
          >
            Clear search
          </button>
        </div>

        <!-- Empty State - No Listings -->
        <div v-else class="text-center py-20">
          <div class="w-32 h-32 mx-auto mb-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center">
            <HomeIcon class="w-16 h-16 text-gray-400 dark:text-gray-500" />
          </div>
          
          <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-3">
            Welcome to your hosting journey
          </h3>
          <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8 text-lg">
            List your space and start earning by hosting guests from around the world
          </p>
          
          <!-- Features List -->
          <div class="max-w-2xl mx-auto mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
              <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center flex-shrink-0">
                  <span class="text-white dark:text-gray-900 font-semibold text-sm">1</span>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Add your space</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Share details about your property</p>
                </div>
              </div>
              
              <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center flex-shrink-0">
                  <span class="text-white dark:text-gray-900 font-semibold text-sm">2</span>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Set your price</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Choose competitive nightly rates</p>
                </div>
              </div>
              
              <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-900 dark:bg-white flex items-center justify-center flex-shrink-0">
                  <span class="text-white dark:text-gray-900 font-semibold text-sm">3</span>
                </div>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white mb-1">Start hosting</h4>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Welcome your first guests</p>
                </div>
              </div>
            </div>
          </div>

          <button 
            @click="$inertia.get('/listings/create')" 
            class="inline-flex items-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-base font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-sm"
          >
            <PlusIcon class="w-6 h-6" />
            <span>Create your first listing</span>
          </button>
        </div>

      </div>
    </div>
  </AppLayout>
</template>