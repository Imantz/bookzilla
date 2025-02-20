<script setup>
import { watch } from "vue";
import { useBookStore } from "@/stores/bookStore";

const bookStore = useBookStore();
let searchTimeout = null;

watch(() => bookStore.filters.q, (newSearch) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        bookStore.setSearchQuery(newSearch);
    }, 1200);
});

watch(() => bookStore.filters.dateFrom, (newDate) => {
    bookStore.setDateFrom(newDate);
});

watch(() => bookStore.filters.dateTo, (newDate) => {
    bookStore.setDateTo(newDate);
});
</script>

<template>
    <div class="mb-4 flex gap-4">
        <label class="flex flex-col">
            <span class="text-sm font-medium">Meklēt grāmatu vai autoru</span>
            <input 
                type="search" 
                v-model="bookStore.filters.q" 
                placeholder="Meklēt" 
                class="px-4 py-2 border rounded-md"
            />
        </label>
        
        <label class="flex flex-col">
            <span class="text-sm font-medium">Datumi kad nopirka no</span>
            <input 
                type="date" 
                v-model="bookStore.filters.dateFrom" 
                class="px-4 py-2 border rounded-md"
            />
        </label>
        
        <label class="flex flex-col">
            <span class="text-sm font-medium">Datumi kad nopirka līdz</span>
            <input 
                type="date" 
                v-model="bookStore.filters.dateTo" 
                class="px-4 py-2 border rounded-md"
            />
        </label>
    </div>
</template>
