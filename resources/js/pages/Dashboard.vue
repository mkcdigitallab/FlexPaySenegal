<script setup lang="ts">
import { computed, ref } from 'vue'
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

type OperationType = 'deposit' | 'withdrawal'

const activeOperation = ref<OperationType | null>(null)
const clientPhone = ref('')
const amount = ref('')
const errors = ref<{ phone?: string; amount?: string; general?: string }>({})
const notice = ref('')

const operationTitle = computed(() =>
    activeOperation.value === 'deposit' ? 'Nouveau dépôt' : 'Nouveau retrait',
)

const numericBalance = computed(() => Number(windowBalance.value ?? 0))
const windowBalance = ref<number | string>(0)

function openOperation(type: OperationType) {
    activeOperation.value = type
    clientPhone.value = ''
    amount.value = ''
    errors.value = {}
    notice.value = ''
    windowBalance.value = 0
}

function closeOperation() {
    activeOperation.value = null
    errors.value = {}
}

function validateOperation(): boolean {
    errors.value = {}
    const phone = clientPhone.value.trim()
    const value = Number(amount.value)

    if (!/^7\d{8}$/.test(phone)) {
        errors.value.phone = 'Saisissez un numéro sénégalais de 9 chiffres commençant par 7.'
    }

    if (!amount.value.trim() || !Number.isFinite(value) || value <= 0) {
        errors.value.amount = 'Le montant doit être supérieur à 0 FCFA.'
    } else if (!Number.isInteger(value)) {
        errors.value.amount = 'Saisissez un montant entier en FCFA.'
    } else if (activeOperation.value === 'withdrawal' && value > numericBalance.value) {
        errors.value.amount = 'Le montant dépasse le solde électronique affiché pour cet agent.'
    }

    return Object.keys(errors.value).length === 0
}

function submitOperation() {
    if (!validateOperation()) return

    // Exercice Vue : cette action est une simulation côté interface.
    // Aucun solde ni aucune transaction ne sont modifiés en base de données.
    notice.value = `${operationTitle.value} simulé pour ${clientPhone.value.trim()} : ${formatCurrency(Number(amount.value))}. Aucune opération n'a été enregistrée.`
    closeOperation()
}

function logout() {
    router.post('/logout')
}
</script>

