<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Log in to your account',
        description: 'Enter your email and password below to log in',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <Head title="Log in" />

    <!-- Status Message -->
    <div
        v-if="status"
        class="mb-6 rounded-2xl border border-emerald-400/30 bg-gradient-to-r from-emerald-500/20 to-emerald-400/10 p-4 text-center shadow-lg shadow-emerald-500/10"
    >
        <p class="text-sm font-bold uppercase tracking-[0.25em] text-emerald-300">
            ✅ {{ status }}
        </p>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <span class="inline-block rounded-full bg-violet-500/20 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.35em] text-violet-300 ring-1 ring-violet-500/30">
            ⚡ Acceso
        </span>
        <h1 class="mt-4 bg-gradient-to-r from-white via-white to-violet-300 bg-clip-text text-4xl font-black text-transparent">
            ¡Bienvenido de vuelta!
        </h1>
        <p class="mt-3 text-sm font-medium text-slate-300">
            Ingresa tus credenciales para continuar 🚀
        </p>
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-6">
            <!-- Email Field -->
            <div class="grid gap-2">
                <Label 
                    for="email"
                    class="text-[11px] font-bold uppercase tracking-[0.25em] text-violet-300"
                >
                    📧 Email address
                </Label>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="rounded-xl border-violet-500/20 bg-violet-500/5 text-white placeholder:text-slate-500 focus:border-violet-400 focus:ring-2 focus:ring-violet-500/30"
                />
                <InputError :message="errors.email" />
            </div>

            <!-- Password Field -->
            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label 
                        for="password"
                        class="text-[11px] font-bold uppercase tracking-[0.25em] text-violet-300"
                    >
                        🔒 Password
                    </Label>
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-xs font-semibold text-amber-400 transition-colors hover:text-amber-300"
                        :tabindex="5"
                    >
                        Forgot your password?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Password"
                    class="rounded-xl border-violet-500/20 bg-violet-500/5 text-white placeholder:text-slate-500 focus:border-violet-400 focus:ring-2 focus:ring-violet-500/30"
                />
                <InputError :message="errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox 
                        id="remember" 
                        name="remember" 
                        :tabindex="3"
                        class="border-violet-400/40 bg-violet-500/10 data-[state=checked]:bg-violet-500 data-[state=checked]:text-white"
                    />
                    <span class="text-sm font-medium text-slate-300">Remember me</span>
                </Label>
            </div>

            <!-- Submit Button -->
            <Button
                type="submit"
                class="group relative mt-4 w-full overflow-hidden rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 py-6 text-sm font-bold uppercase tracking-[0.25em] text-white shadow-lg shadow-violet-500/30 transition-all hover:from-violet-500 hover:to-fuchsia-500 hover:shadow-xl hover:shadow-violet-500/40"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 opacity-0 transition-opacity group-hover:opacity-100" />
                <span class="relative flex items-center justify-center gap-2">
                    <Spinner v-if="processing" />
                    <span v-if="!processing">🚀 Log in</span>
                    <span v-else>Loading...</span>
                </span>
            </Button>
        </div>
    </Form>
</template>