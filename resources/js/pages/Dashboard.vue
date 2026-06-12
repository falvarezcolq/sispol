<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { saveCardDetailResult } from '@/services/AppService';
import { Check } from '@lucide/vue';
import { LayoutDashboard, UserRound, BriefcaseBusiness, FilesIcon } from '@lucide/vue';
import { ref ,onMounted, onBeforeUnmount} from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
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
        total_points: number;
        card_details: Array<{
            id: number;
            fixture_id: number;
            fixture: {
                id: number;
                match_date: string; 
                team1: { name: string , flag?: string | null };
                team2: { name: string , flag?: string | null };
                group: { name: string } | null;
                gol_1: number | null;
                gol_2: number | null;
                played: boolean;
                penalties: boolean;
                penalties_gol_1: number | null;
                penalties_gol_2: number | null;
            };
            gol_1: number;
            gol_2: number;
            updated_by: number | null;
                points: number;
                message?: string;
        }>;
    }>;
    serverTime: string;
}>();

const currentTime = ref(props.serverTime);
let clockInterval: ReturnType<typeof setInterval> | null = null;

function parseServerTime(str: string): Date {
    const [datePart, timePart] = str.split(' ');
    const [day, month, year] = datePart.split('/').map(Number);
    const [hours, minutes, seconds] = timePart.split(':').map(Number);
    return new Date(year, month - 1, day, hours, minutes, seconds);
}

