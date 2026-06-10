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
        title: 'NUEVO USUARIO',
        href: '/users/create',
    },
];

const props = defineProps<{
    roles: Array<{ id: number; name: string }>;
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    enabled: true,
    is_admin: false,
});


async function submit() {
    const confirmed = await confirm('¿Está seguro que desea crear este usuario?', 'Confirmar creación');
    if (!confirmed) return;
    form.post('/users', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="NUEVO USUARIO" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4 md:p-6">
            <div class="flex items-center justify-center gap-4 relative">
                <Link
                    href="/users"
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
                        <Label for="name">Nombre completo <span class="text-red-500">*</span></Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            required
                            placeholder="Nombre del usuario"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.name" />
                    </div>


                    <div class="space-y-2">
                        <Label for="email">Correo electrónico <span class="text-red-500">*</span></Label>
                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            placeholder="correo@ejemplo.com"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.email" />
                    </div>

                    <div class="space-y-2">
                        <Label for="password">Contraseña <span class="text-red-500">*</span></Label>
                        <Input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            placeholder="Mínimo 8 caracteres"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.password" />
                    </div>

                    <div class="space-y-2">
                        <Label>Administrador</Label>
                        <label class="flex items-center gap-2 cursor-pointer mt-1">
                            <input
                                type="checkbox"
                                v-model="form.is_admin"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">Con privilegios de administrador</span>
                        </label>
                        <InputError :message="form.errors.is_admin" />

                    </div>

                    <div class="space-y-2">
                        <Label>Estado</Label>
                        <label class="flex items-center gap-2 cursor-pointer mt-1">
                            <input
                                type="checkbox"
                                v-model="form.enabled"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <span class="text-sm text-gray-700 dark:text-gray-300">Usuario activo</span>
                        </label>
                        <InputError :message="form.errors.enabled" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <Button type="submit" :disabled="form.processing" class="px-6 py-2.5">
                            Registrar usuario
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
