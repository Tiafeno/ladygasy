<template>
  <div>
    <ul class="nav nav-tabs nav-bordered mb-3">
      <li class="nav-item">
        <a href="#group-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
          <i class="mdi mdi-home-variant d-md-none d-block"></i>
          <span class="d-none d-md-block">Groupe</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#profile-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
          <i class="mdi mdi-account-circle d-md-none d-block"></i>
          <span class="d-none d-md-block">Attributes</span>
        </a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane show active" id="group-b1">
        <div>
          <group-tab-component v-bind:groups="groups" @updateGroup="onUpdateGroup"></group-tab-component>
        </div>
      </div>
      <div class="tab-pane" id="profile-b1">
        <div><attribute-tab-component v-bind:groups="groups"></attribute-tab-component></div>
      </div>
    </div>


  </div>
</template>

<script>
import GroupTabComponent from "./GroupTabComponent";
import AttributeTabComponent from "./AttributeTabComponent";
import {defineComponent, onMounted, ref} from "vue";
import {doHTTP} from "../doHTTP";
export default defineComponent({
  name: "AttributeComponent",
  components: {AttributeTabComponent, GroupTabComponent},
  setup() {
    const groups = ref([]);
    const initialize = async () => {
      const arg = {
        url: route('index.product.group'),
        method: 'GET',
      };
      const resp = await doHTTP(arg);
      if (resp.status === 200) {
        groups.value = resp.data;
      }
    };
    onMounted(async () => {
      await initialize();
    });
    const onUpdateGroup = async () => {
      await initialize();
    };
    return {
      groups,
      onUpdateGroup
    }
  }
})
</script>

<style scoped>

</style>
