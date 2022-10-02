<template>
  <div>
    <div class="row mb-2">
      <div class="col-sm-5">
        <router-link to="/" class="btn btn-danger mb-2">
          <i class="mdi mdi-backspace me-2"></i> Retour
        </router-link>
      </div>
    </div>
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
                    <QuillEditor ref="quillRecap" v-model:content="recap" content-type="html" theme="snow"/>
                  </div>
                  <div class="mb-3">
                    <div class="text-title mb-2">Description</div>
                    <QuillEditor ref="quillDesc" v-model:content="description" content-type="html" theme="snow"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <form action="/target" class="dropzone" id="my-great-dropzone" @click="triggerUploadInput">
                      <div class="dz-message needsclick">
                        <div class="d-none">
                          <input type="file" id="product-image" accept="image/*" @change="loadFile">
                        </div>

                        <i class="h1 text-muted dripicons-cloud-upload"></i>
                        <h3>Click to upload.</h3>
                      </div>
                    </form>

                    <div v-if="image" id="uploadPreviewTemplate">
                      <div class="card mt-1 mb-0 shadow-none border">
                        <div class="p-2">
                          <div class="row align-items-center">
                            <div class="col-auto">
                              <a target="_blank" :href="imageUrl">
                                <img id="data-dz-thumbnail" :src="imageUrl" class="avatar-sm rounded bg-light" alt="">
                              </a>
                            </div>
                            <div class="col ps-0">
                            </div>
                            <div class="col-auto">
                              <!-- Button -->
                              <a @click.prevent="removeImage" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                <i class="dripicons-cross"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
                  <div class="row">
                    <div class="mb-3 col-6">
                      <h5 class="mb-2">Prix</h5>
                      <div>
                        <input type="number" v-model="price" class="form-control">
                      </div>
                    </div>
                    <div class="mb-3 col-6">
                      <h5 class="mb-2">Quantité</h5>
                      <div>
                        <input type="number" v-model="quantity" @input="1" class="form-control">
                      </div>
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
                <div class="row">
                  <div class="col-md-8">
                    <table class="table table-hover table-centered mb-0">
                      <tbody>
                      <tr v-for="(combination, index) in combinations">
                        <td>{{ combination.id }}</td>
                        <td>{{ combination.name }}</td>

                        <td>
                          <label>Prix</label>
                          <input type="number" v-model="combinations[index].price" class="form-control">
                        </td>
                        <td>
                          <label>Quantité</label>
                          <input type="number" v-model="combinations[index].quantity" class="form-control">
                        </td>
                        <td>
                          <label>Reference</label>
                          <input type="text" v-model="combination.reference" class="form-control">
                        </td>
                        <td>
                          <input type="radio"
                                 v-model="combination_default_on"
                                 :value="combination.id"
                                 :checked="combination_default_on === combination.id"
                                 name="default"
                                 class="form-check-input">
                        </td>
                        <td>
                          <span class="action-icon" @click="deleteCombination(combination.id)"><i
                              class="mdi mdi-trash-can"></i></span>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-4">
                    <attribute-combination-group v-for="g in attributeGroups" :group="g"
                                                 @update-attr="pushCombination"></attribute-combination-group>
                    <button class="btn btn-success" @click="generateCombination" type="button">Generer</button>
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
import {useRoute} from 'vue-router';
import * as vSelect from 'vue-select';
import {AxiosRequestConfig} from "axios";
import {doHTTP} from "../doHTTP";
import {Attribute, GroupAttribute, Product} from "../types";
import {cloneDeep, filter, find, isEmpty, isString, map} from "lodash";
import {Confirm, Loading, Notify} from 'notiflix';

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
    const router = useRoute();
    const isSaved = ref<boolean>(false);
    const dirtySaved = ref<boolean>(false);
    const ID = ref<number>(0);
    const title = ref('');
    const recap = ref('');
    const quillRecap = ref(null);
    const quillDesc = ref(null);
    const file = ref(null);
    const description = ref('');
    const type = ref('simple');
    const reference = ref('');
    const active = ref<boolean>(false);
    const price = ref(0);
    const image = ref('');
    const imageUrl = ref('');
    const combination_default_on = ref(0);
    const quantity = ref(1);
    const categories = ref([]); // Tous les categories disponible
    const category = ref([]); // Categorie du produit
    const combinations = ref<Array<Combination>>([]); // Contient la liste de tous les combinations du produit
    const combinationValues = ref<Attribute[]>([]);
    const attributeGroups = ref<Array<GroupAttribute>>([]); // Tous les groups d'attibutes disponible
    onMounted(async () => {
      // Vérifier si c'est une nouvelle article ou une modification
      const id = router.params.id || undefined;
      if (id && isString(id)) {
        ID.value = parseInt(id, 10);
        isSaved.value = true;
      }
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
      if (ID.value) {
        await populateForm();
      }
      await fetchCombination();
    });
    const removeImage = async () => {
      Confirm.show(
          'Confirmation',
          'Voulez vous vraiment supprimer l\'image?',
          'Oui',
          'Non',
          async () => {
            Loading.standard("Loading...", {
              clickToClose: false
            });
            const argConf: AxiosRequestConfig = {
              url: route('remove.image.product', {id_product: ID.value}),
              method: "DELETE"
            };
            const response = await doHTTP(argConf);
            Loading.remove();
            if (response.status == 200) {
              await populateForm();
            }
          },
          async () => {

          },
          {},
      );
    }
    const loadFile = async (event) => {
      if (file.value) {
        Confirm.show(
            'Confirmation',
            'Voulez vous remplacé l\'ancienne image par celui-ci ?',
            'Oui',
            'Non',
            () => {
              file.value = event.target.files[0];
              uploadImage();
            },
            () => {

            },
            {},
        );
      } else {
        file.value = event.target.files[0];
        await uploadImage();
      }
    }
    const uploadImage = async () => {

      if (ID.value) {
        const formData = new FormData();
        formData.append('file', file.value);
        Loading.standard("Loading...", {
          clickToClose: false
        });
        try {
          const args: AxiosRequestConfig = {
            url: route('update.image.product', {id_product: ID.value}),
            headers: {
              "Content-Type": "multipart/form-data",
            },
            method: "post",
            data: formData
          };
          const uploadResponse = await doHTTP(args);
          if (uploadResponse.status == 200) {
            await populateForm();
          }
        } catch (e) {
          Notify.failure("Une erreur s'est produite pendant l'enregistrement de l'image");
        }
        Loading.remove();
      } else {
        Notify.failure("Veuillez enregistrer le produit avant d'ajouter une image");
      }
    }
    const triggerUploadInput = () => {
      document.getElementById('product-image').click();
    }
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
            const default_combination = find(combinations.value, (v) => v.default_on);
            if (default_combination) {
              combination_default_on.value = default_combination.id;
            }
          }
        } catch (e) {
        }
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
    const populateForm = async () => {
      if (ID.value) {
        Loading.standard("Chargement...", {
          clickToClose: false
        });
        const conf: AxiosRequestConfig = {
          url: route('product', {id_product: ID.value}),
          method: 'get'
        };
        const response = await doHTTP(conf);
        if (response.status === 200) {
          const data: Product = response.data;
          title.value = data.name;
          quillRecap.value.setHTML(data.description_short); // update recap quill
          quillDesc.value.setHTML(data.description); // update description quill
          price.value = data.price;
          type.value = data.type;
          quantity.value = data.quantity;
          reference.value = data.reference;
          active.value = Boolean(data.active);
          category.value = map(data.categories, cat => cat.id_category);
          // show image
          imageUrl.value = data.image_url ?? '';
          image.value = data.image ?? '';
        }
        Loading.remove();
      }
    };
    const submitProduct = async () => {
      let error = false;
      if (isEmpty(title.value)) {
        dirtySaved.value = true;
        Notify.failure("Le nom du produit est requis");
        return;
      }
      if (!ID.value) {
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
          Loading.standard("Enregistrement...", {
            clickToClose: false
          });
          const response = await doHTTP(arg);
          if (response.status === 200) {
            isSaved.value = true;
            ID.value = cloneDeep(response.data.id);
          }
        } catch (e) {
          error = true;
        }
        Loading.remove();
      } else {
        // update
        const arg: AxiosRequestConfig = {
          url: route('update.product', {id_product: ID.value}),
          method: 'put',
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
          Loading.standard("Enregistrement...", {
            clickToClose: false
          });
          const response = await doHTTP(arg);
          if (response.status === 200) {

          }
        } catch (e) {
          Notify.failure("Une erreur s'est produite pendant l'neregistrement");
          error = true;
        }
        Loading.remove();
      }
      if (!error) {
        // Update image
        await updateCombination();
      }
    }
    const updateCombination = async () => {
      if (ID.value && !isEmpty(combinations.value)) {
        const promiseCall = [];
        Loading.standard("Chargement...", {
          clickToClose: false
        });
        for (let combination of combinations.value) {
          combination.default_on = combination_default_on.value === combination.id;
          let arg: AxiosRequestConfig = {
            url: route('update.combination', {id_combination: combination.id}),
            method: 'put',
            data: {...combination}
          };
          promiseCall.push(doHTTP(arg));
        }
        const responseAll = await Promise.all(promiseCall);
        Loading.remove();
      }
    }
    const deleteCombination = async (idCombination: number) => {
      // Vérifier si la combination est par default
      if (combination_default_on.value === idCombination) {
        combination_default_on.value = 0;
      }
      Confirm.show(
          'Confirmation',
          'Voulez vous vraiment supprimer l\'attribut?',
          'Oui',
          'Non',
          async () => {
            Loading.standard("Loading...", {
              clickToClose: false
            });
            const configDelete: AxiosRequestConfig = {
              url: route('delete.combination', {id_combination: idCombination}),
              method: "DELETE",
            };
            const response = await doHTTP(configDelete);
            Loading.remove();
            if (response.status == 200) {
              await fetchCombination();
            }
          },
          async () => {
          },
          {},
      );
    }
    const generateCombination = async () => {
      dirtySaved.value = true;
      if (isEmpty(title.value) || isEmpty(combinationValues.value)) {
        return;
      }
      if (!isSaved.value) {
        await submitProduct();
      }
      if (ID.value) {
        const attrIds: Array<number> = map(combinationValues.value, (attr) => attr.id_attribute);
        Loading.standard('Création en cours ...');
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
          Loading.remove();
        } catch (e) {
          Loading.remove();
          Notify.failure(e);
        }
      }
    };
    return {
      recap,
      title,
      type,
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
      quillRecap,
      quillDesc,
      file,
      image,
      imageUrl,
      combination_default_on,
      pushCombination,
      loadFile,
      triggerUploadInput,
      generateCombination,
      removeImage,
      deleteCombination,
      submitProduct
    }
  }
})
</script>

<style scoped>

</style>
