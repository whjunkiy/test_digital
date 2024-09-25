<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot
} from "@headlessui/vue";
import {
    Bars3Icon,
    HomeIcon,
    XMarkIcon,
    ArrowRightEndOnRectangleIcon,
    ChatBubbleLeftRightIcon, PresentationChartLineIcon, WindowIcon, UsersIcon, BookOpenIcon
} from '@heroicons/vue/24/outline';

defineProps({
    title: String,
});

const navigation = [
    { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard')},
    { name: 'Reviews', href: route('widget-reviews'), icon: ChatBubbleLeftRightIcon, current: route().current('widget-reviews*')},
    { name: 'Widgets', href: route('user-widgets'), icon: WindowIcon, current: route().current('user-widgets*')},
    { name: 'Analytics', href: route('user-analytics'), icon: PresentationChartLineIcon, current: route().current('user-analytics')},
]

const adminNavigation = (isAdmin) => {
    if (isAdmin === true) {
        return [
            { name: 'Users', href: route('admin.users.list'), icon: UsersIcon, current: route().current('admin.users.*')},
        ]
    }

    return false;
}

const logout = () => {
    router.post(route('logout'));
};


const sidebarOpen = ref(false)

</script>

<template>
    <div class="bg-gray-50 min-h-screen w-[100%]">
        <Head :title="title" class="bg-white"/>

        <Banner />

        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                                <div class="flex h-16 shrink-0 items-center">
                                    <Link :href="route('dashboard')">
                                        <ApplicationMark class="block h-9 w-auto" />
                                    </Link>
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col">
                                        <li class="-mx-6">
                                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                                            <Link :href="route('profile.show')" :class="[route().current('profile.show') ? 'bg-gray-50 text-indigo-600' : 'hover:text-indigo-600 hover:bg-gray-50', 'flex items-center gap-x-3 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600']">
                                                <img v-if="$page.props.jetstream.managesProfilePhotos" class="h-8 w-8 rounded-full bg-gray-50" :src="$page.props.auth.user.profile_photo_url" alt="" />
                                                <span aria-hidden="true">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.second_name }}</span>
                                            </Link>
                                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                                        </li>
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <Link :href="item.href" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                        <li v-if="adminNavigation($page.props.auth.user.is_admin) !== false">
                                            <div class="h-0.5 b-0.5 w-py bg-gray-200" aria-hidden="true" />
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in adminNavigation($page.props.auth.user.is_admin)" :key="item.name">
                                                    <Link :href="item.href" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                        <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="-pb-6 -mx-6 mt-auto">
                                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true"/>
                                            <div class="ml-10 flex items-center text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600">
                                                <Link
                                                    class="flex items-center flex-row gap-x-2 px-20 py-5"
                                                    type="button"
                                                    :href="$page.props.auth.user.is_admin === true ? route('admin.help-articles.list') : route('user.help-article.list')"
                                                >
                                                    <component :is="BookOpenIcon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                                    FAQ
                                                </Link>
                                            </div>
                                        </li>
                                        <li class="-mx-6">
                                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                                            <form @submit.prevent="logout" class="flex items-center text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600">
                                                <button type="submit" class="flex items-center flex-row gap-x-2 px-28 py-5">
                                                    <component :is="ArrowRightEndOnRectangleIcon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                                    Log Out
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col shadow-2xl">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
                <div class="flex h-16 shrink-0 items-center">
                    <Link :href="route('dashboard')">
                        <ApplicationMark class="block h-9 w-auto" />
                    </Link>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col">
                        <li class="-mx-6">
                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                            <Link :href="route('profile.show')" :class="[route().current('profile.show') ? 'bg-gray-50 text-indigo-600' : 'hover:text-indigo-600 hover:bg-gray-50', 'flex items-center gap-x-3 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600']">
                                <img v-if="$page.props.jetstream.managesProfilePhotos" class="h-8 w-8 rounded-full bg-gray-50" :src="$page.props.auth.user.profile_photo_url" alt="" />
                                <span aria-hidden="true">{{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.second_name }}</span>
                            </Link>
                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                        </li>
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <Link :href="item.href" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                        <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li v-if="adminNavigation($page.props.auth.user.is_admin) !== false">
                            <div class="h-0.5 b-0.5 w-py bg-gray-200" aria-hidden="true" />
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in adminNavigation($page.props.auth.user.is_admin)" :key="item.name">
                                    <Link :href="item.href" :class="[item.current ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                        <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>

                        <li class="-pb-6 -mx-6 mt-auto">
                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true"/>
                            <div class="flex items-center text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600">
                                <Link
                                    class="flex items-center flex-row gap-x-2 px-20 py-5"
                                    type="button"
                                    :href="$page.props.auth.user.is_admin === true ? route('admin.help-articles.list') : route('user.help-article.list')"
                                >
                                    <component :is="BookOpenIcon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                    FAQ
                                </Link>
                            </div>
                        </li>
                        <li class="-pt-6 -mx-6">
                            <div class="h-0.5 w-py bg-gray-200" aria-hidden="true" />
                            <form @submit.prevent="logout" class="flex items-center text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50 hover:text-indigo-600">
                                <button type="submit" class="flex items-center flex-row gap-x-2 px-20 py-5">
                                    <component :is="ArrowRightEndOnRectangleIcon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="lg:pl-72">
            <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true" />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <!-- Page Heading -->
                    <header v-if="$slots.header">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            <slot name="header" />
                        </div>
                    </header>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
