<script setup lang="ts">
import Button from '@/Components/ui/button/Button.vue';
import Card from '@/Components/ui/card/Card.vue';
import CardContent from '@/Components/ui/card/CardContent.vue';
import CardFooter from '@/Components/ui/card/CardFooter.vue';
import CardHeader from '@/Components/ui/card/CardHeader.vue';
import CardTitle from '@/Components/ui/card/CardTitle.vue';
import Dialog from '@/Components/ui/dialog/Dialog.vue';
import DialogContent from '@/Components/ui/dialog/DialogContent.vue';
import DialogFooter from '@/Components/ui/dialog/DialogFooter.vue';
import DialogHeader from '@/Components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/Components/ui/dialog/DialogTitle.vue';
import DialogTrigger from '@/Components/ui/dialog/DialogTrigger.vue';
import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import Table from '@/Components/ui/table/Table.vue';
import TableBody from '@/Components/ui/table/TableBody.vue';
import TableCell from '@/Components/ui/table/TableCell.vue';
import TableHead from '@/Components/ui/table/TableHead.vue';
import TableHeader from '@/Components/ui/table/TableHeader.vue';
import TableRow from '@/Components/ui/table/TableRow.vue';
import { useToast } from '@/Components/ui/toast';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';
import { ref } from 'vue';

interface Homeowner {
    id: number;
    title: string;
    first_name?: string;
    initial?: string;
    last_name: string;
    created_at: string;
    updated_at: string;
}

interface HomeownersProps {
    data: Homeowner[];
    prev_page_url?: string;
    next_page_url?: string;
}

defineProps<{ homeowners: HomeownersProps }>();

const open = ref(false);

const { toast } = useToast();
const form = useForm({
    file: null,
});

function submit() {
    form.post(route('homeowners.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast({
                description: 'Homeowners imported successfully',
            });
        },
        onError: () => {
            toast({
                description: form.errors.file,
                variant: 'destructive',
            });
        },
        onFinish: () => {
            open.value = false;
        },
    });
}
</script>

<template>
    <Head title="Homeowners" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-end gap-2">
            <Dialog :open="open" @update:open="(value) => (open = value)">
                <DialogTrigger as-child>
                    <Button size="sm" class="h-7 gap-1">
                        <PlusCircle class="h-3.5 w-3.5" />
                        <span
                            class="sr-only sm:not-sr-only sm:whitespace-nowrap"
                        >
                            Import Homeowners
                        </span>
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Import Homeowners</DialogTitle>
                    </DialogHeader>

                    <form id="importHomeownersForm" @submit.prevent="submit">
                        <div class="grid w-full max-w-sm items-center gap-1.5">
                            <Label for="file">File</Label>
                            <Input
                                id="file"
                                type="file"
                                accept=".csv"
                                @input="form.file = $event.target.files[0]"
                            />
                        </div>
                    </form>

                    <DialogFooter>
                        <Button type="submit" form="importHomeownersForm">
                            Submit
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
        <Card>
            <CardHeader>
                <CardTitle>Homeowners</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>First name</TableHead>
                            <TableHead>Initial</TableHead>
                            <TableHead>Last name</TableHead>
                            <TableHead class="hidden md:table-cell">
                                Created at
                            </TableHead>
                            <TableHead class="hidden md:table-cell">
                                Updated at
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="homeowner in homeowners.data"
                            :key="homeowner.id"
                        >
                            <TableCell>{{ homeowner.title }}</TableCell>
                            <TableCell>{{ homeowner.first_name }}</TableCell>
                            <TableCell>{{ homeowner.initial }}</TableCell>
                            <TableCell>{{ homeowner.last_name }}</TableCell>
                            <TableCell class="hidden md:table-cell">
                                {{ homeowner.created_at }}
                            </TableCell>
                            <TableCell class="hidden md:table-cell">
                                {{ homeowner.updated_at }}
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <div class="flex items-center justify-end space-x-2 py-4">
                    <Button
                        v-if="homeowners.prev_page_url"
                        :as="Link"
                        variant="outline"
                        size="sm"
                        :href="homeowners.prev_page_url"
                    >
                        Previous
                    </Button>
                    <Button v-else disabled variant="outline" size="sm">
                        Previous
                    </Button>

                    <Button
                        v-if="homeowners.next_page_url"
                        :as="Link"
                        variant="outline"
                        size="sm"
                        :href="homeowners.next_page_url"
                    >
                        Next
                    </Button>
                    <Button v-else disabled variant="outline" size="sm">
                        Next
                    </Button>
                </div>
            </CardFooter>
        </Card>
    </AuthenticatedLayout>
</template>
