<template>
  <div>
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from 'vue';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

// Register necessary components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Define props to receive data from the parent component
const props = defineProps({
  juniorHighData: Array,
  seniorHighData: Array,
});

// Reactive chart data
const chartData = ref({
  labels: ['Total Items',  'Borrowed Items', 'Overdue Items', 'Damaged Items'],
  datasets: [
    {
      label: 'Junior High School',
      backgroundColor: '#42A5F5',
      data: props.juniorHighData,
    },
    {
      label: 'Senior High School',
      backgroundColor: '#FFA726',
      data: props.seniorHighData,
    },
  ],
});

// Watch for changes in props and update chart data
watch(props, (newProps) => {
  chartData.value.datasets[0].data = newProps.juniorHighData;
  chartData.value.datasets[1].data = newProps.seniorHighData;
});

// Define chart options
const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
});
</script>
