<template>
  <div>
    <h6>{{group.name}}</h6>
    <div class="mt-2">
      <div v-for="attr in attributes" :key="attr.id_attribute">
        <div class="form-check">
          <input type="checkbox" @input="(e) => {updateInput(e, attr);}"  class="form-check-input">
          <label class="form-check-label" >{{attr.name}}</label>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, PropType, ref} from 'vue';
import {Attribute, GroupAttribute} from "../types";
import {doHTTP} from "../doHTTP";
import {AxiosRequestConfig} from "axios";
declare const route: any;
export default defineComponent({
  name: "AttributeCombinationGroup",
  props: {
    group: {
      type: Object as PropType<GroupAttribute>
    }
  },
  emits: ['update-attr'],
  setup(props, {emit}) {
    const attributes = ref<Attribute[]>([]);
    const loading = ref<boolean>(false);
    onMounted( async () => {
      const arg: AxiosRequestConfig = {
        url: route('options.group.attribute', {id_group: props.group.id_product_group}),
        method: 'options',
        data: {}
      }
      loading.value = true;
      const response = await doHTTP(arg);
      loading.value = false;
      if (response.status == 200) {
        attributes.value = response.data;
      }
    });

    const updateInput = (e,attr: Attribute) => {
      if (e.target.checked) emit('update-attr',attr, 'ADD')
      if (!e.target.checked) emit('update-attr', attr, 'REMOVE')
    }

    return {
      loading,
      attributes,
      updateInput
    }
  }
})
</script>

<style scoped>

</style>
