<script setup>
import { router, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { ChevronLeftIcon, ChevronRightIcon, FunnelIcon, XMarkIcon, MagnifyingGlassIcon, CalendarIcon } from "@heroicons/vue/24/outline";

// Props from Laravel controller
const props = defineProps({
    prices: Object,
    filters: Object,
});

// Local filter state
const listing_id = ref(props.filters.listing_id || "");
const start_date = ref(props.filters.start_date || "");
const end_date = ref(props.filters.end_date || "");
const showFilters = ref(false);

// Check if filters are active
const hasActiveFilters = computed(() => {
    return listing_id.value || start_date.value || end_date.value;
});

// Apply filters
const applyFilters = () => {
    router.get("/calendar-prices", {
        listing_id: listing_id.value,
        start_date: start_date.value,
        end_date: end_date.value,
    }, {
        preserveState: true,
        preserveScroll: true
    });
    showFilters.value = false;
};

// Clear filters
const resetFilters = () => {
    listing_id.value = "";
    start_date.value = "";
    end_date.value = "";
    applyFilters();
};

// Format date nicely
const formatDate = (dateString) => {
    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
};

// Format price
const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US').format(price);
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
                        <Link href="/listings"
                            class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors">
                            <ChevronLeftIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                        </Link>

                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                                Calendar Pricing
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ prices.total }} prices across your listings
                            </p>
                        </div>
                    </div>

                    <!-- Filter Toggle Button -->
                    <button @click="showFilters = !showFilters"
                        class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-full hover:border-gray-900 dark:hover:border-gray-400 transition-all"
                        :class="hasActiveFilters ? 'bg-gray-900 text-white dark:bg-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300'">
                        <FunnelIcon class="w-4 h-4" />
                        <span class="font-medium text-sm">Filters</span>
                        <span v-if="hasActiveFilters" class="w-1.5 h-1.5 bg-white dark:bg-gray-900 rounded-full"></span>
                    </button>
                </div>

                <!-- Filter Panel (Collapsible) -->
                <transition enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2">
                    <div v-if="showFilters" class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                            <!-- Listing ID -->
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">
                                    Listing ID
                                </label>
                                <div class="relative">
                                    <MagnifyingGlassIcon
                                        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                                    <input type="text" v-model="listing_id" placeholder="Search by ID"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow" />
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">
                                    Start Date
                                </label>
                                <div class="relative">
                                    <CalendarIcon
                                        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                                    <input type="date" v-model="start_date"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow" />
                                </div>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label
                                    class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2 uppercase tracking-wide">
                                    End Date
                                </label>
                                <div class="relative">
                                    <CalendarIcon
                                        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                                    <input type="date" v-model="end_date"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent dark:bg-gray-800 dark:text-white transition-shadow" />
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <button v-if="hasActiveFilters" @click="resetFilters"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 underline hover:text-gray-900 dark:hover:text-white transition-colors">
                                Clear all
                            </button>
                            <div v-else></div>

                            <div class="flex gap-3">
                                <button @click="showFilters = false"
                                    class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    Cancel
                                </button>
                                <button @click="applyFilters" class="px-6 py-2.5 
         bg-red-900 dark:bg-gray-800 
         text-white dark:text-yellow-400 
         rounded-lg text-sm font-medium 
         hover:bg-red-700 dark:hover:bg-gray-700 
         transition-colors shadow-sm">
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
                <div v-if="listing_id"
                    class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-sm">
                    <span class="text-gray-700 dark:text-gray-300">Listing: {{ listing_id }}</span>
                    <button @click="listing_id = ''; applyFilters()"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
                        <XMarkIcon class="w-4 h-4 text-gray-500" />
                    </button>
                </div>
                <div v-if="start_date"
                    class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-sm">
                    <span class="text-gray-700 dark:text-gray-300">From: {{ start_date }}</span>
                    <button @click="start_date = ''; applyFilters()"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
                        <XMarkIcon class="w-4 h-4 text-gray-500" />
                    </button>
                </div>
                <div v-if="end_date"
                    class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full text-sm">
                    <span class="text-gray-700 dark:text-gray-300">To: {{ end_date }}</span>
                    <button @click="end_date = ''; applyFilters()"
                        class="hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-0.5">
                        <XMarkIcon class="w-4 h-4 text-gray-500" />
                    </button>
                </div>
            </div>

            <!-- Price Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                <div v-for="item in props.prices.data" :key="item.id"
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-200 overflow-hidden group cursor-pointer">
                    <!-- Card Content -->
                    <div class="p-6">

                        <!-- Date Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ formatDate(item.date) }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ item.date }}
                                </p>
                            </div>

                            <!-- Calendar Icon -->
                            <div
                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                                <CalendarIcon class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                            </div>
                        </div>

                        <!-- Listing Info -->
                        <div class="mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ item.listing.name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                ID: {{ item.listing_id }}
                            </p>
                        </div>

                        <!-- Price -->
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                                    Daily Rate
                                </p>
                                <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ formatPrice(item.calculated_price) }}
                                    <span class="text-base font-normal text-gray-500 dark:text-gray-400">MAD</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Empty State -->
            <div v-if="!prices.data || prices.data.length === 0" class="text-center py-16">
                <div
                    class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <CalendarIcon class="w-12 h-12 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    No prices found
                </h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">
                    Try adjusting your filters to see more results
                </p>
            </div>

            <!-- Pagination -->
            <div v-if="prices.data && prices.data.length > 0" class="flex items-center justify-center gap-2 mt-12">

                <!-- Previous Button -->
                <Link v-if="prices.prev_page_url" :href="prices.prev_page_url"
                    class="p-2.5 rounded-full border border-gray-300 dark:border-gray-600 hover:border-gray-900 dark:hover:border-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    <ChevronLeftIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </Link>
                <div v-else class="p-2.5 rounded-full border border-gray-200 dark:border-gray-700 opacity-40">
                    <ChevronLeftIcon class="w-5 h-5 text-gray-400" />
                </div>

                <!-- Page Info -->
                <div
                    class="px-6 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ prices.current_page }}
                    </span>
                    <span class="text-sm text-gray-400 mx-1">/</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ prices.last_page }}
                    </span>
                </div>

                <!-- Next Button -->
                <Link v-if="prices.next_page_url" :href="prices.next_page_url"
                    class="p-2.5 rounded-full border border-gray-300 dark:border-gray-600 hover:border-gray-900 dark:hover:border-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    <ChevronRightIcon class="w-5 h-5 text-gray-700 dark:text-gray-300" />
                </Link>
                <div v-else class="p-2.5 rounded-full border border-gray-200 dark:border-gray-700 opacity-40">
                    <ChevronRightIcon class="w-5 h-5 text-gray-400" />
                </div>

            </div>
        </div>

    </div>
</template>