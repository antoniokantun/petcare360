<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Badge } from '@/Components/ui/badge';
import {Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from '@/Components/ui/table';
import { ArrowLeft, Phone, Mail, MapPin, PawPrint, Plus } from 'lucide-vue-next';

interface Pet {
    id: number;
    name: string;
    species: string;
    breed: string | null;
    age: number | null;
    weight: number | null;
}

interface Client {
    id: number;
    name: string;
    email: string | null;
    phone: string;
    address: string | null;
    pets: Pet[];
}

defineProps<{
    client: Client;
}>();

</script>

<template>
    <Head :title="`Cliente: ${client.name}`" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('clients.index')">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="w-4 h-4" />
                    </Button>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Expediente del Cliente
                </h2>
            </div>
        </template>

        <div v-if="client" class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <Card>
                    <CardHeader>
                        <CardTitle class="text-2xl font-bold flex items-center gap-2">
                            {{ client?.name }}
                            <Badge variant="secondary">Cliente #{{ client.id }}</Badge>
                        </CardTitle>
                        <CardDescription>Información de contacto y ubicación</CardDescription>
                    </CardHeader>
                    <CardContent class="grid gap-4 md:grid-cols-2">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border">
                            <Phone class="w-5 h-5 text-blue-500" />
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Teléfono</p>
                                <p class="text-gray-900">{{ client.phone }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border">
                            <Mail class="w-5 h-5 text-blue-500" />
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Correo Electrónico</p>
                                <p class="text-gray-900">{{ client.email || 'No registrado' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border md:col-span-2">
                            <MapPin class="w-5 h-5 text-blue-500" />
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Dirección</p>
                                <p class="text-gray-900">{{ client.address || 'Sin dirección registrada' }}</p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between">
                        <div>
                            <CardTitle class="flex items-center gap-2">
                                <PawPrint class="w-6 h-6 text-orange-500" />
                                Mascotas Registradas
                            </CardTitle>
                            <CardDescription>
                                Listado de mascotas asociados a este dueño
                            </CardDescription>
                        </div>
                        <Link :href="route('pets.create', {client_id: client.id})">
                            <Button size="sm">
                                <Plus class="w-4 h-4 mr-2" />
                                Agregar Mascota
                            </Button>
                        </Link>

                    </CardHeader>

                    <CardContent>
                        <Table v-if="client.pets?.length">
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nombre</TableHead>
                                    <TableHead>Especie</TableHead>
                                    <TableHead>Raza</TableHead>
                                    <TableHead>Edad</TableHead>
                                    <TableHead class="text-right">Acciones</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="pet in client.pets" :key="pet.id">
                                    <TableCell class="font-bold text-lg text-slate-700">
                                        {{ pet.name }}
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant="outline" class="uppercase text-xs">
                                            {{ pet.species }}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>{{ pet.breed || 'N/A' }}</TableCell>
                                    <TableCell>{{ pet.age ? `${pet.age} años` : '?' }}</TableCell>
                                    <TableCell class="text-right">
                                        <Button variant="ghost" size="sm">
                                            Historial
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>

                        <div v-else class="text-center py-10 text-gray-500 border-t border-dashed">
                            <PawPrint class="w-12 h-12 mx-auto text-gray-300 mb-3" />
                            <p>Este cliente aún no tiene mascotas registradas.</p>
                        </div>
                    </CardContent>
                </Card>

            </div>
        </div>

        <div v-else class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border text-center text-gray-500">
                    Cargando cliente...
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
