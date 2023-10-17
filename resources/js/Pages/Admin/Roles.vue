<template>
  <div>
    <div class="alert alert-success"></div>
    <Modal :show="showModal">
        <form class="space-y-4 text-gray-700">
      <div
        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600"
      >
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
          Create role
        </h3>
        <button
          @click="closeModal()"
          type="button"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
          data-modal-hide="defaultModal"
        >
          <svg
            class="w-3 h-3"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
      </div>
      <!-- Modal body -->
      <div class="p-6 flex  h-2/3">
        <div class="w-full flex flex-col  md:w-1/2 px-3">
          <label
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
            for="grid-first-name"
            >Name</label
          >
          <input
            class="appearance-none block w-full bg-gray-200 text-gray-500 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
            id="grid-first-name"
            type="text"
            placeholder
            v-model="form.name"
          />
          <div class="text-red-500" v-if="errors.name">
          {{ errors.name }}
        </div>
        </div>
        
        <div class="w-full md:w-1/2 px-3">
          <label
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
            >Permission</label
          >

          <VueMultiselect
            v-model="form.permission"
            :options="permissions"
            :multiple="true"
            :close-on-select="true"
            :allow-empty="false"
            placeholder="Pick role"
            label="name"
            :max-height="100"
            :hide-selected="true"
            track-by="name"
          />
        </div>
      </div>
      <!-- Modal footer -->
      <div
        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600"
      >
        <button
          @click.prevent="save"
          data-modal-hide="defaultModal"
          type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-cente"
        >
          Save
        </button>
        <button
          @click="closeModal()"
          data-modal-hide="defaultModal"
          type="button"
          class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
        >
          Cancel
        </button>
      </div>
    </form>
    </Modal>
    <div class="py-12">
      <div class="flex-col mt-4 sm:px-6 lg:px-8">
        <button
          class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
          type="button"
          v-on:click="toggleModal()"
        >
          create
        </button>
      </div>
      <div class="flex-col mt-4 sm:px-6 lg:px-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div
            class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
          >
            <div
              class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
            >
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      id
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      name
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      permission
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="role in roles.data" :key="role.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ role.id }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ role.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        v-for="permission in role.permissions"
                        :key="permission.id"
                        class="bg-gray-600 text-gray-100 text-xs px-2 mx-1 py-1 rounded"
                        >{{ permission.name }}</span
                      >
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800"
                        @click="edit(role)"
                      >
                        update
                      </button>
                      <button
                        @click="deleteRow(role.id)"
                        class="h-10 px-5 m-2 text-red-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800"
                      >
                        delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <pagination class="mt-6" :links="roles.links" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/Authenticated.vue";
import Modal from "@/Components/Modal.vue";
import VueMultiselect from "vue-multiselect";
export default {
  layout: AppLayout,
  components: {
    Link,
    Modal,
    VueMultiselect,
  },
  data() {
    return {
      editMode: false,
      showModal: false,
      form: {
        name: null,
        permission: null,
      },
    };
  },
  props: {
    permissions: Array,
    roles: Object,
    errors: Object,
    message: String,
  },
  methods: {
    toggleModal: function () {
      this.showModal = !this.showModal;
    },
    closeModal: function () {
      this.showModal = false;
      this.reset();
      this.editMode = false;
    },
    save() {
      this.$inertia.post(this.route("admin.roles.store"), this.form);
      this.toggleModal();
      this.editMode = false;
      this.reset();
    },
    reset: function () {
      this.form = {
        name: null,
      };
    },
    edit: function (data) {
        console.log(data);
      //Trả về danh sách permission đã có
      let object = Object.assign({}, data.permissions);
      console.log(typeof object);
      // // // let first = Object.assign({}, object[0]);
      let array = [];
      $.each(object, function (key, value) {
        array.push(parseInt(value.id));
      });
      //trả về một biến array chưa id của permission
      this.form = Object.assign({}, data);
      this.form.permission = array;
      this.editMode = true;
      this.toggleModal();
    },
    update: function (data) {
      this.$inertia.put(this.route("admin.roles.update", data.id), data);
      this.reset();
      this.closeModal();
    },
    deleteRow: function (id) {
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete(this.route("admin.roles.delete", id), null);
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
