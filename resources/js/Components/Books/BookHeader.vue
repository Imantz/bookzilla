<script setup>
defineProps({
    headers: Array, // Example: [{ label: "Nosaukums", key: "title", sortable: true }]
    sortBy: String,
    sortOrder: String,
});

const emit = defineEmits(["sort"]);

const toggleSort = (key) => {
    emit("sort", key);
};
</script>

<template>
    <thead>
        <tr class="bg-gray-100">
            <th 
                v-for="header in headers" 
                :key="header.key" 
                class="px-6 py-3 text-left text-sm font-medium text-gray-700"
                :class="{ 'cursor-pointer': header.sortable }" 
                @click="header.sortable ? toggleSort(header.key) : null"
            >
                {{ header.label }}
                <span v-if="header.sortable">
                    <span v-if="sortBy === header.key">{{ sortOrder === 'asc' ? '▼' : '▲' }}</span>
                </span>
            </th>
        </tr>
    </thead>
</template>
