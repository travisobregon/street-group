<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import Toaster from '@/Components/ui/toast/Toaster.vue';
import { cn } from '@/lib/utils';
import { CircleUser, MapPinHouse, Menu } from 'lucide-vue-next';
</script>

<template>
    <div class="flex min-h-screen w-full flex-col">
        <header
            class="sticky top-0 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-6"
        >
            <nav
                class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6"
            >
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-2 text-lg font-semibold md:text-base"
                >
                    <MapPinHouse class="h-6 w-6" />
                    <span class="sr-only">Street Group</span>
                </Link>
                <Link
                    :href="route('homeowners.index')"
                    :class="
                        cn(
                            'transition-colors hover:text-foreground',
                            route().current('homeowners.index')
                                ? 'text-foreground'
                                : 'text-muted-foreground',
                        )
                    "
                >
                    Homeowners
                </Link>
            </nav>
            <Sheet>
                <SheetTrigger as-child>
                    <Button
                        variant="outline"
                        size="icon"
                        class="shrink-0 md:hidden"
                    >
                        <Menu class="h-5 w-5" />
                        <span class="sr-only">Toggle navigation menu</span>
                    </Button>
                </SheetTrigger>
                <SheetContent side="left">
                    <nav class="grid gap-6 text-lg font-medium">
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center gap-2 text-lg font-semibold"
                        >
                            <MapPinHouse class="h-6 w-6" />
                            <span class="sr-only">Street Group</span>
                        </Link>
                        <Link
                            :href="route('homeowners.index')"
                            :class="
                                cn(
                                    'transition-colors hover:text-foreground',
                                    route().current('homeowners.index')
                                        ? ''
                                        : 'text-muted-foreground',
                                )
                            "
                        >
                            Homeowners
                        </Link>
                    </nav>
                </SheetContent>
            </Sheet>
            <div class="flex w-full justify-end">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button
                            variant="secondary"
                            size="icon"
                            class="rounded-full"
                        >
                            <CircleUser class="h-5 w-5" />
                            <span class="sr-only">Toggle user menu</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem>
                            <Link :href="route('logout')" method="post">
                                Logout
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </header>
        <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-8">
            <slot />
        </main>
        <Toaster />
    </div>
</template>
