const today = new Date().toISOString().split("T")[0];
const oneMonthAgo = new Date();
oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
const oneMonthAgoFormatted = oneMonthAgo.toISOString().split("T")[0];

export function getBookQueryParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        q: params.get('q') || '',
        sortBy: params.get('sort_by') || 'purchases',
        sortOrder: params.get('sort_order') || 'desc',
        dateFrom: params.get('date_from') || oneMonthAgoFormatted,
        dateTo: params.get('date_to') || today,
    };
}

export function buildBookQueryParams(filters) {
    const params = new URLSearchParams();

    if (filters.q) params.append('q', filters.q);
    if (filters.sortBy) params.append('sort_by', filters.sortBy);
    if (filters.sortOrder) params.append('sort_order', filters.sortOrder);
    if (filters.dateFrom) params.append('date_from', filters.dateFrom);
    if (filters.dateTo) params.append('date_to', filters.dateTo);

    return params;
}

export async function fetchData(url, query) {
    try {
        const response = await fetch(url + '?' + query, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Error fetching data');
        }

        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Error fetching data:', error);
        throw error; // rethrow to be handled at the call site
    }
}

export function sortByField(array, sortBy, sortOrder) {
    return array.sort((a, b) => {
        const valueA = a[sortBy];
        const valueB = b[sortBy];

        // Check if the values are numbers
        if (typeof valueA === 'number' && typeof valueB === 'number') {
            return sortOrder === 'asc' ? valueA - valueB : valueB - valueA;
        }

        // For strings
        if (typeof valueA === 'string' && typeof valueB === 'string') {
            return sortOrder === 'asc'
                ? valueA.localeCompare(valueB)
                : valueB.localeCompare(valueA);
        }

        // Fallback for other types, in case they aren't numbers or strings
        return 0;
    });
}

