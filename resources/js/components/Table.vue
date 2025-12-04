<template>
  <table class="w-full border-collapse border border-gray-300">
    <thead>
      <tr>
        <th v-for="col in columns" :key="col" class="border px-4 py-2 bg-gray-200">
          {{ col }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in data" :key="index" class="hover:bg-gray-100">
        <td v-for="col in columns" :key="col" class="border px-4 py-2">{{ row[col.toLowerCase().replace(' ', '_')] }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';

export default defineComponent({
  props: {
    columns: { type: Array as PropType<string[]>, required: true },
    data: { type: Array as PropType<any[]>, required: true },
  },
});
</script>
