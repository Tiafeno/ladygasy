import axios, {AxiosRequestConfig, AxiosResponse, Method} from 'axios';
import {isUndefined} from 'lodash';
export const doHTTP = async (config: AxiosRequestConfig): Promise<AxiosResponse> => {
  axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  try {
    return await axios.request(config);
  } catch (e: any) {
    if (axios.isAxiosError(e) && isUndefined(e.response)) return e.response;
    throw e?.message ?? "Une erreur inconnue s'est produite";
  }
}
