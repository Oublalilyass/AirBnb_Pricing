<template>
  <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded p-6 w-1/2">
      <button class="float-right text-gray-500" @click="$emit('close')">×</button>
      <div class="mt-4">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
