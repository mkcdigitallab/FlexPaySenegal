<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import TransactionList from '../../components/wallet/TransactionList.vue'
import type {
    PaginatedTransactions,
    Transaction,
} from '../../types/wallet'

defineProps<{
    transactions: PaginatedTransactions | Transaction[]
}>()
</script>

<template>
    <main class="min-h-screen bg-[#F7F6F0] px-4 py-6 text-[#18211F] sm:px-8">
        <div class="mx-auto max-w-4xl">
            <Link
                href="/dashboard"
                class="text-sm font-semibold text-[#246B57]"
            >
                ← Retour au tableau de bord
            </Link>

            <h1 class="mb-6 mt-6 text-3xl font-extrabold">
                Historique des transactions
            </h1>

            <TransactionList
                :transactions="
                    Array.isArray(transactions)
                        ? transactions
                        : transactions.data
                "
            />

            <nav
                v-if="
                    !Array.isArray(transactions)
                    && transactions.last_page > 1
                "
                class="mt-6 flex flex-wrap justify-center gap-2"
                aria-label="Pagination des transactions"
            >
                <Link
                    v-for="page in transactions.last_page"
                    :key="page"
                    :href="`/transactions?page=${page}`"
                    class="rounded-lg px-4 py-2 text-sm font-semibold"
                    :class="
                        page === transactions.current_page
                            ? 'bg-[#123B35] text-white'
                            : 'bg-white text-[#18211F]'
                    "
                >
                    {{ page }}
                </Link>
            </nav>
        </div>
    </main>
</template>
