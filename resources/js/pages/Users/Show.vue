<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { saveCardDetailResult } from '@/services/AppService';
import { Check } from '@lucide/vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Detalles del usuario',
        href: '/users',
    },
];

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
        enabled: boolean;
        is_admin: boolean;
    };
    cards: Array<{
        id: number;
        card_number: number;
        balance: string;
        card_type: string;
        card_details: Array<{
            id: number;
            fixture_id: number;
            fixture: {
                id: number;
                match_date: string; 
                team1: { name: string };
                team2: { name: string };
            };
            gol_1: number;
            gol_2: number;
            updated_by: number | null;
        }>;
    }>;
}>();

const totalCards = computed(() => props.cards.length);
const totalDetails = computed(() => props.cards.reduce((sum, card) => sum + card.card_details.length, 0));
const userInitials = computed(() =>
    props.user.name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase() ?? '')
        .join(''),
);

type CardDetail = {
    id: number;
    fixture_id: number;
    fixture: {
        id: number;
        match_date: string;
        team1: { name: string };
        team2: { name: string };
        group: { name: string } | null;
    };
    gol_1: number;
    gol_2: number;
    updated_by: number | null;
};

function groupCardDetailsByDate(details: CardDetail[]) {
    const grouped = details.reduce<Record<string, CardDetail[]>>((accumulator, detail) => {
        const dateKey = new Date(detail.fixture.match_date).toDateString();
        if (!accumulator[dateKey]) {
            accumulator[dateKey] = [];
        }
        accumulator[dateKey].push(detail);
        return accumulator;
    }, {});

    return Object.entries(grouped)
        .map(([dateKey, items]) => ({
            dateKey,
            label: date_format(items[0].fixture.match_date),
            items: items.sort(
                (a, b) => new Date(a.fixture.match_date).getTime() - new Date(b.fixture.match_date).getTime(),
            ),
        }))
        .sort((a, b) => new Date(a.dateKey).getTime() - new Date(b.dateKey).getTime());
}

function date_format(dateString: string) {
    const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'short', day: 'numeric' };
    // return new Date(dateString).toLocaleDateString(undefined, options);
    // formato: 12 Mar 2024 a horas 14:30
    return new Date(dateString).toLocaleDateString(undefined, options) + '  ' + new Date(dateString).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });
}

function saveResult(detail: CardDetail) {
    
    saveCardDetailResult(detail)
        .then((response) => {
            console.log('Resultado guardado exitosamente:', response);
            detail.updated_by = 1; // Simulamos que el resultado ha sido actualizado por un usuario con ID 1
        })
        .catch((error) => {
            console.error('Error al guardar el resultado:', error);
        });
}
</script>