<template>
    <Head title="Tableau de bord agent — FlexPay" />

    <main class="min-h-screen bg-[#F7F6F0] px-4 py-6 text-[#18211F] sm:px-8">
        <div class="mx-auto max-w-6xl">
            <header class="flex flex-wrap items-center justify-between gap-4">
                <Link href="/dashboard" class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#123B35] text-lg font-black text-[#D5F36A]">F</span>
                    <span>
                        <span class="block text-lg font-extrabold text-[#123B35]">FlexPay</span>
                        <span class="block text-xs text-[#596762]">Sénégal · Espace agent</span>
                    </span>
                </Link>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm font-semibold text-[#596762] sm:inline">{{ user.name }}</span>
                    <button type="button" class="rounded-xl border border-[#123B35]/15 bg-white px-4 py-2 text-sm font-bold text-[#123B35] transition hover:bg-[#123B35] hover:text-white" @click="logout">
                        Se déconnecter
                    </button>
                </div>
            </header>

            <section class="mt-8">
                <p class="text-sm font-bold uppercase tracking-[0.16em] text-[#246B57]">Espace professionnel</p>
                <h1 class="mt-2 text-3xl font-black text-[#123B35] sm:text-4xl">Bonjour, {{ user.name }}</h1>
                <p class="mt-2 text-[#596762]">Gérez les dépôts et les retraits des clients depuis votre espace agent.</p>
            </section>

            <div v-if="notice" role="status" class="mt-6 flex items-start justify-between gap-4 rounded-xl border border-[#246B57]/20 bg-white p-4 text-sm text-[#123B35]">
                <p>{{ notice }}</p>
                <button type="button" class="font-bold" aria-label="Fermer le message" @click="notice = ''">×</button>
            </div>

            <section class="mt-7 grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="space-y-5">
                    <BalanceCard :wallet="wallet" />

                    <section class="rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h2 class="text-lg font-extrabold text-[#123B35]">Opérations de caisse</h2>
                                <p class="mt-1 text-sm text-[#596762]">Choisissez l'opération demandée par le client.</p>
                            </div>
                            <span class="rounded-full bg-[#D5F36A]/50 px-3 py-1 text-xs font-bold text-[#123B35]">Mode exercice</span>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            <button type="button" class="group rounded-2xl border border-[#246B57]/20 p-5 text-left transition hover:border-[#246B57] hover:bg-[#F7F6F0]" @click="openOperation('deposit')">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#D5F36A] text-2xl font-black text-[#123B35]">↓</span>
                                <span class="mt-4 block font-extrabold text-[#123B35]">Effectuer un dépôt</span>
                                <span class="mt-1 block text-sm text-[#596762]">Créditer le portefeuille d'un client après réception des espèces.</span>
                            </button>
                            <button type="button" class="group rounded-2xl border border-[#246B57]/20 p-5 text-left transition hover:border-[#246B57] hover:bg-[#F7F6F0]" @click="openOperation('withdrawal')">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#123B35] text-2xl font-black text-[#D5F36A]">↑</span>
                                <span class="mt-4 block font-extrabold text-[#123B35]">Effectuer un retrait</span>
                                <span class="mt-1 block text-sm text-[#596762]">Préparer le retrait d'espèces demandé par un client.</span>
                            </button>
                        </div>
                    </section>

                    <section class="grid gap-3 sm:grid-cols-2">
                        <Link href="/transactions" class="rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#123B35] text-xl font-black text-[#D5F36A]">↗</span>
                            <h2 class="mt-4 font-bold text-[#123B35]">Historique des transactions</h2>
                            <p class="mt-1 text-sm text-[#596762]">Consulter les opérations enregistrées.</p>
                        </Link>
                        <Link href="/wallet" class="rounded-2xl bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#D5F36A] text-xl font-black text-[#123B35]">₣</span>
                            <h2 class="mt-4 font-bold text-[#123B35]">Détails du portefeuille</h2>
                            <p class="mt-1 text-sm text-[#596762]">Consulter le solde et la devise du compte.</p>
                        </Link>
                    </section>
                </div>

                <aside class="space-y-5">
                    <section class="rounded-2xl bg-white p-5 shadow-sm sm:p-6">
                        <h2 class="text-lg font-extrabold text-[#123B35]">Mon compte agent</h2>
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
                                <dd class="mt-1 inline-flex rounded-full bg-[#D5F36A]/50 px-3 py-1 text-sm font-bold text-[#123B35]">Agent</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wide text-[#596762]">Portefeuille électronique</dt>
                                <dd class="mt-1 text-xl font-black text-[#123B35]">{{ formatCurrency(wallet?.balance ?? 0) }}</dd>
                            </div>
                        </dl>
                    </section>

                    <section class="rounded-2xl bg-[#123B35] p-5 text-white sm:p-6">
                        <h2 class="text-lg font-extrabold">Avant de confirmer</h2>
                        <ul class="mt-3 space-y-2 text-sm text-white/85">
                            <li>• Vérifier le numéro du client.</li>
                            <li>• Vérifier le montant et le sens de l'opération.</li>
                            <li>• Pour un dépôt, recevoir les espèces avant validation.</li>
                            <li>• Pour un retrait, vérifier l'identité et le solde du client.</li>
                        </ul>
                    </section>
                </aside>
            </section>

            <section class="mt-8">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-extrabold text-[#123B35]">Dernières transactions</h2>
                        <p class="mt-1 text-sm text-[#596762]">Les cinq opérations les plus récentes enregistrées sur votre portefeuille.</p>
                    </div>
                    <Link href="/transactions" class="text-sm font-bold text-[#246B57] hover:underline">Tout afficher →</Link>
                </div>
                <TransactionList :transactions="transactions" />
            </section>

            <p class="mt-8 text-center text-xs text-[#596762]">
                Projet pédagogique — les formulaires dépôt/retrait sont simulés côté Vue et ne modifient pas la base de données.
            </p>
        </div>

        <div v-if="activeOperation" class="fixed inset-0 z-50 flex items-center justify-center bg-[#18211F]/60 p-4" @click.self="closeOperation">
            <section role="dialog" aria-modal="true" :aria-label="operationTitle" class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#246B57]">Espace agent</p>
                        <h2 class="mt-2 text-2xl font-black text-[#123B35]">{{ operationTitle }}</h2>
                        <p class="mt-2 text-sm text-[#596762]">Renseignez les informations, puis vérifiez-les avant de simuler l'opération.</p>
                    </div>
                    <button type="button" class="rounded-full bg-[#F7F6F0] px-3 py-1 text-xl font-bold text-[#123B35]" aria-label="Fermer" @click="closeOperation">×</button>
                </div>

                <form class="mt-6 space-y-4" @submit.prevent="submitOperation" novalidate>
                    <div>
                        <label for="client-phone" class="mb-1 block text-sm font-bold text-[#18211F]">Téléphone du client</label>
                        <input id="client-phone" v-model="clientPhone" type="tel" inputmode="numeric" autocomplete="off" placeholder="Ex. 771234567" class="w-full rounded-xl border border-[#596762]/30 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/20" :aria-invalid="Boolean(errors.phone)" />
                        <p v-if="errors.phone" class="mt-1 text-sm font-medium text-red-700">{{ errors.phone }}</p>
                    </div>

                    <div>
                        <label for="operation-amount" class="mb-1 block text-sm font-bold text-[#18211F]">Montant (FCFA)</label>
                        <input id="operation-amount" v-model="amount" type="number" min="1" step="1" inputmode="numeric" placeholder="Ex. 5000" class="w-full rounded-xl border border-[#596762]/30 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/20" :aria-invalid="Boolean(errors.amount)" />
                        <p v-if="errors.amount" class="mt-1 text-sm font-medium text-red-700">{{ errors.amount }}</p>
                    </div>

                    <div class="rounded-xl bg-[#F7F6F0] p-4 text-sm text-[#596762]">
                        <p class="font-bold text-[#123B35]">Rappel de sécurité</p>
                        <p class="mt-1">Confirmez l'identité du client et la réception/remise des espèces en dehors de cette simulation.</p>
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button" class="rounded-xl border border-[#123B35]/20 px-4 py-3 font-bold text-[#123B35]" @click="closeOperation">Annuler</button>
                        <button type="submit" class="rounded-xl bg-[#123B35] px-5 py-3 font-bold text-white transition hover:bg-[#246B57]">Vérifier et simuler</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</template>
