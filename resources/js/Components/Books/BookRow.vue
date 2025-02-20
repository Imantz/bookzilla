<script setup>
defineProps({
    book: Object,
    isProcessing: Boolean,
    incrementedBookID: Number
});

const emit = defineEmits(["update:incrementPopularity"]);

</script>

<template>
    <tr class="border-b" :class="{'bg-green-100': book.id === incrementedBookID}">
        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ book.title }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ book.authors.map(author => author.name).join(', ') }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ book.purchases }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ book.total_purchases }}</td>
        <td class="px-6 py-4 text-sm">
            <button 
                @click="emit('update:incrementPopularity', book.id)"
                class="py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200"
                :disabled="isProcessing"
            >
                Nopirkt
            </button>
        </td>
    </tr>
</template>
