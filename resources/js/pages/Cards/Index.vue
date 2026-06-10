<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { onBeforeUnmount, ref, watch } from 'vue';
import { Edit, Trash2, Plus, Search } from '@lucide/vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { usePagination } from '@/composables/usePagination';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'GESTION DE TARJETAS',
        href: '/cards',
    },
];

const props = defineProps<{
    cards: {
        data: Array<{
            id: number;
            user_id: number;
            card_number: number;
            balance: string;
            card_type: string;
            user: {
                id: number;
                name: string;
            } | null;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
        from: number | null;
        to: number | null;
        total: number;
        per_page: number;
        current_page: number;
    };
    search?: string | null;
}>();

const form = useForm({});
const search = ref(props.search || '');
const { perPageOptions, selectedPerPage, changePerPage } = usePagination('/cards');
let searchDebounce: ReturnType<typeof setTimeout> | null = null;

selectedPerPage.value = props.cards.per_page;

async function deleteCard(id: number) {
    const confirmed = await confirm('Estas seguro de eliminar esta tarjeta?', 'Confirmar eliminacion');
    if (!confirmed) return;
    form.delete(`/cards/${id}`, {
        preserveScroll: true,
        onSuccess: (res) => {
            if (res.props.flash?.error) {
                Message.error(res.props.flash.error);
            } else if (res.props.flash?.success) {
                Message.success(res.props.flash.success);
            }
        },
    });
}

function submit() {
    router.get('/cards', {
        search: search.value,
        per_page: selectedPerPage.value,
        page: 1,
    }, {
        preserveState: true,
        replace: true,
    });
}

watch(search, (value, previousValue) => {
    if (value === previousValue) return;
    if (searchDebounce) clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => submit(), 350);
});

onBeforeUnmount(() => {
    if (searchDebounce) clearTimeout(searchDebounce);
});
</script>

<template>
    <Head title="GESTION DE TARJETAS" />

    <!-- <AppLayout :breadcrumbs="breadcrumbs"> -->
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex justify-between items-center">
                <Link
                    href="/cards/create"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                >
                    <Plus :size="16" />
                    Nueva tarjeta
                </Link>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:items-end md:gap-3">
                <form @submit.prevent="submit" class="flex flex-1 items-center gap-2">
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Buscar por numero, tipo o usuario..."
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-400"
                    />
                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center gap-2 px-3 py-2 text-xs font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700"
                    >
                        <Search :size="16" />
                        Buscar
                    </button>
                </form>

                <div class="flex items-center gap-2 md:w-auto">
                    <label class="text-xs font-medium text-slate-700 dark:text-slate-300">Registros:</label>
                    <select
                        :value="selectedPerPage"
                        @change="changePerPage(Number(($event.target as HTMLSelectElement).value), search || undefined)"
                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100"
                    >
                        <option v-for="option in perPageOptions" :key="option" :value="option">{{ option }}</option>
                    </select>
                </div>
            </div>

            <table v-if="props.cards.data.length > 0" class="w-full overflow-hidden rounded-lg border border-gray-300 bg-white shadow-md dark:border-slate-700 dark:bg-slate-900">
                <thead>
                    <tr class="bg-slate-500 text-white dark:bg-slate-700">
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Usuario</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Numero</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Saldo</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Accion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <tr v-for="item in props.cards.data" :key="item.id" class="transition-colors duration-150 hover:bg-slate-100 dark:hover:bg-slate-800/60">
                        <td class="px-4 py-3 text-sm text-slate-700 font-medium">{{ item.id }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ item.user?.name || '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">{{ item.card_number }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ Number(item.balance).toFixed(2) }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ item.card_type }}</td>
                        <td class="px-4 py-3 text-sm space-x-2 flex items-center">
                            <Link
                                :href="`/cards/${item.id}/edit`"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                                title="Editar"
                            >
                                <Edit :size="16" />
                            </Link>
                            <button
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-700 transition-colors duration-200 shadow-sm"
                                @click="deleteCard(item.id)"
                                title="Eliminar"
                            >
                                <Trash2 :size="16" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="text-center py-12">
                <p class="text-slate-500 mb-4">No hay tarjetas registradas</p>
                <Link
                    href="/cards/create"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                >
                    <Plus :size="16" />
                    Crear la primera tarjeta
                </Link>
            </div>

            <div v-if="props.cards.data.length > 0" class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Mostrando {{ props.cards.from ?? 0 }}-{{ props.cards.to ?? 0 }} de {{ props.cards.total }} registros
                </p>

                <div class="flex flex-wrap items-center gap-1">
                    <Link
                        v-for="(link, index) in props.cards.links"
                        :key="`${index}-${link.label}`"
                        :href="link.url || '#'"
                        preserve-scroll
                        preserve-state
                        :class="[
                            'rounded border px-3 py-1 text-xs font-medium',
                            link.active ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800',
                            !link.url ? 'pointer-events-none opacity-50' : '',
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    <!-- </AppLayout> -->
</template>
