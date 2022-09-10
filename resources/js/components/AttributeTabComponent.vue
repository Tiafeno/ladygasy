<template>
  <div>
    <div class="mb-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-attribute-modal">Ajouter une attribute</button>
    </div>
    <div class="table-responsive-md" v-if="attributes">
      <table class="table table-sm table-centered table-hover " id="products-datatable">
        <thead class="table-light">
        <tr>
          <th>Name</th>
          <th>Groupe</th>
          <th style="width: 85px;">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="attribute in attributes" :key="attribute.id_attribute">
          <td>{{attribute.name}}</td>
          <td>{{attribute.id_group}}</td>
          <td class="table-action">
            <a href="javascript:void(0);" class="action-icon" @click="onDestroy(attribute.id_attribute)"> <i class="mdi mdi-trash-can"></i></a>
            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
          </td>
        </tr>
        <tr v-if="attributes.length === 0 && !loading">
          <td colspan="3">
            Aucune attribute
          </td>
        </tr>

        </tbody>
      </table>
    </div>

    <div id="create-attribute-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="onSubmitAttribute" id="form-group">
              <div class="mb-3">
                <label for="name" class="form-label">Nom de l'attribut</label>
                <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
              </div>
              <div class="mb-3">
                <div class="form-floating">
                  <select class="form-select" id="floatingSelect" v-model="form.id_group" aria-label="Floating label select example">
                    <option value="0">Open this select menu</option>
                    <option :value="group.id_product_group" v-for="group in groups">{{group.name}}</option>
                  </select>
                  <label for="floatingSelect">Groupe d'attribut</label>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary" @click="onSubmitAttribute">Enregistrer</button>
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
import * as Notiflix from 'notiflix';
import {isEmpty, isNumber} from 'lodash';
import {GroupAttribute} from "../types";
declare const route: any;
export default defineComponent({
  name: "AttributeTabComponent",
  props: {
    groups : Object as PropType<GroupAttribute[]>
  },
  setup(props) {
    const attributes = ref<any[]>([]);
    const loading = ref<boolean>(false);
    const form = ref({
      name: '',
      id_group: 0
    })
    onMounted(async () => {
      await load();
    });
    const onDestroy = async (id) => {
      if (id) {
        Notiflix.Confirm.show('Confirmation', "Voulez-vous vraiment supprimer ?", 'Oui', 'Non', async () => {
          const arg: AxiosRequestConfig = {
            url: route('destroy.attribute', {id: id}),
            method: 'DELETE',
            data: {}
          }
          try {
            loading.value = true;
            const responseDestroy = await doHTTP(arg);
            await load();
          } catch (e) {
          }
        })
      }
    }
    const onSubmitAttribute = async () => {
      // Valider les données
      const data = form.value;
      if (isEmpty(data.name) || !isNumber(data.id_group)) return;
      const configRequest: AxiosRequestConfig = {
        url: route('store.attribute'),
        method: 'post',
        data: { ...data }
      };
      loading.value = true;
      const response = await doHTTP(configRequest);
      if (response.status === 200) {
        form.value.name = '';
        form.value.id_group = 0;
        await load();
        (<any>$('#create-attribute-modal')).modal('hide');
      }
      loading.value = false;
    }
    const load = async () => {
      const arg: AxiosRequestConfig = {
        url: route('options.product.attribute'),
        method: 'options',
        data: {}
      };
      loading.value = true;
      const resp = await doHTTP(arg);
      if (resp.status === 200) {
        attributes.value = resp.data;
      }
      loading.value = false;
    }

    return {
      form,
      attributes,
      loading,
      onDestroy,
      onSubmitAttribute
    }
  }
})
</script>

<style scoped>

</style>
