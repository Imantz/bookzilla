<script setup>
import BookRow from "@/Components/Books/BookRow.vue";
import Header from "@/Components/Books/BookHeader.vue";
import { useForm } from '@inertiajs/vue3';
import { useBookStore } from '@/stores/bookStore';

const bookStore = useBookStore();

const headers = [
    { label: "Nosaukums", key: "title", sortable: true },
    { label: "Autori", key: "authors", sortable: false },
    { label: "Nopirkts", key: "purchases", sortable: true },
    { label: "Kopā", key: "total_purchases", sortable: true },
    { label: "Darbība", key: "actions", sortable: false }
];
const form = useForm({});

function incrementPopularity(bookId) {
    form.post(route('book.incrementPopularity', bookId), {
        preserveScroll: true,
        onSuccess: () => bookStore.incrementPopularity(bookId),
        onError: (errors) => console.error('Error incrementing popularity:', errors)
    });
}

</script>

<template>
    <table class="min-w-full table-auto bg-white shadow-md rounded-lg overflow-hidden">
        <Header 
            :headers="headers" 
            :sortBy="bookStore.filters.sortBy" 
            :sortOrder="bookStore.filters.sortOrder" 
            @sort="bookStore.setSortBy" 
        />
        <tbody>
            <BookRow 
                v-for="book in bookStore.books" 
                :key="book.id" 
                :book="book"
                :incrementedBookID="bookStore.incrementedBookID"
                @update:incrementPopularity="incrementPopularity" 
            />
        </tbody>
    </table>
</template>
