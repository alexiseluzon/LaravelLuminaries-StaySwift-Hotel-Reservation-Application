<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import BarChart from '@/Components/BarChart.vue';

const props = defineProps({
  totals: Object,
  juniorHighInventory: Object,
  seniorHighInventory: Object,
});

// Prepare data for chart
const juniorHighData = [
  props.juniorHighInventory.item_quantity,
  props.juniorHighInventory.borrowed_items,
  props.juniorHighInventory.overdue_items,
  props.juniorHighInventory.damaged_items,
];

const seniorHighData = [
  props.seniorHighInventory.item_quantity,
  props.seniorHighInventory.borrowed_items,
  props.seniorHighInventory.overdue_items,
  props.seniorHighInventory.damaged_items,
];

// Method to download the report
const downloadReport = () => {
  fetch(route('generateReport'), { 
    method: 'get',
    headers: {
      'Accept': 'text/csv',
      'X-Requested-With': 'XMLHttpRequest',
    },
  })
  .then(response => response.blob())
  .then(blob => {
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'SNAIC Inventory Report.csv';
    document.body.appendChild(a);
    a.click();
    a.remove();
  })
  .catch(error => {
    console.error('Error generating report:', error);
  });
};
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center">
        <i class="fas mr-2"></i>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <font-awesome-icon icon="pie-chart" class="h-6 w-6 mr-2 text-gray-600" />
          Dashboard
        </h2>
      </div>
    </template>

    <div class="p-6">
      <!-- Overall Inventory Totals Section -->
      <section class="mb-8">
        <h3 class="font-semibold text-lg text-gray-800">
          <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
          Overall Inventory Totals
        </h3>
        <ul class="list-disc list-inside ml-4">
          <li>
          <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
            Total Items: <span class="font-medium">{{ totals.item_quantity }}</span>
          </li>
          <li>
            <font-awesome-icon icon="handshake" class="h-6 w-6 mr-2 text-gray-600" />
            Borrowed Items: <span class="font-medium">{{ totals.borrowed_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="shopping-cart" class="h-6 w-6 mr-2 text-gray-600" />
            Overdue Items: <span class="font-medium">{{ totals.overdue_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="tools" class="h-6 w-6 mr-2 text-gray-600" />
            Damaged Items: <span class="font-medium">{{ totals.damaged_items }}</span>
          </li>
        </ul>
      </section>

      <!-- Junior High School Inventory Section -->
      <section class="mb-8" v-if="juniorHighInventory">
        <h3 class="font-semibold text-lg text-gray-800">
          <font-awesome-icon icon="user-graduate" class="h-6 w-6 mr-2 text-gray-600" />
          Junior High School Inventory
        </h3>
        <ul class="list-disc list-inside ml-4">
          <li>
            <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
            Total Items: <span class="font-medium">{{ juniorHighInventory.item_quantity }}</span>
          </li>
          <li>
            <font-awesome-icon icon="handshake" class="h-6 w-6 mr-2 text-gray-600" />
            Borrowed Items: <span class="font-medium">{{ props.juniorHighInventory.borrowed_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="shopping-cart" class="h-6 w-6 mr-2 text-gray-600" />
            Overdue Items: <span class="font-medium">{{ props.juniorHighInventory.overdue_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="tools" class="h-6 w-6 mr-2 text-gray-600" />
            Damaged Items: <span class="font-medium">{{ props.juniorHighInventory.damaged_items }}</span>
          </li>
        </ul>
      </section>

      <!-- Senior High School Inventory Section -->
      <section class="mb-8" v-if="seniorHighInventory">
        <h3 class="font-semibold text-lg text-gray-800">
          <font-awesome-icon icon="graduation-cap" class="h-6 w-6 mr-2 text-gray-600" />
          Senior High School Inventory
        </h3>
        <ul class="list-disc list-inside ml-4">
          <li>
            <font-awesome-icon icon="clipboard-list" class="h-6 w-6 mr-2 text-gray-600" />
            Total Items: <span class="font-medium">{{ seniorHighInventory.item_quantity }}</span>
          </li>
          <li>
            <font-awesome-icon icon="handshake" class="h-6 w-6 mr-2 text-gray-600" />
            Borrowed Items: <span class="font-medium">{{ props.seniorHighInventory.borrowed_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="shopping-cart" class="h-6 w-6 mr-2 text-gray-600" />
            Overdue Items: <span class="font-medium">{{ props.seniorHighInventory.overdue_items }}</span>
          </li>
          <li>
            <font-awesome-icon icon="tools" class="h-6 w-6 mr-2 text-gray-600" />
            Damaged Items: <span class="font-medium">{{ props.seniorHighInventory.damaged_items }}</span>
          </li>
        </ul>
      </section>

      <!-- Chart Section -->
      <section class="mt-8">
        <h3 class="font-semibold text-lg text-gray-800 mb-4">Inventory Chart</h3>
        <div class="w-full h-64">
          <BarChart :juniorHighData="juniorHighData" :seniorHighData="seniorHighData" />
        </div>
      </section>

      <!-- Generate Report Button -->
      <section class="mt-8">
        <button @click="downloadReport" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
          <font-awesome-icon icon="file-download" class="h-6 w-6 mr-2" />
          Generate Report
        </button>
      </section>
    </div>
  </AuthenticatedLayout>
</template>
