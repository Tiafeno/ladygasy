<template>
  <div>
    <div class="mb-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">Ajouter une
        groupe
      </button>
    </div>
    <div class="table-responsive-md" v-if="groups">
      <table class="table table-sm table-centered table-hover " id="products-datatable">
        <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Type</th>
          <th style="width: 85px;">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="group in groups" :key="group.id_product_group">
          <td>{{ group.name }}</td>
          <td>{{ group.type }}</td>
          <td class="table-action">
            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
          </td>
        </tr>
        <tr v-if="groups.length === 0 && !loading">
          <td colspan="3">
            Aucune groupe
          </td>
        </tr>

        </tbody>
      </table>
    </div>

    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
         aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="onSubmitGroup" id="form-group">
              <div class="mb-3">
                <label for="name" class="form-label">Nom du groupe</label>
                <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <select class="form-select" id="floatingSelect" v-model="form.type"
                          aria-label="Floating label select example">
                    <option selected>Open this select menu</option>
                    <option value="select">Selection</option>
                    <option value="image">Image</option>
                    <option value="radio">Choix</option>
                    <option value="color">Couleur</option>
                  </select>
                  <label for="floatingSelect">Type du groupe</label>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check form-switch">
                  <input type="checkbox" v-model="form.is_color" class="form-check-input" id="customSwitch1">
                  <label class="form-check-label" for="customSwitch1">Utiliser en tand que couleur</label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="onSubmitGroup">Enregistrer</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, PropType, ref} from 'vue';
import {doHTTP} from "../doHTTP";
import {AxiosRequestConfig} from "axios";
import {isEmpty} from 'lodash';
import {GroupAttribute} from "../types";

declare const route: any;
export default defineComponent({
  name: "GroupTabComponent",
  props: {
    groups: Object as PropType<GroupAttribute[]>
  },
  emits: ['updateGroup'],
  setup(props, {emit}) {
    const loading = ref<boolean>(false);
    const form = ref({
      type: '',
      name: '',
      is_color: false
    })
    onMounted(async () => {
    });
    const onSubmitGroup = async () => {
      // Valider les données
      const data = form.value;
      if (isEmpty(data.name) || isEmpty(data.type)) return;
      const configRequest: AxiosRequestConfig = {
        url: route('store.product.group'),
        method: 'post',
        data: {...data}
      };
      loading.value = true;
      const response = await doHTTP(configRequest);
      if (response.status === 200) {
        form.value.name = '';
        form.value.type = '';
        form.value.is_color = false;
        emit('updateGroup');
        (<any>$('#standard-modal')).modal('hide');
      }
      loading.value = false;
    }

    return {
      form,
      loading,
      onSubmitGroup
    }
  }
})
</script>

<style scoped>

</style>
