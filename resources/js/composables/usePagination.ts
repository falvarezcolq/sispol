import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

export interface PaginationData<T> {
    data: T[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    from: number | null;
    to: number | null;
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
}

export function usePagination(route: string) {
    const perPageOptions = [10, 25, 50, 100];
    const selectedPerPage = ref(10);

    const handleSearch = (search: string) => {
        router.get(
            route,
            {
                search: search || undefined,
                per_page: selectedPerPage.value,
                page: 1,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    };

    const goToPage = (pageUrl: string | null) => {
        if (!pageUrl) return;
        router.visit(pageUrl, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const changePerPage = (newPerPage: number, search?: string, extraParams: Record<string, unknown> = {}) => {
        selectedPerPage.value = newPerPage;
        const params: any = {
            per_page: newPerPage,
            page: 1,
            ...extraParams,
        };
        if (search) {
            params.search = search;
        }
        router.get(
            route,
            params,
            {
                preserveState: true,
                replace: true,
            }
        );
    };

    return {
        perPageOptions,
        selectedPerPage,
        handleSearch,
        goToPage,
        changePerPage,
    };
}
