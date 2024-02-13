<template>
  <div class="mb-2 flex items-center justify-between">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
    <div class="flex items-center">
      <label class="mr-2">Change Date Period</label>
      <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <!--    Active Customers-->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="text-lg font-semibold block mb-2">Active Customers</label>
      <template v-if="!loading.customersCount">
        <span class="text-3xl font-semibold">{{ customersCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
    <!--/    Active Customers-->
    
    
  </div>

  
    <div class="bg-white py-6 px-5 rounded-lg shadow">
      <label class="text-lg font-semibold block mb-2">Latest Customers</label>
      <template v-if="!loading.latestCustomers">
        <router-link :to="{name: 'app.customers.view', params: {id: c.id}}" v-for="c of latestCustomers" :key="c.id"
                     class="mb-3 flex">
          <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
            <UserIcon class="w-5"/>
          </div>
          <div>
            <h3>{{ c.first_name }} {{ c.last_name }}</h3>
            <p>{{ c.email }}</p>
          </div>
        </router-link>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
  

</template>

<script setup>
import {UserIcon} from '@heroicons/vue/24/outline'
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
import axiosClient from "../axios.js";
import {computed, onMounted, ref} from "vue";
import Spinner from "../components/core/Spinner.vue";
import CustomInput from "../components/core/CustomInput.vue";
import {useStore} from "vuex";

const store = useStore();
const dateOptions = computed(() => store.state.dateOptions);
const chosenDate = ref('all')

const loading = ref({
  customersCount: true,
  latestCustomers: true,
})
function updateDashboard() {
  loading.customersCount = true;
  loading.latestCustomers = true;
  axiosClient.get('/dashboard', {params: {date: chosenDate.value}})
    .then(response => {
      customersCount.value = response.data.customersCount;
      latestCustomers.value = response.data.latestCustomers;
    })
    .finally(() => {
      loading.customersCount = false;
      loading.latestCustomers = false;
    })
}
const customersCount = ref(0);
const latestCustomers = ref([]);


function onDatePickerChange() {
  updateDashboard()
}

onMounted(() => updateDashboard())

</script>

<style scoped>

</style>