<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="onSubmit">
          <div class="mb-3">
            <label for="name" class="form-label">Nom du categorie</label>
            <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
          </div>
          <div class="mb-3">
            <label for="parent" class="form-label">Parent</label>
            <select class="form-select" v-model="form.parent">
              <option v-for="ctg in categories" :value="ctg.id_category">{{ctg.name}}</option>
            </select>
          </div>
          <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea  class="form-control" v-model="form.description" >
            </textarea>
          </div>
          <div class="row mb-0">
            <div class="col-md-12 text-end">
              <button type="submit" class="btn btn-warning text-white">
                Ajouter
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <div class="table-responsive-md" v-if="categories">
          <table class="table table-sm table-centered table-hover " id="products-datatable">
            <thead class="table-light">
            <tr>
              <th>Name</th>
              <th>Description</th>
              <th style="width: 85px;">Action</th>
            </tr>
            </thead>
            <tbody>
              <tr v-for="category in categories" :key="category.id_category">
                <td>{{category.name}}</td>
                <td>{{category.description}}</td>
                <td class="table-action">
                  <a href="javascript:void(0);" class="action-icon" @click="onDestroy(category.id_category)"> <i class="mdi mdi-trash-can"></i></a>
                  <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                </td>
              </tr>
            <tr v-if="categories.length == 0 && !loading">
              <td colspan="3">
                Aucune catégorie
              </td>
            </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import {doHTTP} from "../doHTTP";
import {AxiosRequestConfig} from "axios";
import * as Notiflix from 'notiflix';
import { isEmpty } from 'lodash';
declare const route: any;
declare interface FormCategory {
  name: string;
  parent: string;
  description: string;
}
declare interface Category {
  id_category: number
  name: string,
  description: string,
  id_parent: number
}
export default defineComponent({
  setup() {
    const categories = ref<Category[]>([]);
    const form = ref<FormCategory>({
      name: '',
      parent: '',
      description: ''
    });
    const onSubmit = async () => {
      if (isEmpty(form.value.name)) {
        return false;
      }
      const request: AxiosRequestConfig = {
        method: 'POST',
        url: route('store.admin.categories'),
        data: {...form.value}
      };
      const responsePost = await doHTTP(request);
      if (responsePost.status == 200) {
        Object.keys(form.value).forEach((v) => {
          form.value[v] = '';
        });
        await load();
        alert('Catégorie ajouter avec succès');
      } else {
        alert("Une erreur s'est produit");
      }
    };
    const loading = ref<boolean>(false);
    const onDestroy = async (id: number) => {
      if (id) {
        Notiflix.Confirm.show('Confirmation', "Voulez-vous vraiment supprimer ?", 'Oui', 'Non', async () => {
          const arg: AxiosRequestConfig = {
            url: route('destroy.admin.categories', {id: id}),
            method: 'DELETE',
            data: {}
          }
          try {
            const responseDestroy = await doHTTP(arg);
            await load();
          } catch (e) {
          }
        })
      }
    };
    const load = async() => {
      loading.value = true;
      const config: AxiosRequestConfig = {
        url: route('retrieve.admin.categories'),
        method: 'options',
        data: {}
      }
      const response = await doHTTP(config);
      categories.value = response.data;
      loading.value = false;
    };
    onMounted(async () => {
      await load();
    });
    return {
      onSubmit,
      form,
      categories,
      onDestroy,
      loading
    }
  },
  name: "CategoryComponent"
})


</script>

<style scoped>

</style>
