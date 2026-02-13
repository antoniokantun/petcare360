<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Save, ArrowLeft } from 'lucide-vue-next';
import { watch, ref } from 'vue';

// 1. useForm de Inertia.
const form = useForm({
    name: '',
    lastname:'',
    email: '',
    phone: '',
    address: ''
});

const phoneClientError = ref('');

const submit = () => {
    const digits = form.phone.replace(/\s/g, '');
    if (digits.length < 10) {
        phoneClientError.value = 'El teléfono solo debe contener números.';
        return;
    }

    phoneClientError.value = '';
    form.phone = digits;

    form.post(route('clients.store'), {
        onSuccess: () => form.reset(),
    });
};

watch(() => form.phone, (newValue) => {
    let digits = newValue.replace(/\s/g, '');
    let formatted = '';
    if (digits.length > 0) {
        formatted += digits.substring(0, 2);
    }
    if (digits.length > 2) {
        formatted += ' ' + digits.substring(2, 6);
    }
    if (digits.length > 6) {
        formatted += ' ' + digits.substring(6, 10);
    }
    form.phone = formatted;
});

</script>

<template>
    <Head title="Nuevo Cliente" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('clients.index')">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="w-4 h-4" />
                    </Button>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar nuevo cliente</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">

                    <form @submit.prevent="submit" class="space-y-6">

                        <div class="space-y-2">
                            <Label for="name">Nombre *</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="Ej: Juan Carlos"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>
                        <div class="space-y-2">
                            <Label for="lastaname">Apellido</Label>
                            <Input
                                id="lastname"
                                v-model="form.lastname"
                                placeholder="Ej: Pérez Luna"
                                :class="{ 'border-red-500': form.errors.lastname }"
                            />
                            <p v-if="form.errors.lastname" class="text-sm text-red-500">{{ form.errors.lastname }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="phone">Teléfono *</Label>
                            <Input
                                id="phone"
                                v-model="form.phone"
                                placeholder="Ej: 55 1234 5678"
                                maxlength="12"
                            />
                            <p v-if="phoneClientError" class="text-sm text-red-500">{{ phoneClientError}}</p>
                            <p v-else-if="form.errors.phone" class="text-sm text-red-500">{{ form.errors.phone }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="email">Correo Electrónico</Label>
                            <Input
                                id="email"
                                type="email"
                                v-model="form.email"
                                placeholder="juan@correo.com"
                            />
                            <p v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="address">Dirección</Label>
                            <Textarea
                                id="address"
                                v-model="form.address"
                                placeholder="Calle Principal #123, Colonia Centro..."
                                class="resize-none"
                            />
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <Link :href="route('clients.index')">
                                <Button type="button" variant="ghost">Cancelar</Button>
                            </Link>

                            <Button type="submit" :disabled="form.processing">
                                <Save class="w-4 h-4 mr-2" />
                                Guardar Cliente
                            </Button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
