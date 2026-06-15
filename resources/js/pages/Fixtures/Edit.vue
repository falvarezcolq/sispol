<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'EDITAR PARTIDO',
        href: '/fixtures',
    },
];

const props = defineProps<{
    fixture: {
        id: number;
        country_id_1: number;
        country_id_2: number;
        group_id: number;
        match_date: string;
        gol_1: number | null;
        gol_2: number | null;
        played: boolean;
        penalties: boolean;
        penalties_gol_1: number | null;
        penalties_gol_2: number | null;
    };
    countries: Array<{ id: number; name: string }>;
    groups: Array<{ id: number; name: string }>;
}>();

const matchDateTime = new Date(props.fixture.match_date);
const localDateTime = new Date(matchDateTime.getTime() - matchDateTime.getTimezoneOffset() * 60000)
    .toISOString()
    .slice(0, 16);

const form = useForm({
    country_id_1: props.fixture.country_id_1,
    country_id_2: props.fixture.country_id_2,
    group_id: props.fixture.group_id,
    match_date: localDateTime,
    gol_1: props.fixture.gol_1,
    gol_2: props.fixture.gol_2,
    played: props.fixture.played,
    penalties: props.fixture.penalties,
    penalties_gol_1: props.fixture.penalties_gol_1,
    penalties_gol_2: props.fixture.penalties_gol_2,
});

async function submit() {
    const confirmed = await confirm('¿Está seguro que desea guardar los cambios?', 'Confirmar actualización');
    if (!confirmed) return;
    form.match_date = form.match_date.replace('T', ' ');
    form.put(`/fixtures/${props.fixture.id}`, {
        preserveScroll: true,
    });
}
</script>

<template>
    <Head title="EDITAR PARTIDO" />

  
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4 md:p-6">
            <div class="flex items-center justify-center gap-4 relative">
                <Link
                    href="/fixtures"
                    class="absolute left-0 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors"
                >
                    ← Regresar
                </Link>
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ breadcrumbs[0].title }}</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Modifique los datos del partido</p>
                </div>
            </div>

            <div class="mx-auto w-full max-w-3xl bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 md:p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="country_id_1">Equipo 1 <span class="text-red-500">*</span></Label>
                            <select
                                id="country_id_1"
                                v-model.number="form.country_id_1"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-400"
                            >
                                <option value="">Seleccionar equipo...</option>
                                <option v-for="country in props.countries" :key="country.id" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.country_id_1" />
                        </div>

                        <div class="space-y-2">
                            <Label for="country_id_2">Equipo 2 <span class="text-red-500">*</span></Label>
                            <select
                                id="country_id_2"
                                v-model.number="form.country_id_2"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-400"
                            >
                                <option value="">Seleccionar equipo...</option>
                                <option v-for="country in props.countries" :key="country.id" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.country_id_2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <Label for="group_id">Grupo <span class="text-red-500">*</span></Label>
                            <select
                                id="group_id"
                                v-model.number="form.group_id"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:placeholder:text-slate-400"
                            >
                                <option value="">Seleccionar grupo...</option>
                                <option v-for="group in props.groups" :key="group.id" :value="group.id">
                                    {{ group.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.group_id" />
                        </div>

                        <div class="space-y-2">
                            <Label for="match_date">Fecha y hora <span class="text-red-500">*</span></Label>
                            <Input
                                id="match_date"
                                type="datetime-local"
                                v-model="form.match_date"
                                required
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.match_date" />
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Resultado del partido</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-2">
                                <Label for="gol_1">Goles Equipo 1</Label>
                                <Input
                                    id="gol_1"
                                    type="number"
                                    v-model.number="form.gol_1"
                                    min="0"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.gol_1" />
                            </div>

                            <div class="space-y-2">
                                <Label for="gol_2">Goles Equipo 2</Label>
                                <Input
                                    id="gol_2"
                                    type="number"
                                    v-model.number="form.gol_2"
                                    min="0"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.gol_2" />
                            </div>
                        </div>

                        <label class="flex items-center gap-2 cursor-pointer mb-4">
                            <input
                                type="checkbox"
                                v-model="form.played"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">Partido jugado</span>
                        </label>
                        <InputError :message="form.errors.played" />

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.penalties"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">Definido por penales</span>
                        </label>
                        <InputError :message="form.errors.penalties" />

                        <template v-if="form.penalties">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <div class="space-y-2">
                                    <Label for="penalties_gol_1">Goles en penales Equipo 1</Label>
                                    <Input
                                        id="penalties_gol_1"
                                        type="number"
                                        v-model.number="form.penalties_gol_1"
                                        min="0"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.penalties_gol_1" />
                                </div>

                                <div class="space-y-2">
                                    <Label for="penalties_gol_2">Goles en penales Equipo 2</Label>
                                    <Input
                                        id="penalties_gol_2"
                                        type="number"
                                        v-model.number="form.penalties_gol_2"
                                        min="0"
                                        class="mt-1 block w-full"
                                    />
                                    <InputError :message="form.errors.penalties_gol_2" />
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <Button type="submit" :disabled="form.processing" class="px-6 py-2.5">
                            Guardar cambios
                        </Button>
                    </div>
                </form>
            </div>
        </div>
</template>
