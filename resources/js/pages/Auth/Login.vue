<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    phone: '',
    password: '',
    remember: false,
})

function submit() {
    form.post('/login')
}
</script>

<template>
    <Head title="Connexion — FlexPay" />

    <main class="flex min-h-screen items-center justify-center bg-[#F7F6F0] px-4 py-10 text-[#18211F]">
        <section class="w-full max-w-md rounded-3xl bg-white p-7 shadow-sm sm:p-9">
            <Link href="/" class="text-sm font-bold text-[#246B57]">
                ← FlexPay
            </Link>

            <div class="mt-8">
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-[#246B57]">
                    Bon retour
                </p>
                <h1 class="mt-2 text-3xl font-extrabold text-[#123B35]">
                    Connectez-vous
                </h1>
                <p class="mt-2 text-sm text-[#596762]">
                    Accédez à votre portefeuille en toute simplicité.
                </p>
            </div>

            <form class="mt-8 space-y-5" @submit.prevent="submit">
                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold">
                        Numéro de téléphone
                    </label>
                    <input
                        id="phone"
                        v-model="form.phone"
                        type="tel"
                        autocomplete="tel"
                        required
                        autofocus
                        placeholder="Ex. 77 123 45 67"
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.phone" class="mt-2 text-sm text-red-700">
                        {{ form.errors.phone }}
                    </p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold">
                        Mot de passe
                    </label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[#246B57] focus:ring-2 focus:ring-[#246B57]/15"
                    />
                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-700">
                        {{ form.errors.password }}
                    </p>
                </div>

                <label class="flex items-center gap-2 text-sm text-[#596762]">
                    <input
                        v-model="form.remember"
                        type="checkbox"
                        class="rounded border-gray-300 accent-[#123B35]"
                    />
                    Rester connecté
                </label>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-xl bg-[#123B35] px-4 py-3 font-bold text-white transition hover:bg-[#246B57] disabled:cursor-not-allowed disabled:opacity-60"
                >
                    {{ form.processing ? 'Connexion…' : 'Se connecter' }}
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-[#596762]">
                Pas encore de compte ?
                <Link href="/register" class="font-bold text-[#246B57] underline underline-offset-4">
                    Créer un compte
                </Link>
            </p>

            <p class="mt-6 text-center text-xs text-[#596762]">
                Prototype éducatif — aucune transaction réelle.
            </p>
        </section>
    </main>
</template>
