<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Button} from '@/Components/ui/button';
import { Table,TableBody,TableCell,TableHead,TableHeader,TableRow } from '@/Components/ui/table';
import { Pencil, Trash2, Eye, UserPlus } from 'lucide-vue-next';

interface Client {
    id: number;
    name: string;
    email:string;
    phone:string;
    pets?:Array<any>;

}

defineProps<{
    clients: {
        data: Client[];
        links:any[];
    }
}>();

const getInitials = (name:string) => name.slice(0,2).toUpperCase();

</script>

<template>
    <Head title="Gestion de clientes"/>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-green-800 leading-tight">Clientes</h2>
                <Link :href="route('clients.create')">
                    <Button class="bg-green-800 text-white"><UserPlus class="w-4 h-4"/> Nuevo cliente</Button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border">

                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead class="w-[100px]">ID</TableHead>
                                <TableHead>Nombre</TableHead>
                                <TableHead>Contacto</TableHead>
                                <TableHead class="text-right">Acciones</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="client in clients.data" :key="client.id">
                                <TableCell class="font-medium">{{ client.id }}</TableCell>
                                <TableCell>
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                            {{ getInitials(client.name) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ client.name }}</span>
                                            <span class="text-xs text-gray-500">{{ client.email || 'Sin email' }}</span>
                                        </div>
                                    </div>
                                </TableCell>
                                <TableCell>{{ client.phone }}</TableCell>
                                <TableCell class="text-right flex items-center justify-end gap-3">
                                    <Link :href="route('clients.show', client.id)">
                                        <Button variant="outline" size="icon" class="p-2 bg-orange-500">
                                            <Eye class="w-4 h-4 text-white" /> </Button>
                                    </Link>

                                    <Link :href="route('clients.edit', client.id)">
                                        <Button variant="outline" size="icon" class="p-2 bg-blue-600">
                                            <Pencil class="w-4 h-4 text-white" />
                                        </Button>
                                    </Link>

                                    <Button variant="outline" size="icon" class="p-2 bg-red-500">
                                        <Trash2 class="w-4 h-4 text-white" />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>

                    <div v-if="clients.data.length === 0" class="text-center py-10 text-gray-500">
                        No hay clientes registrados aún.
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
