import { defineStore } from 'pinia';
import { getBookQueryParams, buildBookQueryParams, fetchData, sortByField } from "@/utils/utils"


export const useBookStore = defineStore('book', {
    state: () => ({
        books: [],
        filters: getBookQueryParams(),
        incrementedBookID: null,
    }),
    actions: {
        setBooks(books) {
            this.books = books;
        },
        // Clientside(browser) filters.
        applyFilters() {
            let filtered = [...this.books];

            filtered = sortByField(filtered, this.filters.sortBy, this.filters.sortOrder);
            this.books = filtered;
        },

        setSearchQuery(searchQuery) {
            this.filters.q = searchQuery;
            this.updateURL();
            this.fetchBooks();
        },
        setSortBy(key) {
            if (this.filters.sortBy === key) {
                this.filters.sortOrder = this.filters.sortOrder === "asc" ? "desc" : "asc";
            } else {
                this.filters.sortBy = key;
                this.filters.sortOrder = "asc";
            }
            this.updateURL();
            this.applyFilters();
        },
        setSortOrder(sortOrder) {
            this.filters.sortOrder = sortOrder;
            this.updateURL();
            this.applyFilters();
        },
        setDateFrom(dateFrom) {
            this.filters.dateFrom = dateFrom;
            this.updateURL();
            this.fetchBooks();
        },
        setDateTo(dateTo) {
            this.filters.dateTo = dateTo;
            this.updateURL();
            this.fetchBooks();
        },
        incrementPopularity(id) {
            const book = this.books.find(book => book.id === id);
            if (book) {
                book.purchases += 1;
                book.total_purchases += 1;
                this.incrementedBookID = id;
            }
            this.applyFilters();
        },
        async fetchBooks() {
            try {
                const data = await fetchData(
                    route('books.apiIndex'),
                    buildBookQueryParams(this.filters)
                );

                this.setBooks(data);
            } catch (error) {
                console.error('Error fetching books:', error);
            }
            this.applyFilters();
        },
        updateURL() {
            const params = buildBookQueryParams(this.filters);

            // Update the browser's URL without reloading the page
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({ path: newUrl }, '', newUrl);
        }
    },
});