function formatTime(date: Date): string {
    const pad = (n: number) => n.toString().padStart(2, '0');
    return `${pad(date.getDate())} de ${['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'][date.getMonth()]} de ${date.getFullYear()}, ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
}


onMounted(() => {
    const serverDate = parseServerTime(props.serverTime);
    clockInterval = setInterval(() => {
        serverDate.setSeconds(serverDate.getSeconds() + 1);
        currentTime.value = formatTime(serverDate);
    }, 1000);
});


onBeforeUnmount(() => {
    if (clockInterval) {
        clearInterval(clockInterval);
    }
});

const totalCards = computed(() => props.cards.length);
const totalDetails = computed(() => props.cards.reduce((sum, card) => sum + card.card_details.length, 0));
const userInitials = computed(() =>
    props.user?.name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase() ?? '')
        .join(''),
);

console.log('User:', props.user);
console.log('Cards:', props.cards);

type CardDetail = {
    id: number;
    fixture_id: number;
    fixture: {
        id: number;
        match_date: string; 
        team1: { name: string , flag?: string | null };
        team2: { name: string , flag?: string | null };
        group: { name: string } | null;
        gol_1: number | null;
        gol_2: number | null;
        played: boolean;
        penalties: boolean;
        penalties_gol_1: number | null;
        penalties_gol_2: number | null;
    };
    gol_1: number;
    gol_2: number;
    points: number;
    updated_by: number | null;
    message?: string;
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
            label: date_onlyformat(items[0].fixture.match_date),
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

function date_onlyformat(dateString: string) {
    const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'short', day: 'numeric' };
    // return new Date(dateString).toLocaleDateString(undefined, options);
    // formato: 12 Mar 2024 a horas 14:30
    return new Date(dateString).toLocaleDateString(undefined, options);
}

function date_hour_format(dateString: string) {
    return new Date(dateString).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });
}
function saveResult(detail: CardDetail) {
    
    saveCardDetailResult(detail)
        .then((response) => {
            console.log('Resultado guardado exitosamente:', response);
            detail.updated_by = 1; // Simulamos que el resultado ha sido actualizado por un usuario con ID 1
        })
        .catch((error) => {
            console.error('Error al guardar el resultado:', error);
            detail.message = error.message || 'Error al guardar el resultado';
        });
}

function resultadoText(detail: CardDetail): string {
    if (detail.fixture.gol_1 === null || detail.fixture.gol_2 === null) {
        return '';
    }
    if (detail.fixture.gol_1 > detail.fixture.gol_2) {
        return detail.fixture.gol_1 + ' - ' + detail.fixture.gol_2 + ' Ganó ' + detail.fixture.team1.name  ;
    } else if (detail.fixture.gol_1 < detail.fixture.gol_2) {
        return detail.fixture.gol_1 + ' - ' + detail.fixture.gol_2 + ' Ganó ' + detail.fixture.team2.name;
    } else {
        return detail.fixture.gol_1 + ' - ' + detail.fixture.gol_2 + ' Empate';
    }
}



type SectionId = 'resumen' | 'personal' | 'operativo' | 'reportes';
const activeSection = ref<SectionId>('resumen');

const sectionTabs: Array<{ value: SectionId; label: string; icon: any }> = [
	{ value: 'resumen',   label: 'Resumen',          icon: LayoutDashboard },
	{ value: 'personal',  label: 'Datos Personales',  icon: UserRound },
	{ value: 'operativo', label: 'Gestión Operativa', icon: BriefcaseBusiness },
	{ value: 'reportes',  label: 'Reportes',          icon: FilesIcon },
];


const activeCardId = ref<number | null>(null);

// const activeCard = computed(() => {
//     return props.cards.find(card => card.id === activeCardId.value) || null;
// });

onMounted(() => {
    if (props.cards.length > 0) {
        activeCardId.value = props.cards[0].id;
    }
});


function countryFlagUrl(flag?: string | null) {
    if (!flag) {
        return '';
    }

    const codepoints = Array.from(flag)
        .map((char) => char.codePointAt(0)?.toString(16))
        .filter((value): value is string => Boolean(value))
        .join('-');

    return `https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/${codepoints}.svg`;
}

</script>

<template>
    <Head title="Detalles del usuario" />

    <div class="container mx-auto">
<div v-if="user" class="relative flex h-full flex-1 flex-col overflow-hidden rounded-3xl bg-slate-950 p-4 text-white shadow-2xl md:p-6">
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
                                  <a
                                        href="https://wa.link/dmd704"
                                        class="mt-6 inline-flex items-center rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-400"
                                        target="_blank"
                                    >
                                        Solicitar tarjeta
                                </a>
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
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Tarjetas</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ totalCards }}</p>
                        </div>
                        <!-- <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Detalles</p>
                            <p class="mt-2 text-3xl font-black text-white">{{ totalDetails }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-cyan-500/20 to-blue-500/10 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Estado</p>
                            <p class="mt-2 text-lg font-semibold text-white"></p>
                        </div> -->
                    </div>

                    
                     <div class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 my-2 px-3 py-1.5 dark:border-slate-700 dark:bg-slate-800">
                        <Clock :size="14" class="text-blue-500 dark:text-blue-400" />
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400"></span>
                        <span class="font-mono text-sm font-semibold tabular-nums text-slate-700 dark:text-slate-200">{{ currentTime }}</span>
                    </div>
                </section>
                

                <section class="space-y-4">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-200/70">Tarjetas Asociadas</p>
                            <h2 class="mt-1 text-2xl font-bold text-white">Mis Tarjetas</h2>
                        </div>
                    </div>




                    <div class="sticky top-0 z-10 -mx-1 rounded-xl bg-white/95 p-1 backdrop-blur-sm dark:bg-slate-900/95">
                        <div class="inline-flex w-full flex-wrap gap-1 rounded-lg bg-slate-100 p-1 dark:bg-slate-800">
                            <button v-for="card in cards" :key="card.id" @click="activeCardId = card.id"
                                :class="[
                                    'flex items-center rounded-md px-3.5 py-1.5 text-sm transition-colors',
                                    activeCardId === card.id 
                                        ? 'bg-white text-slate-900 shadow-xs dark:bg-slate-700 dark:text-slate-100'
                                        : 'text-slate-600 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:bg-slate-700/60',
                                ]"
                            >
                                
                                Tarjeta # <span class="ml-1.5">{{ card.card_number }}</span>  
                              
                                <span class="p-2">{{ card.card_type }}</span>
                                <span class="p-2">({{ card.total_points }} puntos)</span>
                            </button>
                        </div>
                    </div>

                    <template v-if="cards.length === 0">
                        <div class="rounded-3xl border border-dashed border-white/15 bg-white/5 p-10 text-center text-slate-200 shadow-xl backdrop-blur">
                            <p class="text-lg font-semibold text-white">No se encontraron tarjetas para este usuario.</p>
                            <p class="mt-2 text-sm text-slate-300">Cuando tenga tarjetas, aparecerán aquí con su detalle completo.</p>

                            <a
                                href="https://wa.link/dmd704"
                                class="mt-6 inline-flex items-center rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-cyan-400"
                                target="_blank"
                            >
                                Solicitar tarjeta
                        </a>
                        </div>
                    </template>

                    <template v-else>
                        <div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-2">
                            <article
                              
                                v-for="card in cards"
                                v-show="activeCardId === card.id"
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
                                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Posicion</p>
                                        <p class="mt-1 text-lg font-bold text-white">Entre los primeros 10 jugadores</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-3">
                                        <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Puntuacion</p>
                                        <p class="mt-1 text-lg text-center font-bold text-white">{{ card.total_points }}</p>
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
                                                    <div class="">
                                                        <div>
                                                            <div class="grid grid-cols-[minmax(6rem,1fr)_auto_minmax(6rem,1fr)] items-center gap-2 text-sm font-semibold text-white">
                                                                <span class="inline-flex min-w-0 items-center justify-end gap-2 justify-self-end text-right">
                                                                    <img
                                                                        v-if="detail.fixture.team1.flag"
                                                                        :src="countryFlagUrl(detail.fixture.team1.flag)"
                                                                        :alt="`Bandera de ${detail.fixture.team1.name}`"
                                                                        class="h-4 w-6 shrink-0 rounded-sm object-cover"
                                                                        loading="lazy"
                                                                    >
                                                                    <span class="truncate" style="max-width: 6rem;">{{ detail.fixture.team1.name }}</span>
                                                                </span>
                                                                <span class="inline-flex items-center">
                                                                    <input
                                                                        type="text"
                                                                        v-model="detail.gol_1"
                                                                        class="w-8 rounded-md border border-input bg-transparent px-2 py-1 text-xs text-center text-slate-400 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                                                                        :readonly="detail.fixture.played"
                                                                    >
                                                                    <span class="mx-2 text-xs font-bold text-slate-400">vs</span>
                                                                    <input
                                                                        type="text"
                                                                        v-model="detail.gol_2"
                                                                        class="w-8 rounded-md border border-input bg-transparent px-2 py-1 text-xs text-center text-slate-400 focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                                                                        :readonly="detail.fixture.played"
                                                                    >
                                                                </span>
                                                                <span class="inline-flex min-w-0 items-center gap-2 text-left">
                                                                   
                                                                    <span class="truncate" style="max-width: 6rem; ">{{ detail.fixture.team2.name }}</span>

                                                                     <img
                                                                        v-if="detail.fixture.team2.flag"
                                                                        :src="countryFlagUrl(detail.fixture.team2.flag)"
                                                                        :alt="`Bandera de ${detail.fixture.team2.name}`"
                                                                        class="h-4 w-6 shrink-0 rounded-sm object-cover"
                                                                        loading="lazy"
                                                                    >
                                                                </span>
                                                            </div>
                                                            <div>
                                                                 <div class="flex items-center  align-left justify-between">
                                                                        <p class="mt-1 text-xs uppercase tracking-[0.28em] text-slate-400">
                                                                            #{{ date_hour_format(detail.fixture.match_date) }}, 
                                                                            {{ resultadoText(detail) }}
                                                                        </p>
                                             
                                                                      
                                                                </div>

                                                                <div  class="flex items-center  align-end justify-between">
                                                                      <p class="mt-2 flex items-center gap-2 text-xs font-semibold text-slate-300">
                                                                            <span>{{ detail.fixture.group?.name }}</span>
                                                                            <span
                                                                                class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-bold ring-1"
                                                                                :class="{
                                                                                    'bg-emerald-400/15 text-emerald-300 ring-emerald-400/30': detail.points === 3,
                                                                                    'bg-amber-400/15 text-amber-300 ring-amber-400/30': detail.points === 1,
                                                                                    'bg-slate-400/10 text-slate-500 ring-slate-400/20': detail.points === 0,
                                                                                }"
                                                                            >
                                                                                {{ detail.points }} pts
                                                                            </span>

                                                                            <span class="text-red-400">{{ detail.message || '' }}</span>
                                                                        </p>

                                                                </div>
                                                              
                                                            </div>
                                                           
                                                         
                                                            
                                                            
                                                        </div>
                                                            
                                                            <div class="flex items-center justify-end gap-2" v-if="!detail.fixture.played">

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
                            <article
                              
                                class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 via-slate-900 to-slate-800 p-5 shadow-2xl ring-1 ring-white/5"
                            >
                                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-cyan-400 via-sky-500 to-fuchsia-500"></div>

                               <!-- Reglas -->
                                    <section class="space-y-4">
                                        <header>
                                            <span class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Reglas</span>
                                            <h3 class="mt-2 text-2xl font-black text-white">¡Reglas del juego!</h3>
                                        </header>

                                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                            <h4 class="text-[11px] font-semibold uppercase tracking-[0.25em] text-slate-400">Cómo ganar puntos</h4>
                                            <ul class="mt-3 space-y-2">
                                                <li class="flex gap-2 text-sm text-slate-300">
                                                    <span class="font-bold text-emerald-400">3 puntos</span>
                                                    por acertar el resultado exacto del partido.
                                                </li>
                                                <li class="flex gap-2 text-sm text-slate-300">
                                                    <span class="font-bold text-emerald-400">1 punto</span>
                                                    por acertar el resultado sin acertar el marcador exacto (ganador o empate).
                                                </li>
                                                <li class="flex gap-2 text-sm text-slate-300">
                                                    <span class="font-bold text-red-400">0 puntos</span>
                                                    por no acertar el resultado del partido.
                                                </li>
                                                <li class="mt-3 text-sm text-amber-300/80">
                                                    ⚠️ Llena los goles de cada partido hasta 10 minutos antes de iniciar para sumar puntos.
                                                </li>
                                            </ul>
                                        </div>
                                    </section>

                                    <!-- Premios -->
                                    <section class="space-y-4">
                                        <header>
                                            <span class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Premios</span>
                                            <h3 class="mt-2 text-2xl font-black text-white">¡Premios!</h3>
                                        </header>

                                        <div class="grid grid-cols-3 gap-3">
                                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
                                                <span class="inline-block rounded-full bg-amber-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-400">
                                                    🥇 1er lugar
                                                </span>
                                                <p class="mt-2 text-lg font-bold text-white">60%</p>
                                                <p class="text-xs text-slate-400">del total</p>
                                            </div>
                                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
                                                <span class="inline-block rounded-full bg-slate-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-300">
                                                    🥈 2do lugar
                                                </span>
                                                <p class="mt-2 text-lg font-bold text-white">30%</p>
                                                <p class="text-xs text-slate-400">del total</p>
                                            </div>
                                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center">
                                                <span class="inline-block rounded-full bg-orange-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-orange-400">
                                                    🥉 3er lugar
                                                </span>
                                                <p class="mt-2 text-lg font-bold text-white">10%</p>
                                                <p class="text-xs text-slate-400">del total</p>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Pozo Acumulado -->
                                    <section class="space-y-4">
                                        <header>
                                            <span class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Pozo</span>
                                            <h3 class="mt-2 text-2xl font-black text-white">Pozo acumulado</h3>
                                        </header>

                                        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-emerald-500/10 p-5 text-center">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-emerald-400">Total acumulado</p>
                                            <p class="mt-2 text-4xl font-black text-white">Bs. 830</p>
                                        </div>
                                    </section>

                                    <section class="space-y-4">
                                        <header>
                                            <span class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Participa</span>
                                            <h3 class="mt-2 text-2xl font-black text-white">¿Cómo participar?</h3>
                                        </header>

                                        <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-emerald-500/10 p-5 text-center">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-blue-400">Solicita tu tarjeta VIP, que te permitira ser parte del pozo acumulado.</p>
                                        
                                        </div>
                                    </section>
                              

                              
                            </article>
                        </div>
                    </template>
                </section>
            </div>
        </div>

    </div>
        

</template>
