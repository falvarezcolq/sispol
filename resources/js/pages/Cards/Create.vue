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
        title: 'NUEVA TARJETA',
        href: '/cards/create',
    },
];

const props = defineProps<{
    users: Array<{ id: number; name: string }>;
    user_id: number | '';
}>();

const form = useForm({
    user_id: props.user_id || '' as number ,
    card_number: '' as number | '',
    balance: '' as number | '',
    card_type: 'VIP',
});

async function submit() {
    const confirmed = await confirm('Esta seguro que desea crear esta tarjeta?', 'Confirmar creacion');
    if (!confirmed) return;
    form.post('/cards', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="NUEVA TARJETA" />


        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-4 md:p-6">
            <div class="flex items-center justify-center gap-4 relative">
                <Link
                    href="/cards"
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
                        <Label for="user_id">Usuario <span class="text-red-500">*</span></Label>
                        <select
                            id="user_id"
                            v-model="form.user_id"
                            required
                            class="mt-1 block w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                        >
                            <option value="">Seleccione un usuario</option>
                            <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                        </select>
                        <InputError :message="form.errors.user_id" />
                    </div>

                    <div class="space-y-2">
                        <Label for="balance">Saldo <span class="text-red-500">*</span></Label>
                        <Input
                            id="balance"
                            type="number"
                            step="0.01"
                            min="0"
                            v-model="form.balance"
                            required
                            placeholder="0.00"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.balance" />
                    </div>

                    <div class="space-y-2">
                        <Label for="card_type">Tipo de tarjeta <span class="text-red-500">*</span></Label>

                        <select
                            id="card_type"
                            v-model="form.card_type"
                            required
                            class="mt-1 block w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]"
                        >
                            <option value="VIP">VIP</option>
                            <option value="INVITADO">Test</option>
                        </select>
                      
                        <InputError :message="form.errors.card_type" />
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <Button type="submit" :disabled="form.processing" class="px-6 py-2.5">
                            Registrar tarjeta
                        </Button>
                    </div>
                </form>
            </div>
        </div>

</template>
