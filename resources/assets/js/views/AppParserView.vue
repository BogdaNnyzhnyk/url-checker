<template>
    <div class="container">
        <form class="auth-form" @submit.prevent="dataSubmit">

            <div class="form-group input-group input-group__login">
                <textarea name="inputText"
                          required
                          placeholder="Введите ссылки в текстовые поле  (каждая с новой строки)."
                          v-model="inputText"
                />
            </div>

            <button :disabled="loading" type="submit" class="btn btn-green">
                получить информацию
            </button>
        </form>

        <table class="table" :class="{ 'is-loading': loading }">
            <thead>
                <tr>
                    <th>
                        status
                    </th>
                    <th>
                        title
                    </th>
                    <th>
                        url
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(url, index) in urlsData"

                    :key="index">
                    <td>
                        {{url.url}}
                    </td>
                    <td>
                        {{url.title}}
                    </td>
                    <td>
                        {{url.status}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>

    import axios from 'axios'

    export default {
        name: "AppParserView",
        data() {
            return {
                inputText: '',
                urlsData: [],

                loading: false,
            }
        },
        methods: {

            parseText(){
                let result = [];
                this.inputText.split("\n").forEach(function(e) {
                    result.push({
                        url: e,
                        title: null,
                        status: null,
                    })
                });
                return result
            },

            postRequest(url) {
                return axios.post('/check', {
                    url: url
                });
            },

            dataSubmit() {
                this.loading = true;
                this.parseText().forEach((url) => {
                    this.postRequest(url.url).then( response => {
                        this.urlsData.push(response.data)
                    }).catch(error => {
                        console.log(error);
                        this.loading = false;
                    }).then(() => {
                        this.loading = false;
                    });
                })
            },
        },
    }
</script>

<style scoped>
</style>
