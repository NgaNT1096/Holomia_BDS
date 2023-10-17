<template>
  <AppLayout title="Profile">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </template>
    <Modal :show="showModal">
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                       Create User
                    </h3>
                    <button @click="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 flex flex-wrap h-2/3">
                    <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-first-name">Name</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-500 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                      id="grid-first-name" type="text" placeholder v-model="form.name" />

                  </div>
                  <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Roles</label>

                        <VueMultiselect
                            v-model="form.roles"
                            :options="roles"
                            :multiple="true"
                            :close-on-select="true"
                            :allow-empty="false"
                            placeholder="Pick role"
                            label="name"
                            :max-height="160"
                            :hide-selected="true"
                            track-by="name"
                            />
                    </div>
                  <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-last-name">Email</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-last-name" type="text" placeholder="examp@example" v-model="form.email" />
                  </div>

                  <div class="w-full md:w-1/2 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-password">Password</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-password" type="password" autocomplete placeholder v-model="form.password" />
                    <p class="text-red-500 text-xs italic" v-if="errors.password">{{ errors.password }}</p>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-phone">Phone</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-phone" type="text" placeholder="phone" v-model="form.phone" />
                    <p class="text-red-500 text-xs italic" v-if="errors.phone">{{ errors.phone }}</p>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                      <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="number_sale">Number sale</label>
                      <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="number_sale" type="number" placeholder v-model="form.number_sale" />
                      <p class="text-red-500 text-xs italic" v-if="errors.number_sale">{{ errors.number_sale }}</p>
                  </div>
                  <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                      for="grid-end-date">Time limit</label>
                    <input
                      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                      id="grid-end-date" type="date" placeholder v-model="form.end_date" />
                    <p class="text-red-500 text-xs italic" v-if="errors.end_date">{{ errors.end_date }}</p>
                </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button v-show="!editMode" @click.prevent="save" data-modal-hide="defaultModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-cente">Save</button>
                    <button v-show="editMode" @click.prevent="update(form)" data-modal-hide="defaultModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-cente">Update</button>
                    <button @click="closeModal()" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" >Cancel</button>
                </div>
    </Modal>


    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class=" overflow-hidden  sm:rounded-lg">
          <button
            class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            type="button" @click="toggleModal()"
          >
            Create
          </button>
          <button
            type="button"
            class="bg-gray-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
            data-toggle="modal"
            data-target="#exampleModal"
          >
            <i class="fas fa-file-import"></i> Import
          </button>
        </div>
      </div>
      <div class="flex flex-col mt-4 sm:px-6 lg:px-8">
        <div id="table_user" class="-my-2 sm:-mx-6 lg:-mx-8">
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
                      Email
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      phone
                    </th>
                    <th
                      scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                      roles
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Edit</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="user in users" :key="user.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ user.id }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <Link

                        class="text-sm text-blue-900"
                        >{{ user.name }}</Link
                      >
                      <Link

                        class="text-sm text-blue-900"
                        ></Link
                      >
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ user.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ user.phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span v-for="role in user.roles" :key="role.id"
                      class="bg-gray-600 text-gray-100 text-xs px-2 mx-1 py-1 rounded">{{ role.name }}</span>
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >

                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                      <button
                        class="h-8 px-4 m-2 text-sm text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800"
                        @click="edit(user)"
                      >
                        update
                      </button>
                      <button
                        @click="deleteRow(user.id)"
                        class="h-8 px-5 m-2 text-red-100 transition-colors duration-150 bg-red-700 rounded-lg focus:shadow-outline hover:bg-red-800"
                      >
                        delete
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
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
      showModal: false,
      editMode: false,
      form: this.$inertia.form({
        id:null,
        name: null,
        email: null,
        phone: null,
        password: null,
        number_sale: null,
        end_date: null,
        roles: null,
      })
    };
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
      this.form.post(this.route("admin.users.store"),  {
        preserveState: true,

        onError: errors => {
          if (Object.keys(errors).length > 0) {
            this.showModal = true;
            this.editMode = false;
          }
        },
        onSuccess: page => {
          this.showModal = false;
          this.editMode = false;
          this.reset();
        }
      });
    },
    reset: function () {
      this.form = this.$inertia.form({
        id:null,
        name: null,
        email: null,
        phone: null,
        password: null,
        number_sale: null,
        end_date: null,
        roles: null,
      });
    },
    edit: function (data) {
        console.log(data.roles);
      //Trả về danh sách permission đã có
      let array = [];
      data.roles.map(function (key, value){
        array.push(key);
      });
      console.log(array);
      //trả về một biến array chưa các id roles mà user đã có
      this.form.email = data.email;
      this.form.name = data.name;
      this.form.password = data.password;
      this.form.phone = data.phone;
      this.form.number_sale= data.number_sale;
      this.form.end_date = data.end_date;
      this.form.roles = array;
      this.form.id= data.id
      this.editMode = true;
      this.toggleModal();
    },
    update: function () {
      this.form.put(this.route("admin.users.update",this.form.id),  {
        preserveState: true,
        onError: errors => {
          if (Object.keys(errors).length > 0) {
            this.showModal = true;
            this.editMode = true;
          }
        },
        onSuccess: page => {
          this.showModal = false;
          this.editMode = false;
          this.reset();
        }
      });
    },
  },
  props:{
    roles: Array,
    users: Object,
    errors: Object,
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style  scoped>
.multiselect__content-wrapper {
    max-height: 160px !important;
    height: 160px !important;
    position: relative;
}
</style>
