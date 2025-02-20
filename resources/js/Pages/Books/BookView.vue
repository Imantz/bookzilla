<script setup>
import { onMounted } from "vue";
import { Head } from '@inertiajs/vue3';
import BookFilters from "@/Components/Books/BookFilters.vue";
import BookList from "@/Components/Books/BookList.vue";
import { useBookStore } from "@/stores/bookStore";

const props = defineProps({
    books: Array,
});

const bookStore = useBookStore();

onMounted(() => {
    bookStore.setBooks(props.books);
});

</script>

<template>
    <Head title="Books" />
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Grāmatas</h1>
        <BookFilters />
        <BookList />
    </div>
</template>
