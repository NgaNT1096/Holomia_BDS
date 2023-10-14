<template>
  <div>
    <div class="page-header">
      <ul class="breadcrumbs pl-0 ml-md-0 border-0">
        <li class="nav-home">
          <Link :href="route('dashboard')">
            <i class="fas fa-home"></i>
          </Link>
        </li>
        <li class="separator">
          <i class="fas fa-angle-right"></i>
        </li>
        <li class="nav-item">
          <Link :href="route('dashboard')">{{ __("user_info") }}</Link>
        </li>
      </ul>
    </div>
    <div
      class="alert alert-success"
      v-if="$page.props.flash.success"
    >{{ $page.props.flash.success }}</div>
    <div
      class="alert alert-warning"
      v-if="$page.props.flash.warning"
    >{{ $page.props.flash.warning }}</div>
    <div class="row">
      <div class="col-md-4 mt-3">
        <div class="card card-profile card-secondary">
          <div class="card-header" style="background-image: url('asset/img/blogpost.jpg')">
            <div class="profile-picture">
              <div class="avatar avatar-xl">
                <img src="asset/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="user-profile text-center">
              <div class="name">{{ user.name }}</div>
              <!-- <div class="social-media">
                                    <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                        <span class="btn-label just-icon"><i class="fab fa-twitter"></i> </span>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="fab fa-google-plus-g"></i> </span>
                                    </a>
                                    <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="fab fa-facebook-f"></i> </span>
                                    </a>
                                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                        <span class="btn-label just-icon"><i class="fab fa-dribbble"></i> </span>
                                    </a>
              </div>-->
            </div>
          </div>
          <div class="card-footer">
            <div class="row user-stats text-center">
              <div class="col">
                <div class="number">{{ user.projects.length }}</div>
                <div class="title">{{ __("number_project") }}</div>
              </div>
              <div class="col">
                <div class="number">{{ user.customer_registration.length }}</div>
                <div class="title">{{ __("number_customer") }}</div>
              </div>
              <div class="col">
                <div class="number">{{ user.user_history.length }}</div>
                <div class="title">{{ __("views") }}</div>
              </div>
            </div>
          </div>
        </div>

        <div
          class="card card-profile card-secondary"
          v-if="hasAnyPermission(['users_manage', 'manager_event'])"
        >
          <form>
            <div class="card-body">
              <h4 class="page-title">{{ __("update") }} {{ __("facebook_code") }}</h4>
              <a
                class="text-sm text-blue-600"
                target="_blank"
                href="https://www.facebook.com/business/help/1524587524402327"
              >
                <i class="fas fa-question-circle"></i> How to ?
              </a>
              <div class="row mt-3">
                <div class="col-md-12">
                  <div class="form-group form-group-default">
                    <label>{{ __("facebook_code") }}</label>
                    <textarea
                      type="text"
                      class="form-control"
                      name="messenger_chat"
                      placeholder="messenger chat"
                      v-model="form.messenger_chat"
                    ></textarea>
                  </div>
                  <p v-if="errors.messenger_chat" class="text-red-500">{{ errors.messenger_chat }}</p>
                </div>
              </div>

              <div class="text-right mt-3 mb-3">
                <button class="btn btn-success" @click.prevent="addMessenger">{{ __("save") }}</button>
                <button class="btn btn-danger">{{ __("cancel") }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card card-with-nav">
          <form>
            <div class="card-body">
              <h4 class="page-title">{{ __("update") }} {{ __("user_info") }}</h4>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>{{ __("name") }}</label>
                    <input
                      type="text"
                      class="form-control"
                      name="name"
                      placeholder="Name"
                      v-model="form.name"
                    />
                  </div>
                  <p v-if="errors.name" class="text-red-500">{{ errors.name }}</p>
                </div>
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>Email</label>
                    <input
                      type="email"
                      class="form-control"
                      name="email"
                      placeholder="Name"
                      v-model="form.email"
                      readonly
                    />
                  </div>
                  <p v-if="errors.email" class="text-red-500">{{ errors.email }}</p>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>{{ __("phone") }}</label>
                    <input
                      type="text"
                      class="form-control"
                      name="phone"
                      placeholder="01234556789"
                      v-model="form.phone"
                    />
                  </div>
                  <p v-if="errors.phone" class="text-red-500">{{ errors.phone }}</p>
                </div>
              </div>

              <div class="text-right mt-3 mb-3">
                <button class="btn btn-success" @click.prevent="editProfile">Save</button>
                <button class="btn btn-danger">{{ __("cancel") }}</button>
              </div>
            </div>
          </form>
        </div>
        <div class="card card-with-nav">
          <form>
            <div class="card-body">
              <h4 class="page-title">{{ __("change_password") }}</h4>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>{{ __("current_password") }}</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model="form.current_password"
                      name="Current password"
                      placeholder="Current password"
                    />
                  </div>
                  <p
                    v-if="errors.current_password"
                    class="text-red-500"
                  >{{ errors.current_password }}</p>
                </div>

                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>{{ __("new_password") }}</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model="form.password"
                      name="New password"
                      placeholder="New password"
                    />

                    <p class="help-block"></p>
                  </div>
                  <p v-if="errors.password" class="text-red-500">{{ errors.password }}</p>
                </div>
                <div class="form-group col-md-6"></div>

                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>{{ __("new_password_confirm") }}</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model="form.password_confirmation"
                      name="new_password_confirmation"
                      placeholder="New password confirmation"
                    />

                    <p class="help-block"></p>
                  </div>
                  <p
                    v-if="errors.password_confirmation"
                    class="help-block"
                  >{{ errors.password_confirmation }}</p>
                </div>
              </div>
            </div>

            <div class="text-right mt-3 mb-3">
              <button
                type="submit"
                class="btn btn-success"
                @click.prevent="changePassword"
              >{{ __("save") }}</button>
              <button class="btn btn-danger">{{ __("cancel") }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <div class="flex flex-row">
    <div
      v-if="hasAnyPermission(['users_manage', 'manager_event'])"
      class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
    >
      <form @submit.prevent="submit">
        <h1 class="text-center">Zoom Api</h1>
        <div class="mt-4">
          <breeze-label for="password" value="API KEY" />
          <div class="password-hidden">
            <input
              id="api_key"
              :type="passwordFieldTypeApi"
              class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
              v-model="form.api_key"
              required
              autocomplete="current-password"
            />
            <span class="span-hidden">
              <i
                :class="passwordFieldTypeApi == 'password' ? 'fa fa-eye' : 'fa fa-eye-slash'"
                @click="switchVisibilityApi"
              ></i>
            </span>
          </div>
          <p class="text-red-500 text-xs italic" v-if="errors.api_key">{{ errors.api_key }}</p>
        </div>
        <div class="mt-4">
          <breeze-label for="password" value="API SECRET" />
          <div class="password-hidden">
            <input
              id="api_secret"
              :type="passwordFieldTypeSecret"
              class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
              v-model="form.api_secret"
              required
              autocomplete="current-password"
            />
            <span class="span-hidden">
              <i
                :class="passwordFieldTypeSecret == 'password' ? 'fa fa-eye' : 'fa fa-eye-slash'"
                @click="switchVisibilitySecret"
              ></i>
            </span>
            <p class="text-red-500 text-xs italic" v-if="errors.api_secret">{{ errors.api_secret }}</p>
          </div>
        </div>
        <div class="flex items-center justify-end mt-4">
          <breeze-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >Summit</breeze-button>
        </div>
      </form>
    </div>
    <div
      
      class="w-full sm:max-w-md mt-6 px-6 py-4 ml-3 bg-white shadow-md overflow-hidden sm:rounded-lg"
    >
      <form @submit.prevent="saveSettingVR">
        <h1 class="text-center">Setting VR</h1>
        
         <div class="flex flex-row ">
              <div class="mt-4 ml-4">
          <breeze-label for="password" value="Big scene" />
            <input id="big_scene"  v-model="form.big_scene"   :checked="form.big_scene == 1 ? true : false" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        
        </div>
        <div class="mt-4 ml-4">
          <breeze-label for="password" value="3D Model" />
            <input id="model_3d"  v-model="form.model_3d"          :checked="form.model_3d == 1 ? true : false" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        
        </div>
           <div class="mt-4 ml-4">
          <breeze-label for="password" value="VR portal" />
            <input id="vr_portal"  v-model="form.vr_portal"  :checked="form.vr_portal == 1 ? true : false"   type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        </div>
         </div>
      

        <div class="flex items-center justify-end mt-4">
          <breeze-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >Summit</breeze-button>
        </div>
      </form>
    </div>
</div>
  
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import Layout from "@/Components/Layout.vue";
import BreezeButton from "@/Components/Button";
import LicenseLayoutVue from "@/Components/LicenseLayout/LicenseLayout";
import LicenseHeader from "@/Components/Header/LicenseHeader";
import Notification from "@/Components/Notification";
import BreezeInput from "@/Components/Input";
import BreezeLabel from "@/Components/Label";
export default {
  layout: Layout,
  components: {
    Link,
    BreezeInput,
    BreezeLabel,
    BreezeButton
  },
  props: {
    user: Object,
    errors: Object,
    setting_zoom: Object
  },
  data() {
    return {
      passwordFieldTypeApi: "password",
      passwordFieldTypeSecret: "password",
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
        phone: this.user.phone,
        messenger_chat: this.user.messenger_chat,
        current_password: null,
        password: null,
        password_confirmation: null,
        api_key: this.setting_zoom !== null ? this.setting_zoom.api_key : null,
        api_secret: this.setting_zoom !== null ? this.setting_zoom.api_secret : null,
        big_scene : this.user.setting_vr !== null ? this.user.setting_vr.big_scene : null,
        model_3d : this.user.setting_vr !==null ? this.user.setting_vr.model_3d:null,
        vr_portal :this.user.setting_vr !==null ? this.user.setting_vr.vr_portal:null,


        
      }),
    };
  },
  methods: {
    editProfile() {
      this.$inertia.post(this.route("admin.profile.update"), this.form);
    },
    changePassword() {
      this.$inertia.put(this.route("admin.changePassword"), this.form);
    },
    addMessenger() {
      this.$inertia.put(this.route("user.addMessenger"), this.form);
    },
    submit() {
      this.form.post(this.route("user.storeSettingZoom", this.user.id), { preserveState: false });
    },
    switchVisibilityApi() {
      this.passwordFieldTypeApi =
        this.passwordFieldTypeApi === "password" ? "text" : "password";
    },
    switchVisibilitySecret() {
      this.passwordFieldTypeSecret =
        this.passwordFieldTypeSecret === "password" ? "text" : "password";
    },
    saveSettingVR(){
         this.form.put(this.route("user.updateSettingVR", this.user.id), { preserveScroll: true });
    }
  },
};
</script>

<style scoped>
.show-password {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 22px;
  cursor: pointer;
}

.form-floating-label {
  position: relative;
}
.password-hidden {
  position: relative;
}
.span-hidden {
  top: 30%;
  position: absolute;
  right: 20px;
  transition: auto;
}
</style>