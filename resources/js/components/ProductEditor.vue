<template>
  <div>
    <form>
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
                    <h5 class="mb-2">Prix</h5>
                    <div>
                      <input type="number" v-model="price" class="form-control">
                    </div>
                  </div>
                  <div class="mb-3">
                    <h5 class="mb-2">Categories</h5>
                    <div>
                      <v-select  taggable multiple :options="categories" label="name" :reduce="ctg => ctg.id_category"
                                v-model="category"></v-select>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="tab-pane" id="des-b1">
              <div>
                <h6 class="font-13 mt-3">Auto-sizing</h6>
                <form>
                  <div class="row gy-2 gx-2 align-items-center">
                    <div class="col-auto">
                      <label class="visually-hidden" for="inlineFormInput">Name</label>
                      <input type="text" class="form-control mb-2" id="inlineFormInput" placeholder="Jane Doe">
                    </div>
                    <div class="col-auto">
                      <label class="visually-hidden" for="inlineFormInputGroup">Username</label>
                      <div class="input-group mb-2">
                        <div class="input-group-text">@</div>
                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
                      </div>
                    </div>
                    <div class="col-auto">
                      <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="autoSizingCheck">
                        <label class="form-check-label" for="autoSizingCheck">Remember me</label>
                      </div>
                    </div>
                    <div class="col-auto">
                      <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
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

declare const route: any;
export default defineComponent({
  name: "ProductEditor",
  components: {QuillEditor, 'v-select': vSelect},
  setup() {
    const router = useRouter();
    const editor = ref('new'); // new for empty form or edit for edit product
    const recap = ref('');
    const title = ref('');
    const description = ref('');
    const type = ref('simple');
    const reference = ref('');
    const price = ref(0);
    const quantity = ref(1);
    const categories = ref([]); // Tous les categories disponible
    const category = ref([]); // Categorie du produit
    const combinations = ref([]); // Contient la liste de tous les combinations du produit
    const attributeGroups = ref([]); // Tous les groups d'attibutes disponible
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
    });

    const fetchAttrs = async (idGroup) => {

    };
    return {
      recap,
      title,
      type,
      quantity,
      description,
      reference,
      price,
      categories,
      category,
      combinations,
      attributeGroups
    }
  }
})
</script>

<style scoped>

</style>
