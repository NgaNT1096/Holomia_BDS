<template>
  <aside class="fixed w-48 h-full" aria-label="Sidebar">
    <div
      class="px-3 py-4 h-full overflow-y-auto rounded bg-gray-50 dark:bg-gray-800"
    >
      <div class="flex items-center mb-4">
        <img class="w-10" src="/assets/images/logo/logo.png" alt="">
        <span class="ml-3">Holomia</span>
      </div>
      <ul class="space-y-2">
        <li v-if="can('dashboard')">
          <Link
            href="/"
            class="flex items-center cursor-pointer p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <svg
              class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
              <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="ml-3">Dashboard</span>
          </Link >
        </li>
        <AccordionVue title="User Manager" icon_data="fa-solid fa-user" :state="route().current() == 'users.index' || 'admin.roles.index' ||  'admin.permission.index' ? 'true' : 'false' ">
          <li>
              <Link
              :href="route('admin.permissions.index')"
              replace
              class="flex items-center w-full cursor-pointer p-2 text-base font-normal  transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
              :class="route().current() == 'admin.permissions.index' ? ' active-route' : '' "
                >Permissions</Link>
            </li>
            <li>
              <Link
              :href="route('admin.roles.index')"
              class="flex items-center w-full cursor-pointer p-2 text-base font-normal  transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
              :class="route().current() == 'admin.roles.index' ? ' active-route' : '' "
                >Roles</Link>
            </li>
            <li >
              <Link
              :href="route('admin.users.index')"
              replace
              class="flex items-center w-full cursor-pointer p-2 text-base font-normal  transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
              :class="route().current() == 'users.index' ? ' active-route' : '' "
                >Users</Link>
            </li>
        </AccordionVue>
        <AccordionVue title="Products" icon_data="fa-solid fa-list" :state="route().current() == 'product' ? 'true' : 'false' ">
          <li>
              <Link
              :href="route('admin.users.index')"
                class="flex items-center cursor-pointer w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
                >Category</Link
              >
            </li>
            <li>
              <Link
              :href="route('admin.users.index')"
                class="flex items-center cursor-pointer w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
                >Products</Link
              >
            </li>
            <li>
              <Link
              :href="route('admin.users.index')"
                class="flex items-center cursor-pointer w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-8"
                >Sale Event</Link
              >
            </li>
        </AccordionVue>
        <li>
          <Link
          :href="route('admin.users.index')"
            class="flex items-center cursor-pointer p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <font-awesome-icon :icon="['fas', 'message']"
            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75" />
            <span class="flex-1 ml-3 whitespace-nowrap">Inbox</span>
            <span
              class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200"
              >3</span
            >
          </Link>
        </li>
        <li>
          <Link
            href="#"
            class="flex items-center cursor-pointer p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <svg
              class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">Sign In</span>
          </Link>
        </li>
        <li>
          <Link
            href="#"
            class="flex items-center cursor-pointer p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <svg
              class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                clip-rule="evenodd"
              ></path>
            </svg>
            <span class="flex-1 ml-3 whitespace-nowrap">Sign Up</span>
          </Link>
        </li>

      </ul>
    </div>
  </aside>
</template>
<script>
import {
  Collapse,
  Ripple,
  initTE,
} from "tw-elements";
import { Link } from '@inertiajs/vue3'
import AccordionVue from './Accordion.vue';

initTE({ Collapse, Ripple });
export default {
  components: {
    Collapse,
    Ripple,
    initTE,
    AccordionVue,
    Link
  },
  data(){
    return {
        visible: false,
    }
  },
}
</script>
<style scope>
.active-route{
  color: white;
  background: rgb(45, 128, 223);
}
.active-route:hover{
  color: white;
  background: rgba(45, 128, 223, 0.856);
}
.route-default{

}
</style>