<template>
    <Head title="Detalles del usuario" />


        <div class="relative flex h-full flex-1 flex-col overflow-hidden rounded-3xl bg-slate-950 p-4 text-white shadow-2xl md:p-6">
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div class="absolute -left-20 top-0 h-64 w-64 rounded-full bg-cyan-500/15 blur-3xl"></div>
                <div class="absolute right-0 top-16 h-72 w-72 rounded-full bg-fuchsia-500/10 blur-3xl"></div>
                <div class="absolute bottom-0 left-1/3 h-56 w-56 rounded-full bg-amber-400/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 space-y-6">
                <section class="overflow-hidden rounded-3xl border border-white/10 bg-white/10 p-5 shadow-xl backdrop-blur md:p-6">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 via-sky-500 to-blue-700 text-xl font-black text-white shadow-lg shadow-cyan-500/20 ring-1 ring-white/20">
                                {{ userInitials }}
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/80">Detalle de usuario</p>
                                <h1 class="mt-1 text-3xl font-black tracking-tight text-white md:text-4xl">
                                    {{ user.name }}
                                </h1>
                                <p class="mt-2 text-sm text-slate-200/80">{{ user.email }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1"
                                :class="user.enabled
                                    ? 'bg-emerald-400/15 text-emerald-100 ring-emerald-300/30'
                                    : 'bg-rose-400/15 text-rose-100 ring-rose-300/30'"
                            >
                                {{ user.enabled ? 'Activo' : 'Inactivo' }}
                            </span>
                            <span
                                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1"
                                :class="user.is_admin
                                    ? 'bg-amber-400/15 text-amber-100 ring-amber-300/30'
                                    : 'bg-slate-400/15 text-slate-100 ring-slate-300/20'"
                            >
                                {{ user.is_admin ? 'Administrador' : 'Usuario' }}
                            </span>
                            <Link
                                href="/users"
                                class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-white transition hover:bg-white/15"
                            >
                                Volver al listado
                            </Link>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tarjetas</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ totalCards }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Detalles</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ totalDetails }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Estado</p>
                            <p class="mt-2 text-lg font-semibold text-white">{{ user.is_admin ? 'Acceso de administración' : 'Acceso estándar' }}</p>
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/70">Tarjetas asociadas</p>
                            <h2 class="mt-1 text-2xl font-bold text-white">Cartones y sus detalles</h2>
                        </div>
                        <p class="hidden text-sm text-slate-300 md:block">VER POR GRUPO. </p>

                    </div>

                    <template v-if="cards.length === 0">
                        <div class="rounded-3xl border border-dashed border-white/15 bg-white/5 p-10 text-center text-slate-200 shadow-xl backdrop-blur">
                            <p class="text-lg font-semibold text-white">No se encontraron tarjetas para este usuario.</p>
                            <p class="mt-2 text-sm text-slate-300">Cuando tenga tarjetas, aparecerán aquí con su detalle completo.</p>
                            <Link
                                href="/users"
                                class="mt-6 inline-flex items-center rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-400"
                            >
                                Volver
                            </Link>
                        </div>
                    </template>

                    <template v-else>
                        <div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-2">
                            <article
                                v-for="card in cards"
                                :key="card.id"
                                class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 p-5 shadow-2xl ring-1 ring-white/5"
                            >
                                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-cyan-400 via-sky-500 to-fuchsia-500"></div>

                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Tarjeta</p>
                                        <h3 class="mt-2 text-2xl font-black text-white">#{{ card.card_number }}</h3>
                                    </div>

                                    <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-semibold text-cyan-100">
                                        {{ card.card_type }}
                                    </span>
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3">
                                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">ID</p>
                                        <p class="mt-1 text-lg font-bold text-white">{{ card.id }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3">
                                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Detalle</p>
                                        <p class="mt-1 text-lg font-bold text-white">{{ card.card_details.length }}</p>
                                    </div>
                                </div>

                                <div class="mt-5 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-semibold text-slate-200">Detalle de la tarjeta</p>
                                        <span class="text-xs text-slate-400">{{ card.card_details.length }} partidos</span>
                                    </div>

                                    <div v-if="card.card_details.length === 0" class="rounded-2xl border border-dashed border-white/10 bg-white/5 p-4 text-sm text-slate-300">
                                        Sin detalles registrados.
                                    </div>

                                    <div v-else class="space-y-4">
                                        <div
                                            v-for="group in groupCardDetailsByDate(card.card_details)"
                                            :key="group.dateKey"
                                            class="rounded-2xl border border-white/10 bg-white/5 p-3"
                                        >
                                            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-cyan-200">
                                                {{ group.label }}
                                            </p>

                                            <div class="space-y-3">
                                                <div
                                                    v-for="detail in group.items"
                                                    :key="detail.id"
                                                    class="rounded-2xl border border-white/10 bg-slate-950/60 p-4 transition hover:border-cyan-400/30 hover:bg-slate-950"
                                                >
                                                    <div class="flex items-start justify-between gap-0">
                                                        <div>
                                                            <div class="grid grid-cols-[minmax(9rem,1fr)_auto_minmax(9rem,1fr)] items-center gap-2 text-sm font-semibold text-white">
                                                                <span class="justify-self-end truncate text-right">{{ detail.fixture.team1.name }}</span>
                                                                <span class="inline-flex items-center">
                                                                    <input
                                                                        type="text"
                                                                        v-model="detail.gol_1"
                                                                        class="w-8 rounded-md border border-input bg-transparent px-2 py-1 text-xs text-center text-slate-400 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                                                                    >
                                                                    <span class="mx-2 text-xs font-bold text-slate-400">vs</span>
                                                                    <input
                                                                        type="text"
                                                                        v-model="detail.gol_2"
                                                                        class="w-8 rounded-md border border-input bg-transparent px-2 py-1 text-xs text-center text-slate-400 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                                                                    >
                                                                </span>
                                                                <span class="truncate text-left">{{ detail.fixture.team2.name }}</span>
                                                            </div>
                                                            <p class="mt-1 text-xs uppercase tracking-[0.28em] text-slate-400">#{{ date_format(detail.fixture.match_date) }}</p>
                                                            <p> {{ detail.fixture.group?.name }}</p>
                                                        </div>

                                                        <div class="flex items-left gap-0">
                                                            

                                                            <button @click="saveResult(detail)" title="Guardar resultado" v-if="detail.updated_by === null" class="inline-flex items-center rounded-full border border-emerald-400/40 bg-transparent px-3 py-1 text-xs font-semibold text-emerald-200 transition hover:bg-emerald-400/10" >
                                                                <Check class="mr-1 h-3.5 w-3.5" /> guardar
                                                            </button>

                                                            <button @click="saveResult(detail)" title="Actualizar resultado" v-else class="inline-flex items-center rounded-full border border-amber-400/40 bg-transparent px-3 py-1 text-xs font-semibold text-amber-200 transition hover:bg-amber-400/10">
                                                                <Check class="h-3.5 w-3.5" />
                                                            </button>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </template>
                </section>
            </div>
        </div>

</template>
