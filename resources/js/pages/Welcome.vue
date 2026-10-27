<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Accueil — FlexPay Sénégal" />

    <main class="min-h-screen overflow-hidden bg-[#F7F6F0] text-[#18211F]">
        <header class="mx-auto flex max-w-6xl items-center justify-between px-5 py-6 sm:px-8">
            <Link href="/" class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#123B35] text-lg font-black text-[#D5F36A]">
                    F
                </span>
                <span>
                    <span class="block text-lg font-extrabold text-[#123B35]">FlexPay</span>
                    <span class="block text-xs text-[#596762]">Sénégal · XOF</span>
                </span>
            </Link>

            <nav class="flex items-center gap-3">
                <Link
                    href="/login"
                    class="rounded-xl px-4 py-2 text-sm font-bold text-[#123B35] transition hover:bg-white"
                >
                    Connexion
                </Link>
                <Link
                    href="/register"
                    class="rounded-xl bg-[#123B35] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#246B57]"
                >
                    Créer un compte
                </Link>
            </nav>
        </header>

        <section class="mx-auto grid max-w-6xl items-center gap-12 px-5 pb-20 pt-12 sm:px-8 md:grid-cols-2 md:pb-28 md:pt-20">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-[#246B57]/15 bg-white px-3 py-2 text-xs font-bold text-[#246B57]">
                    <span class="h-2 w-2 rounded-full bg-[#D5F36A]"></span>
                    Simple. Clair. Sénégalais.
                </span>

                <h1 class="mt-6 max-w-xl text-4xl font-black leading-tight tracking-tight text-[#123B35] sm:text-5xl lg:text-6xl">
                    Votre argent,
                    <span class="text-[#246B57]">en toute simplicité.</span>
                </h1>

                <p class="mt-6 max-w-lg text-base leading-7 text-[#596762] sm:text-lg">
                    Retrouvez votre solde, consultez vos opérations et gérez votre portefeuille depuis un espace unique.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <Link
                        href="/register"
                        class="inline-flex items-center justify-center rounded-xl bg-[#123B35] px-6 py-3.5 font-bold text-white transition hover:bg-[#246B57]"
                    >
                        Ouvrir mon portefeuille
                        <span class="ml-2" aria-hidden="true">→</span>
                    </Link>
                    <Link
                        href="/login"
                        class="inline-flex items-center justify-center rounded-xl border border-[#123B35]/15 bg-white px-6 py-3.5 font-bold text-[#123B35] transition hover:border-[#246B57]"
                    >
                        J’ai déjà un compte
                    </Link>
                </div>

                <p class="mt-6 text-xs leading-5 text-[#596762]">
                    Prototype éducatif : aucun dépôt, retrait ou transfert réel n’est effectué.
                </p>
            </div>

            <div class="relative mx-auto w-full max-w-md">
                <div class="absolute -inset-5 rounded-[2.5rem] bg-[#D5F36A]/35 blur-2xl"></div>
                <section class="relative rounded-[2rem] bg-[#123B35] p-6 text-white shadow-2xl sm:p-8">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-white/65">Portefeuille FlexPay</p>
                            <p class="mt-1 text-xl font-bold">Mon solde</p>
                        </div>
                        <span class="rounded-xl bg-white/10 px-3 py-2 text-xs font-bold tracking-wider">XOF</span>
                    </div>

                    <p class="mt-10 text-sm text-white/65">Solde disponible</p>
                    <p class="mt-2 text-4xl font-black tracking-tight">0 FCFA</p>

                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-white/10 p-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#D5F36A] text-lg font-black text-[#123B35]">+</span>
                            <p class="mt-3 font-bold">Dépôt</p>
                            <p class="mt-1 text-xs text-white/60">Prototype</p>
                        </div>
                        <div class="rounded-2xl bg-white/10 p-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 text-lg font-black">↗</span>
                            <p class="mt-3 font-bold">Transfert</p>
                            <p class="mt-1 text-xs text-white/60">Prototype</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-white/10 p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-white/70">Historique</span>
                            <span class="text-xs text-[#D5F36A]">Prêt à démarrer</span>
                        </div>
                        <p class="mt-2 text-sm">Vos transactions apparaîtront ici.</p>
                    </div>
                </section>
            </div>
        </section>
    </main>
</template>
