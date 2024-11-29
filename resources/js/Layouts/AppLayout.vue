<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-white">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <i class="text-2xl text-gray-500">🧁</i>
                                    Cupcakes online
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <NavLink :href="route('orders.track', {id: 1})" :active="route().current('orders.track')">
                                    Meu Pedido
                                </NavLink>
                            </div>
                            <div v-if="$page.props.auth.user" class="flex">
                                <div class="ms-3 relative">
                                    <NavLink :href="route('management.products.list')" :active="route().current('management.products.list')">
                                        Produtos
                                    </NavLink>
                                </div>
                                <div class="ms-3 relative">
                                    <NavLink :href="route('management.orders.list')" :active="route().current('management.orders.list')">
                                        Pedidos
                                    </NavLink>
                                </div>
                                <div class="ms-3 relative">
                                    <button @click="logout">
                                        Sair
                                    </button>
                                </div>
                            </div>
                            <Link :href="route('checkout.details')">
                                <div class="ms-5 relative">
                                    <div class="ms-5 relative">
                                        <button>
                                            <i class="text-xl me-2">🛒</i>
                                        </button>
                                    </div>
                                </div>
                            </Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4" v-if="$page.props.auth.user">
                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>


        <div>
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="flex justify-between">
                        <a href="https://laravel.com" class="text-sm text-gray-500">Sobre nós</a>
                        <a href="https://laracasts.com" class="text-sm text-gray-500">Visite-Nos</a>
                        <a href="https://laravel-news.com" class="text-sm text-gray-500">Trablhe conosco</a>
                        <a href="" class="text-sm text-gray-500">Política de privacidade</a>
                        <a href="" class="text-sm text-gray-500">Termos de uso</a>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <a href="https://instagram.com" class="text-sm text-gray-500">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                        <a href="https://twitter.com" class="text-sm text-gray-500">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="https://facebook.com" class="text-sm text-gray-500">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                    </div>

                    <div class="text-center mt-6 text-sm text-gray-500">
                        &copy; 2021 Cupcakes online
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
