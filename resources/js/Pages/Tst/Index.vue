<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, useForm} from "@inertiajs/vue3";
import {computed, onMounted, reactive, ref} from "vue";
import InputError from "@/Components/InputError.vue";
import DragDrop from "@/Components/DragDrop.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    sessions: Object,
    files: Object,
});

const formFile = ref(null);
const slcted1 = ref(null);
const slcted2 = ref(null);

const form = useForm({
    name: '',
    file: File,
});

const submitForm = () => {
    console.log('Go!');
    form.file = formFile.value;

    form.post(route('tst-store'), {
        errorBag: 'submitForm',
        preserveScroll: true,
        onSuccess: (params) => {
            //location.reload();
            console.log('onSuccess');
            console.log(params);
        },
        onError: (params) => {
            //location.reload();
            console.log('onError');
            console.log(params);
        },
    });
};

const submitTest2 = () => {
    location.href = '/tst-2?f1=' + slcted1.value + '&f2=' + slcted2.value;
}
</script>
<style global>
</style>
<template>
    <AppLayout title="Analytics">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tst
            </h2>
        </template>
        <div class="flex md:flex md:flex-row flex-row">
            <div class="mr-10 w-[80%] flex flex-col">
                <div>
                    Upload data:
                    <div class="col-span-8 sm:col-span-6">
                        <InputLabel for="name" value="name" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Name"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    File:
                    <div class="col-span-8 sm:col-span-6">
                        <DragDrop v-model:file="formFile" />
                        <InputError :message="form.errors.file" class="mt-2" />
                    </div>
                    <button @click="submitForm" class="mt-4 px-4 py-2 rounded mr-4 bg-blue-500 text-white">Upload</button>
                </div>
                <div class="mt-4">
                    <a :href="route('tst-1')" class="mt-4 px-4 py-2 rounded mr-4 bg-green-400 text-white">Test1</a>
                </div>
                <div class="mt-4">
                    <div class="col-span-8 sm:col-span-6">
                        Is in <select
                            v-model="slcted1"
                            class="border border-gray-300 text-sm rounded-lg block w-full p-2.5 noborder"
                        >
                            <option v-for="(item, index) in props.files" :value="item.file" :key="index">{{ item.file }}</option>
                        </select>
                        Not in
                        <select
                            v-model="slcted2"
                            class="border border-gray-300 text-sm rounded-lg block w-full p-2.5 noborder"
                        >
                            <option v-for="(item, index) in props.files" :value="item.file" :key="index">{{ item.file }}</option>
                        </select>
                        <button @click="submitTest2" class="mt-4 px-4 py-2 rounded mr-4 bg-green-400 text-white">Test2</button>
                    </div>

                </div>
            </div>

        </div>
    </AppLayout>
</template>
