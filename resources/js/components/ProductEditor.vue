<template>
  <div>
    <form @submit.prevent="submitProduct">
      <div class="row">
        <div class="mb-3 col-md-6">
          <input class="form-control" v-model="title" placeholder="Saisissez le nom de votre produit"/>
        </div>
        <div class="col-md-12">
          <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
              <a href="#es-b1" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                <span class="d-none d-md-block">Essentiel</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="#des-b1" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                <span class="d-none d-md-block">Declinaisons</span>
              </a>
            </li>
          </ul>

          <div class="tab-content">
            <div class="tab-pane show active" id="es-b1">
              <div class="row">
                <div class="col-md-8">
                  <div class="mb-3">
                    <div class="text-title mb-2">Récapitulatif</div>
                    <QuillEditor v-model:content="recap" contentType="html" theme="snow"></QuillEditor>
                  </div>
                  <div class="mb-3">
                    <div class="text-title mb-2">Description</div>
                    <QuillEditor v-model:content="description" contentType="html" theme="snow"></QuillEditor>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <h5 class="mb-2">Combinations</h5>
                    <div class="form-check">
                      <input type="radio" id="customRadio1" v-model="type" value="simple" class="form-check-input">
                      <label class="form-check-label" for="customRadio1">Produit simple</label>
                    </div>
                    <div class="form-check">
                      <input type="radio" id="customRadio2" v-model="type" value="combination" class="form-check-input">
                      <label class="form-check-label" for="customRadio2">Produit avec combinaisons</label>
                    </div>
                  </div>
                  <div class="mb-3">
                    <h5 class="mb-2">Reference</h5>
                    <div>
                      <input type="text" v-model="reference" class="form-control">
                    </div>
                  </div>
                  <div class="mb-3">
                    <h5 class="mb-2">Prix</h5>
                    <div>
                      <input type="number" v-model="price" class="form-control">
                    </div>
                  </div>
                  <div class="mb-3">
                    <h5 class="mb-2">Categories</h5>
                    <div>
                      <v-select taggable multiple :options="categories" label="name" :reduce="ctg => ctg.id_category"
                                v-model="category"></v-select>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="tab-pane" id="des-b1">
              <div>
                <h6 class="font-13 mt-3">Auto-sizing</h6>
                <div class="row">
                  <div class="col-md-8">

                  </div>
                  <div class="col-md-4">
                    <attribute-combination-group v-for="g in attributeGroups" :group="g"
                                                 @update-attr="pushCombination"></attribute-combination-group>
                    <button class="btn btn-success" @click="submitCombination" type="button">Generer</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="position-absolute">
        <div class="form-check form-switch">
          <input type="checkbox" v-model="active" :checked="active" class="form-check-input" id="customSwitch1">
          <label class="form-check-label" for="customSwitch1">Active</label>
        </div>
        <button class="btn btn-success" type="submit">Enregistrer</button>
      </div>
    </form>


  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import {QuillEditor} from "@vueup/vue-quill";
import {useRouter} from 'vue-router';
import * as vSelect from 'vue-select';
import {AxiosRequestConfig} from "axios";
import {doHTTP} from "../doHTTP";
import {Attribute, GroupAttribute} from "../types";
import {cloneDeep, isEmpty, map} from "lodash";


declare const route: any;

declare interface Combination {
  id: number,
  name: string,
  reference: string,
  ean13: string,
  quantity: number,
  price: number,
  default_on: boolean
}


export default defineComponent({
  name: "ProductEditor",
  components: {QuillEditor, 'v-select': vSelect},
  setup() {
    const router = useRouter();
    const editor = ref('new'); // new for empty form or edit for edit product
    const isSaved = ref<boolean>(false);
    const dirtySaved = ref<boolean>(false);
    const ID = ref<number>(0);
    const title = ref('');
    const recap = ref('');
    const description = ref('');
    const type = ref('simple');
    const reference = ref('');
    const active = ref<boolean>(false);
    const price = ref(0);
    const quantity = ref(1);
    const categories = ref([]); // Tous les categories disponible
    const category = ref([]); // Categorie du produit
    const combinations = ref<Array<Combination>>([]); // Contient la liste de tous les combinations du produit
    const combinationValues = ref<Attribute[]>([]);
    const attributeGroups = ref<Array<GroupAttribute>>([]); // Tous les groups d'attibutes disponible
    onMounted(async () => {
      const catArg: AxiosRequestConfig = {
        url: route('retrieve.admin.categories'),
        method: 'options',
        data: []
      };
      const cats = doHTTP(catArg);
      const groupArg: AxiosRequestConfig = {
        url: route('index.product.group'),
        method: 'get'
      };
      const groups = doHTTP(groupArg);
      const allPromise = await Promise.all([cats, groups]);
      // categories
      if (allPromise[0].status == 200) {
        categories.value = allPromise[0].data;
      }
      // Groups
      if (allPromise[1].status == 200) {
        attributeGroups.value = allPromise[1].data;
      }
      await fetchCombination();
    });

    const fetchCombination = async () => {
      if (ID.value && type.value === "combination") {
        // Fetch all combination
        const config: AxiosRequestConfig = {
          url: route('product.combination', {id_product: ID.value}),
          method: 'get'
        };
        try {
          const response = await doHTTP(config);
          const data = response.data;
          if (response.status === 200) {
            combinations.value = cloneDeep(data);
          }
        } catch (e) {}
      }
    };

    const pushCombination = (attr: Attribute, type: string) => {
      if (type === "ADD") {
        combinationValues.value.push(attr);
      } else {
        combinationValues.value = combinationValues.value.filter((v) => {
          return v.id_attribute !== attr.id_attribute;
        });
      }
    };

    const submitProduct = async () => {
      if (isEmpty(title.value)) {
        dirtySaved.value = true;
        return;
      }
      const arg: AxiosRequestConfig = {
        url: route('store.admin.product'),
        method: 'post',
        data: {
          name: title.value,
          quantity: quantity.value,
          reference: reference.value,
          price: price.value,
          type: type.value,
          categories: category.value,
          description: description.value,
          description_short: recap.value,
          active: active.value
        }
      };
      try {
        const response = await doHTTP(arg);
        if (response.status === 200) {
          isSaved.value = true;
          ID.value = cloneDeep(response.data.id);
        }
      } catch (e) {
      }
    }

    // Crée une combinaison de produit
    const submitCombination = async () => {
      dirtySaved.value = true;
      if (isEmpty(title.value) || isEmpty(combinationValues.value)) {
        return;
      }
      if (!isSaved.value) {
        await submitProduct();
      }
      if (ID.value) {
        const attrIds: Array<number> = map(combinationValues.value, (attr) => attr.id_attribute);
        const arg: AxiosRequestConfig = {
          url: route('post.product.combination', {id_product: ID.value}),
          method: 'post',
          data: {
            reference: '',
            ean13: '',
            quantity: 0,
            price: 0,
            attributes: attrIds
          }
        };
        try {
          const response = await doHTTP(arg);
          if (response.status === 200) {
            await fetchCombination();
          }
        } catch (e) {
          console.log(e);
        }
      }
    };
    return {
      recap,
      title,
      type,
      pushCombination,
      combinationValues,
      quantity,
      description,
      reference,
      price,
      categories,
      active,
      category,
      combinations,
      dirtySaved,
      attributeGroups,
      submitCombination,
      submitProduct
    }
  }
})
</script>

<style scoped>

</style>
