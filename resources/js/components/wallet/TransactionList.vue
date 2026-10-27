<script setup lang="ts">
import type { Transaction } from '../../types/wallet'
import { formatCurrency } from '../../utils/currency'

defineProps<{
    transactions: Transaction[]
}>()

function transactionLabel(type: Transaction['type']): string {
    const labels: Record<Transaction['type'], string> = {
        deposit: 'Dépôt',
        withdrawal: 'Retrait',
        transfer: 'Transfert',
    }

    return labels[type]
}

function statusLabel(status: Transaction['status']): string {
    const labels: Record<Transaction['status'], string> = {
        pending: 'En attente',
        completed: 'Terminée',
        failed: 'Échouée',
    }

    return labels[status]
}
</script>

<template>
    <section class="rounded-2xl bg-white p-5 shadow-sm sm:p-6">
        <h2 class="text-lg font-bold">Transactions récentes</h2>

        <div
            v-if="transactions.length"
            class="mt-4 divide-y divide-gray-100"
        >
            <article
                v-for="transaction in transactions"
                :key="transaction.id"
                class="flex items-center justify-between gap-4 py-4"
            >
                <div class="min-w-0">
                    <p class="font-semibold">
                        {{ transactionLabel(transaction.type) }}
                    </p>

                    <p class="mt-1 truncate text-xs text-gray-500">
                        Réf. {{ transaction.reference }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ statusLabel(transaction.status) }}
                    </p>
                </div>

                <p class="shrink-0 font-bold text-[#123B35]">
                    {{ formatCurrency(transaction.amount) }}
                </p>
            </article>
        </div>

        <p v-else class="py-8 text-center text-sm text-gray-500">
            Aucune transaction pour le moment.
        </p>
    </section>
</template>