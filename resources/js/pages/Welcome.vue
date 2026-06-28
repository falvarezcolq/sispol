<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login } from '@/routes';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <header
            class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl"
        >
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    href="/dashboard"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="login()"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Ingresar
                    </Link>
                </template>
            </nav>
        </header>
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
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
                <!-- <section class="space-y-4">
                    <header>
                        <span class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Pozo</span>
                        <h3 class="mt-2 text-2xl font-black text-white">Pozo acumulado</h3>
                    </header>

                    <div class="rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-emerald-500/10 p-5 text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.25em] text-emerald-400">Total acumulado</p>
                        <p class="mt-2 text-4xl font-black text-white">Bs. ?000</p>
                    </div>
                </section> -->
                              

                              
                            </article>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
