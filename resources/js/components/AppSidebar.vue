<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import { type NavItem } from '@/types'
import { Link } from '@inertiajs/vue3'
import { 
  BookOpen, 
  Folder, 
  LayoutGrid,
  Home,
  Tag,
  Calendar,
 
  TrendingUp,
  Sparkles
} from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'

// Enhanced navigation items with more options
const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutGrid,
    isActive: true,
  },
  {
    title: 'Listings',
    href: '/listings',
    icon: Home,
  },
  {
    title: 'Pricing Rules',
    href: '/pricing-rules',
    icon: Tag,
  },
  {
    title: 'Calendar Prices',
    href: '/calendar-prices',
    icon: Calendar,
  },
]

</script>

<template>
  <Sidebar collapsible="icon" variant="inset" class="sidebar-enhanced">
    <!-- Header with Logo -->
    <SidebarHeader class="border-b border-sidebar-border">
      <SidebarMenu>
        <!-- <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child class="logo-button">
            <Link href="/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-sidebar-accent transition-all group">
              <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg blur-sm opacity-0 group-hover:opacity-50 transition-opacity"></div>
                <AppLogo class="relative" />
              </div>
              <div class="flex flex-col items-start">
                <span class="font-bold text-base text-sidebar-foreground group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                  Property Hub
                </span>
                <span class="text-xs text-muted-foreground">
                  Manage & Optimize
                </span>
              </div>
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem> -->
      </SidebarMenu>
      
      <!-- Quick Stats Badge -->
      <!-- <div class="px-4 py-2 mt-2">
        <div class="flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg border border-blue-200/50 dark:border-blue-700/30">
          <Sparkles class="w-4 h-4 text-blue-600 dark:text-blue-400" />
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-blue-900 dark:text-blue-100">Pro Features</p>
            <p class="text-xs text-blue-600 dark:text-blue-400">All Unlocked</p>
          </div>
        </div>
      </div> -->
    </SidebarHeader>

    <!-- Main Navigation -->
    <SidebarContent class="px-2 py-4">
      <div class="mb-2 px-3">
        <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wider">
          Main Menu
        </p>
      </div>
      <NavMain :items="mainNavItems" />
      
      <!-- Divider -->
      <div class="my-4 border-t border-sidebar-border"></div>

    </SidebarContent>

    <!-- Footer -->
    <SidebarFooter class="border-t border-sidebar-border p-2">
      <!-- Performance Badge -->
      <div class="px-2 mb-2">
        <div class="flex items-center gap-2 px-3 py-2 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200/50 dark:border-green-700/30">
          <TrendingUp class="w-4 h-4 text-green-600 dark:text-green-400" />
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-green-900 dark:text-green-100">Performance</p>
            <p class="text-xs text-green-600 dark:text-green-400">+24% this month</p>
          </div>
        </div>
      </div>
      
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>

  <slot />
</template>

<style scoped>
/* Enhanced sidebar styling */
.sidebar-enhanced {
  --sidebar-width: 280px;
  --sidebar-width-icon: 80px;
}

/* Logo button enhancements */
.logo-button :deep(.sidebar-menu-button) {
  height: auto;
  padding: 0;
}

/* Smooth transitions for all interactive elements */
* {
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for sidebar content */
:deep(.sidebar-content) {
  scrollbar-width: thin;
  scrollbar-color: rgb(203 213 225) transparent;
}

:deep(.sidebar-content)::-webkit-scrollbar {
  width: 6px;
}

:deep(.sidebar-content)::-webkit-scrollbar-track {
  background: transparent;
}

:deep(.sidebar-content)::-webkit-scrollbar-thumb {
  background-color: rgb(203 213 225);
  border-radius: 3px;
}

:deep(.dark .sidebar-content)::-webkit-scrollbar-thumb {
  background-color: rgb(71 85 105);
}

/* Enhanced menu item styling */
:deep(.sidebar-menu-button) {
  border-radius: 0.5rem;
  transition: all 0.2s;
}

:deep(.sidebar-menu-button:hover) {
  transform: translateX(2px);
}

:deep(.sidebar-menu-button[data-active="true"]) {
  background: linear-gradient(135deg, rgb(59 130 246 / 0.1) 0%, rgb(147 51 234 / 0.1) 100%);
  border-left: 3px solid rgb(59 130 246);
  font-weight: 600;
}

:deep(.dark .sidebar-menu-button[data-active="true"]) {
  background: linear-gradient(135deg, rgb(59 130 246 / 0.2) 0%, rgb(147 51 234 / 0.2) 100%);
  border-left-color: rgb(96 165 250);
}

/* Badge animations */
@keyframes pulse-glow {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.8;
  }
}

.sidebar-enhanced :deep(.badge-glow) {
  animation: pulse-glow 2s ease-in-out infinite;
}

/* Icon hover effects */
:deep(.sidebar-menu-button svg) {
  transition: transform 0.2s ease;
}

:deep(.sidebar-menu-button:hover svg) {
  transform: scale(1.1);
}
</style>