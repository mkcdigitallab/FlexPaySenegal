<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import BalanceCard from '../components/wallet/BalanceCard.vue'
import TransactionList from '../components/wallet/TransactionList.vue'
import type { Transaction, User, Wallet } from '../types/wallet'
import { formatCurrency } from '../utils/currency'

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
    <Head title="Tableau de bord — FlexPay" />

    <main class="min-h-screen bg-[#F7F6F0] px-4 py-6 text-[#18211F] sm:px-8">
        <div class="mx-auto max-w-5xl">
            <header class="flex flex-wrap items-center justify-between gap-4">
                <Link href="/" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#123B35] text-lg font-black text-[#D5F36A]">F</span>
                    <span>
                        <span class="block text-lg font-extrabold text-[#123B35]">FlexPay</span>
                        <span class="block text-xs text-[#596762]">Sénégal · XOF</span>
                    </span>
                </Link>

                <button
                    type="button"
                    class="rounded-xl border border-[#123B35]/15 bg-white px-4 py-2 text-sm font-bold text-[#123B35] transition hover:bg-[#123B35] hover:text-white"
                    @click="logout"
                >
                    Se déconnecter
                </button>
            </header>

            <section class="mt-8">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-[#246B57]">Espace personnel</p>
                <h1 class="mt-2 text-3xl font-black text-[#123B35] sm:text-4xl">
                    Bonjour, {{ user.name }}
                </h1>
                <p class="mt-2 text-[#596762]">
                    Voici un aperçu de votre portefeuille FlexPay.
                </p>
            </section>

            <section class="mt-8 grid gap-5 md:grid-cols-[1.2fr_0.8fr]">
                <div>
                    <BalanceCard :wallet="wallet" />
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <Link
                            href="/wallet"
                            class="rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        >
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D5F36A] text-xl font-black text-[#123B35]">₣</span>
                            <h2 class="mt-4 font-bold text-[#123B35]">Mon portefeuille</h2>
                            <p class="mt-1 text-sm text-[#596762]">Consulter les détails du solde</p>
                        </Link>

                        <Link
                            href="/transactions"
                            class="rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                        >
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#123B35] text-xl font-black text-[#D5F36A]">↗</span>
                            <h2 class="mt-4 font-bold text-[#123B35]">Historique</h2>
                            <p class="mt-1 text-sm text-[#596762]">Voir toutes les transactions</p>
                        </Link>
                    </div>
                </div>

                <section class="rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="text-lg font-bold text-[#123B35]">Mon compte</h2>
                    <dl class="mt-4 space-y-4">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Nom</dt>
                            <dd class="mt-1 font-semibold">{{ user.name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Téléphone</dt>
                            <dd class="mt-1 font-semibold">{{ user.phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Type de compte</dt>
                            <dd class="mt-1 inline-flex rounded-full bg-[#D5F36A]/40 px-3 py-1 text-sm font-bold text-[#123B35]">
                                {{ user.role === 'agent' ? 'Agent' : user.role === 'admin' ? 'Administrateur' : 'Client' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Solde disponible</dt>
                            <dd class="mt-1 text-xl font-black text-[#123B35]">
                                {{ formatCurrency(wallet?.balance ?? 0) }}
                            </dd>
                        </div>
                    </dl>
                </section>
            </section>

            <section class="mt-8">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-extrabold text-[#123B35]">Activité récente</h2>
                        <p class="mt-1 text-sm text-[#596762]">Les cinq dernières opérations de votre portefeuille.</p>
                    </div>
                    <Link href="/transactions" class="text-sm font-bold text-[#246B57] hover:underline">
                        Tout afficher →
                    </Link>
                </div>
                <TransactionList :transactions="transactions" />
            </section>

            <p class="mt-8 text-center text-xs text-[#596762]">
                Prototype éducatif — aucune transaction réelle n’est effectuée.
            </p>
        </div>
    </main>
</template>
