<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import BalanceCard from '../../components/wallet/BalanceCard.vue'
import type { Wallet } from '../../types/wallet'

defineProps<{
    wallet: Wallet | null
}>()
</script>

<template>
    <main class="min-h-screen bg-[#F7F6F0] px-4 py-6 text-[#18211F] sm:px-8">
        <div class="mx-auto max-w-3xl">
            <Link
                href="/dashboard"
                class="text-sm font-semibold text-[#246B57]"
            >
                ← Retour au tableau de bord
            </Link>

            <h1 class="mb-6 mt-6 text-3xl font-extrabold">
                Mon portefeuille
            </h1>

            <BalanceCard :wallet="wallet" />

            <div class="mt-6 rounded-2xl bg-white p-5 shadow-sm">
                <h2 class="font-bold">Informations du portefeuille</h2>

                <p class="mt-3 text-sm text-gray-600">
                    Devise : {{ wallet?.currency ?? 'XOF' }}
                </p>

                <p class="mt-2 text-sm text-gray-600">
                    Identifiant : {{ wallet?.id ?? 'Non disponible' }}
                </p>
            </div>
        </div>
    </main>
</template>