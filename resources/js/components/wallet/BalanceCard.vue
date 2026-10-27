<script setup lang="ts">
import type { Wallet } from '../../types/wallet'
import { formatCurrency } from '../../utils/currency'

defineProps<{
    wallet: Wallet | null
}>()
</script>

<template>
    <section class="rounded-3xl bg-[#123B35] p-6 text-white sm:p-8">
        <p class="text-sm text-white/70">Solde disponible</p>

        <p v-if="wallet" class="mt-3 text-3xl font-extrabold sm:text-4xl">
            {{ formatCurrency(wallet.balance) }}
        </p>

        <p v-else class="mt-3 text-xl font-bold">
            Aucun portefeuille
        </p>

        <p class="mt-4 text-sm text-white/70">
            Portefeuille FlexPay · {{ wallet?.currency ?? 'XOF' }}
        </p>
    </section>
</template>