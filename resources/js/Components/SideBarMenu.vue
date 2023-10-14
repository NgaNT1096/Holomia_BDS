<template>
    <sidebar-menu :menu="menu" />
</template>
<script>
import { SidebarMenu } from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
export default {
  components: {
    SidebarMenu,
    FontAwesomeIcon
  },
  data(){
    return {
        menu: [
          {
            header: 'Holomia App',
            hiddenOnCollapse: true
          },
          {
            href: '/',
            title: 'Dashboard',
            icon: 'fa fa-user'
          },
          {
            title: 'User Manager',
            icon: 'fa fa-chart-area',
            child: [
              {
                href: '/charts/sublink',
                title: 'Users'
              },
              {
                href: '/charts/sublink',
                title: 'Role'
              },
              {
                href: '/charts/sublink',
                title: 'Permission'
              }
            ]
          }
        ]
      }
  },

}
</script>
