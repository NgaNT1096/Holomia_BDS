<template>
  <div class="">
    <div class="tab__header">
      <ul
        class="tab__link flex items-center w-full cursor-pointer p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
        @click.prevent="active = !active"
      >
        <font-awesome-icon
          class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75"
          :icon="icon_data"
        />
        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{
          title
        }}</span>
        <span class="down-Arrow" v-show="!active"
          ><font-awesome-icon :icon="['fas', 'chevron-down']"
        /></span>
        <span class="up-Arrow" v-show="active"
          ><font-awesome-icon :icon="['fas', 'chevron-up']" />
        </span>
      </ul>
    </div>
    <div class="tab__content p-2" v-show="active"><slot /></div>
  </div>
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
  components: {
    Link,
  },
  props: ["title", "icon_data","state"],
  data() {
    console.log(this.state);
    return {
      active: this.state,
    };
  },
};
</script>
