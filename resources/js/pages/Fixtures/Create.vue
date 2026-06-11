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
        title: 'NUEVO PARTIDO',
        href: '/fixtures/create',
    },
];

const props = defineProps<{
    countries: Array<{ id: number; name: string }>;
    groups: Array<{ id: number; name: string }>;
}>();

const form = useForm({
    country_id_1: '',
    country_id_2: '',
    group_id: '',
    match_date: '',
});

async function submit() {
    const confirmed = await confirm('¿Está seguro que desea crear este partido?', 'Confirmar creación');
    if (!confirmed) return;
    form.match_date = form.match_date.replace('T', ' ');
    form.post('/fixtures', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="NUEVO PARTIDO" />

    <AppLayout :breadcrumbs="breadcrumbs">
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
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Complete el formulario para continuar</p>
                </div>
            </div>

            <div class="mx-auto w-full max-w-3xl bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 md:p-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="country_id_1">Equipo 1 <span class="text-red-500">*</span></Label>
                        <select
                            id="country_id_1"
                            v-model="form.country_id_1"
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
                            v-model="form.country_id_2"
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

                    <div class="space-y-2">
                        <Label for="group_id">Grupo <span class="text-red-500">*</span></Label>
                        <select
                            id="group_id"
                            v-model="form.group_id"
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
                        <Label for="match_date">Fecha y hora del partido <span class="text-red-500">*</span></Label>
                        <Input
                            id="match_date"
                            type="datetime-local"
                            v-model="form.match_date"
                            required
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.match_date" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <Button type="submit" :disabled="form.processing" class="px-6 py-2.5">
                            Crear partido
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
