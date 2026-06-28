<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { onBeforeUnmount, ref, watch } from 'vue';
import { Edit, Trash2, Plus, Search, PlusCircle } from '@lucide/vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { usePagination } from '@/composables/usePagination';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'GESTIÓN DE USUARIOS',
        href: '/users',
    },
];

const props = defineProps<{
    users: {
        data: Array<{
            id: number; 
            name: string;
            email: string;
            enabled: boolean;
            is_admin: boolean;
        }>;
        links: Array<{ url: string | null; label: string; active: boolean }>;
        from: number | null;
        to: number | null;
        total: number;
        per_page: number;
        current_page: number;
        total_cards:number;
    };
    search?: string | null;
}>();

const form = useForm({});
const search = ref(props.search || '');
const { perPageOptions, selectedPerPage, changePerPage } = usePagination('/users');
let searchDebounce: ReturnType<typeof setTimeout> | null = null;

selectedPerPage.value = props.users.per_page;

async function deleteUser(id: number) {
    const confirmed = await confirm('¿Estás seguro de eliminar este usuario?', 'Confirmar eliminación');
    if (!confirmed) return;
    form.delete(`/users/${id}`, {
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
    router.get('/users', {
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
    <Head title="GESTIÓN DE USUARIOS" />


        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="flex justify-between items-center">
                <Link
                    href="/users/create"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                >
                    <Plus :size="16" />
                    Nuevo usuario
                </Link>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:items-end md:gap-3">
                <form @submit.prevent="submit" class="flex flex-1 items-center gap-2">
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Buscar por nombre, usuario o email..."
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

            <table v-if="props.users.data.length > 0" class="w-full overflow-hidden rounded-lg border border-gray-300 bg-white shadow-md dark:border-slate-700 dark:bg-slate-900">
                <thead>
                    <tr class="bg-slate-500 text-white dark:bg-slate-700">
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Administrador</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Tarjetas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold tracking-wider">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <tr v-for="item in props.users.data" :key="item.id" class="transition-colors duration-150 hover:bg-slate-100 dark:hover:bg-slate-800/60">
                        <td class="px-4 py-3 text-sm text-slate-700 font-medium">{{ item.id }}</td>
                        <td class="px-4 py-3 text-sm text-slate-700">
                             <Link
                                :href="`/users/${item.id}`"
                                class="text-sm font-medium text-blue-600 underline decoration-transparent transition hover:text-blue-700 hover:decoration-current"
                            >
                                {{ item.name }}
                            </Link>
                        </td>
  
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ item.email }}</td>
                      
                        <td class="px-4 py-3 text-sm">
                            <span
                                :class="item.enabled
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'"
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                            >
                                {{ item.enabled ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 text-sm">
                            <span
                                :class="item.is_admin
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'"
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                            >
                                {{ item.is_admin ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">
                            {{ item.total_cards ?? 0 }}
                        </td>
                        <td class="px-4 py-3 text-sm space-x-2 flex items-center">

                            <Link
                                :href="`/cards/create?user_id=${item.id}`"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                                title="Agregar tarjeta"
                            >
                                <PlusCircle :size="16" />
                            </Link>

                            <Link
                                :href="`/users/${item.id}/edit`"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                                title="Editar"
                            >
                                <Edit :size="16" />
                            </Link>
                            <button
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-red-500 rounded hover:bg-red-700 transition-colors duration-200 shadow-sm"
                                @click="deleteUser(item.id)"
                                title="Eliminar"
                            >
                                <Trash2 :size="16" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="text-center py-12">
                <p class="text-slate-500 mb-4">No hay usuarios registrados</p>
                <Link
                    href="/users/create"
                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-white bg-blue-500 rounded hover:bg-blue-700 transition-colors duration-200 shadow-sm"
                >
                    <Plus :size="16" />
                    Crear el primer usuario
                </Link>
            </div>

            <div v-if="props.users.data.length > 0" class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-slate-600 dark:text-slate-300">
                    Mostrando {{ props.users.from ?? 0 }}-{{ props.users.to ?? 0 }} de {{ props.users.total }} registros
                </p>

                <div class="flex flex-wrap items-center gap-1">
                    <Link
                        v-for="(link, index) in props.users.links"
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

</template>
