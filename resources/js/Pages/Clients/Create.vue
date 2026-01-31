<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Save, ArrowLeft } from 'lucide-vue-next';

// 1. useForm es el "superpoder" de Inertia.
// Maneja los valores, el envío y los errores de validación automáticamente.
const form = useForm({
    name: '',
    email: '',
    phone: '',
    address: ''
});

// 2. Función para enviar el formulario
const submit = () => {
    form.post(route('clients.store'), {
        onFinish: () => form.reset(),
    });
};
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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Nuevo Cliente</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">

                    <form @submit.prevent="submit" class="space-y-6">

                        <div class="space-y-2">
                            <Label for="name">Nombre Completo *</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="Ej: Juan Pérez"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="phone">Teléfono *</Label>
                            <Input
                                id="phone"
                                v-model="form.phone"
                                placeholder="Ej: 55 1234 5678"
                            />
                            <p v-if="form.errors.phone" class="text-sm text-red-500">{{ form.errors.phone }}</p>
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
