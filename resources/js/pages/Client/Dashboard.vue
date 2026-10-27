<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import BalanceCard from '../../components/wallet/BalanceCard.vue'
import TransactionList from '../../components/wallet/TransactionList.vue'
import type { Transaction, User, Wallet } from '../../types/wallet'

defineProps<{
    user: User
    wallet: Wallet | null
    transactions: Transaction[]
}>()

function logout() {
    router.post('/logout')
}
</script>

<template>
    <Head title="Mon espace — FlexPay" />

    <main class="min-h-screen bg-[#F7F6F0] px-4 py-6 text-[#18211F] sm:px-8">
        <div class="mx-auto max-w-6xl">
            <header class="flex flex-wrap items-center justify-between gap-4">
                <Link href="/dashboard" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#123B35] text-lg font-black text-[#D5F36A]">F</span>
                    <span>
                        <span class="block text-lg font-extrabold text-[#123B35]">FlexPay</span>
                        <span class="block text-xs text-[#596762]">Sénégal · Espace client</span>
                    </span>
                </Link>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm font-semibold text-[#596762] sm:inline">{{ user.name }}</span>
                    <button type="button" class="rounded-xl border border-[#123B35]/15 bg-white px-4 py-2 text-sm font-bold text-[#123B35] hover:bg-[#123B35] hover:text-white" @click="logout">
                        Se déconnecter
                    </button>
                </div>
            </header>

            <section class="mt-8">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-[#246B57]">Mon espace personnel</p>
                <h1 class="mt-2 text-3xl font-black text-[#123B35] sm:text-4xl">Bonjour, {{ user.name }}</h1>
                <p class="mt-2 text-[#596762]">Consultez votre portefeuille et suivez vos opérations.</p>
            </section>

            <section class="mt-7 grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-5">
                    <BalanceCard :wallet="wallet" />

                    <section class="rounded-2xl border border-[#246B57]/15 bg-white p-5 shadow-sm sm:p-6">
                        <h2 class="text-lg font-extrabold text-[#123B35]">Besoin de déposer ou retirer de l'argent ?</h2>
                        <p class="mt-2 text-sm leading-6 text-[#596762]">
                            Rendez-vous chez un agent FlexPay. Il effectuera l'opération sur votre portefeuille après les vérifications nécessaires.
                        </p>
                    </section>

                    <Link href="/transactions" class="block rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#123B35] text-xl font-black text-[#D5F36A]">↗</span>
                        <h2 class="mt-4 font-bold text-[#123B35]">Mon historique</h2>
                        <p class="mt-1 text-sm text-[#596762]">Consulter les dépôts et retraits effectués sur votre compte.</p>
                    </Link>
                </div>

                <aside class="space-y-5">
                    <section class="rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                        <h2 class="text-lg font-extrabold text-[#123B35]">Mon compte</h2>
                        <dl class="mt-4 space-y-4">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Nom complet</dt>
                                <dd class="mt-1 font-semibold">{{ user.name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Téléphone</dt>
                                <dd class="mt-1 font-semibold">{{ user.phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Rôle</dt>
                                <dd class="mt-1 inline-flex rounded-full bg-[#D5F36A]/50 px-3 py-1 text-sm font-bold text-[#123B35]">Client</dd>
                            </div>
                        </dl>
                    </section>
                </aside>
            </section>

            <section class="mt-8">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-extrabold text-[#123B35]">Dernières transactions</h2>
                        <p class="mt-1 text-sm text-[#596762]">Les cinq opérations les plus récentes de votre portefeuille.</p>
                    </div>
                    <Link href="/transactions" class="text-sm font-bold text-[#246B57] hover:underline">Tout afficher →</Link>
                </div>
                <TransactionList :transactions="transactions" />
            </section>
        </div>
    </main>
</template>
