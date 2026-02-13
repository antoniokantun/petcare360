<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/Components/ui/select';
import { ArrowLeft, Save, PawPrint } from 'lucide-vue-next';

const props = defineProps<{
    client: {
        id: number;
        name: string;
    }
}>();

const form = useForm({
    client_id: props.client.id,
    name: '',
    species: '',
    breed: '',
    age: '',
    weight: '',
});

const submit = () => {
    form.post(route('pets.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Nueva Mascota" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('clients.show', client.id)">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="w-4 h-4" />
                    </Button>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Agregando Mascota para: <span class="text-blue-600">{{ client.name }}</span>
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">

                    <form @submit.prevent="submit" class="space-y-6">

                        <div class="space-y-2">
                            <Label for="name">Nombre de la Mascota *</Label>
                            <Input id="name" v-model="form.name" placeholder="Ej: Firulais" />
                            <p v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label>Especie *</Label>
                            <Select v-model="form.species">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona una especie" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="Perro">Perro</SelectItem>
                                    <SelectItem value="Gato">Gato</SelectItem>
                                    <SelectItem value="Ave">Ave</SelectItem>
                                    <SelectItem value="Roedor">Roedor</SelectItem>
                                    <SelectItem value="Otro">Otro</SelectItem>
                                </SelectContent>
                            </Select>
                            <p v-if="form.errors.species" class="text-sm text-red-500">{{ form.errors.species }}</p>
                        </div>

                        <div class="space-y-2">
                            <Label for="breed">Raza</Label>
                            <Input id="breed" v-model="form.breed" placeholder="Ej: Golden Retriever" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <Label for="age">Edad (Años)</Label>
                                <Input id="age" type="number" v-model="form.age" placeholder="Ej: 5" />
                            </div>

                            <div class="space-y-2">
                                <Label for="weight">Peso (Kg)</Label>
                                <Input id="weight" type="number" step="0.1" v-model="form.weight" placeholder="Ej: 12.5" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <Button type="submit" :disabled="form.processing">
                                <PawPrint class="w-4 h-4 mr-2" />
                                Registrar Mascota
                            </Button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
