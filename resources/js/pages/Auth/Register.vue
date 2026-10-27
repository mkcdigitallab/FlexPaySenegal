<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post('/register')
}
</script>

<template>
    <Head title="Créer un compte — FlexPay" />

    <main class="flex min-h-screen items-center justify-center bg-[#F7F6F0] px-4 py-10 text-[#18211F]">
        <section class="w-full max-w-lg rounded-3xl bg-white p-7 shadow-sm sm:p-9">
            <Link href="/" class="text-sm font-bold text-[#246B57]">
                ← FlexPay
            </Link>

            <div class="mt-8">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#246B57]">
                    Rejoignez FlexPay
                </p>
                <h1 class="mt-2 text-3xl font-extrabold text-[#123B35]">
                    Créer un compte
                </h1>
                <p class="mt-2 text-sm text-[#596762]">
                    Un portefeuille XOF sera créé automatiquement pour vous.
                </p>
            </div>

            <form class="mt-8 space-y-5" @submit.prevent="submit">
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold">Nom complet</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="name"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.name" class="mt-2 text-sm text-red-700">{{ form.errors.name }}</p>
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold">Numéro de téléphone</label>
                    <input
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        autocomplete="tel"
                        required
                        placeholder="Ex. 77 123 45 67"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.phone" class="mt-2 text-sm text-red-700">{{ form.errors.phone }}</p>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold">Adresse e-mail <span class="font-normal text-[#596762]">(facultatif)</span></label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.email" class="mt-2 text-sm text-red-700">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold">Mot de passe</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-700">{{ form.errors.password }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold">Confirmer le mot de passe</label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-xl bg-[#123B35] px-4 py-3 font-bold text-white transition hover:bg-[#246B57] disabled:cursor-not-allowed disabled:opacity-60"
                >
                    {{ form.processing ? 'Création du compte…' : 'Créer mon compte' }}
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#596762]">
                Vous avez déjà un compte ?
                <Link href="/login" class="font-bold text-[#246B57] underline underline-offset-4">
                    Se connecter
                </Link>
            </p>

            <p class="mt-6 text-center text-xs text-[#596762]">
                Prototype éducatif — aucune transaction réelle.
            </p>
        </section>
    </main>
</template>
