<template>
  <AppLayout title="Profile">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </template>
  <div>
    <!-- Modall -->
    <div class="py-12">
        <div class="alert alert-success" ></div>
        <div class="mx-auto sm:px-6 lg:px-8">
        <button
            class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            type="button"
            v-on:click="toggleModal()">create</button>
        <form class="space-y-4 text-gray-700">
            <div
            v-if="showModal"
            class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
            >
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
                >
                <!--header-->
                <div
                    class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t"
                >
                    <h3  v-show="!editMode" class="text-3xl font-semibold">create permission</h3>
                    <h3  v-show="editMode" class="text-3xl font-semibold">update permission</h3>
                    <button
                    class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                    v-on:click="toggleModal()"
                    >
                    <span
                        class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none"
                    >×</span>
                    </button>
                </div>
                <!--body-->
                <div class="relative p-6 flex-auto">
                    <span
                    class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200 uppercase last:mr-0 mr-1"
                    >Name</span>
                    <input
                    class="w-full h-10 px-3 mb-2 text-base text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline"
                    type="text"
                    v-model="form.name"
                    placeholder="Regular input"
                    />
                    <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
                </div>
                <!--footer-->
                <div
                    class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b"
                >
                    <button
                    class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button"
                    @click="closeModal()"
                    >cancel</button>
                    <button
                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="submit"
                    v-show="!editMode"
                    @click="save(form)"
                    >save</button>
                    <button
                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="submit"
                    v-show="editMode"
                    @click="update(form)"
                    >update</button>
                </div>
                </div>
            </div>
            </div>
            <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
        </form>
        </div>
        <!-- List -->
        <div class="flex-col mt-4 sm:px-6 lg:px-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >id</th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >name</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="permission in permissions.data" :key="permission.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ permission.id }}</div>
                        </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ permission.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button
                        class="h-8 px-4 ml-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800"
                        @click="edit(permission)"
                        >update</button>
                        <button
                        @click="deleteRow(permission.id)"
                        class="h-8 px-4 ml-2  text-red-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800"
                        >delete</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
  </div>
  </AppLayout>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/Authenticated.vue";
import Modal from "@/Components/Modal.vue";
import VueMultiselect from 'vue-multiselect'
export default {
  layout: AppLayout,
  components: {
    Link,
    Modal,
    VueMultiselect
  },
  data() {
    return {
      editMode: false,
      showModal: false,
      form: {
        name: null
      }
    };
  },
  props: {
    permissions: Object,
    total: Number,
    errors: Object,
    message: String
  },
  methods: {
    toggleModal: function() {
      this.showModal = !this.showModal;
    },
    closeModal: function() {
      this.showModal = false;
      this.reset();
      this.editMode = false;
    },
    save() {
      // console.log(this.form.name);
      this.$inertia.post(this.route("admin.permissions.store"), this.form);
      this.toggleModal();
      this.editMode = false;
      this.reset();
    },
    reset: function() {
      this.form = {
        name: null
      };
    },
    edit: function(data) {
      // console.log(data.id);
      this.form = Object.assign({}, data);
      this.editMode = true;
      this.toggleModal();
    },
    update: function(data) {
      // data._method = "PUT";

      this.$inertia.put(this.route("admin.permissions.update", data.id), data);
      this.reset();
      this.closeModal();
    },
    deleteRow: function(id) {
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete(this.route("admin.permissions.delete", id), null);
    }
  }
};
</script>

<style>
</style>
