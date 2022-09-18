<template>
  <div>
    <div class="row mb-2">
      <div class="col-sm-5">
        <router-link :to="{name: 'new-product'}" class="btn btn-danger mb-2">
          <i class="mdi mdi-plus-circle me-2"></i>Ajouter une article
        </router-link>
      </div>
      <div class="col-sm-7">
        <div class="text-sm-end">
          <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog-outline"></i></button>
        </div>
      </div><!-- end col-->
    </div>

    <div class="table-responsive-md">
      <table class="table table-centered table-hover " id="products-datatable">
        <thead class="table-light">
        <tr>
          <th >ID</th>
          <th class="all">Image</th>
          <th>Nom</th>
          <th>Catégorie</th>
          <th>Montant</th>
          <th>Quantité</th>
          <th>Etat</th>
          <th style="width: 85px;">Actions</th>
        </tr>
        </thead>
        <tbody>
          <tr v-for="product in products">
            <td>{{product.id_product}}</td>
            <td></td>
            <td>{{product.name}}</td>
            <td></td>
            <td>{{product.price}}</td>
            <td>{{product.quantity}}</td>
            <td><span class="badge bg-success">{{product.active}}</span></td>
            <td class="table-action">
              <router-link :to="{name: 'edit-product', params: {id: product.id_product}}"  class="action-icon">
                <i class="mdi mdi-square-edit-outline"></i>
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import {Product} from "../types";
import {doHTTP} from "../doHTTP";
import {AxiosRequestConfig} from "axios";
declare const route: any;

export default defineComponent({
  name: "ProductList",
  setup() {
    const loading = ref<boolean>(false);
    const products = ref<Array<Product>>([]);
    const initialize = async() => {
      loading.value = true;
      const config: AxiosRequestConfig = {
        url: route('admin.products'),
        method: 'options',
      }
      try {
        const response = await doHTTP(config);
        if (response.status === 200) {
          products.value = response.data;
        }
      } catch (e) {
        loading.value = false;
      }

    };
    onMounted(() => {
      initialize();
    });

    return {
      products
    }
  }
})
</script>

<style scoped>

</style>
