<template>
<v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Client</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="client_no" disabled color="blue darken-2" label="Client Number" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.client_no">{{ errors.client_no[0] }}</small> -->
                                    </v-flex>
                                    <!-- <v-flex xs12 sm6>
                                        <v-text-field v-model="form.pin_no" color="blue darken-2" label="Client Pin" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.pin_no">{{ errors.pin_no[0] }}</small>
                                    </v-flex> -->
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" :rules="rules.name" color="blue darken-2" label="Full name" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.birth_day" :rules="rules.name" type="date" color="blue darken-2" label="birth_day" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.birth_day">{{ errors.birth_day[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" :rules="rules.name" color="blue darken-2" label="Phone" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.company_id" filterable clearable placeholder="Company">
                                            <el-option v-for="item in company" :key="item.id" :label="item.company_name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                    <div v-show="loader" style="text-align: center; width: 100%;">
                        <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
                    </div>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openAddRequest', 'company', 'client_no'],
    data() {
        const defaultForm = Object.freeze({
            name: '',
            email: '',
            phone: null,
            company_id: '',
            address: '',
        })
        return {
            loading: false,
            errors: {},
            defaultForm,
            loader: false,
            form: Object.assign({}, defaultForm),
            emailRules: [
                v => {
                    return !!v || 'E-mail is required'
                },
                v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ],
            rules: {
                name: [val => (val || '').length > 0 || 'This field is required']
            },
        }
    },
    methods: {
        save() {
            this.form.client_no = this.client_no
            this.loading = true
            axios.post('/clients', this.$data.form).
            then((response) => {
                    this.loading = false
                    console.log(response);
                    this.$parent.AllClients.push(response.data)
                    this.$emit('alertRequest');
                    // this.close;
                    // this.resetForm();

                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        resetForm() {
            this.form = Object.assign({}, this.defaultForm)
            this.$refs.form.reset()
        },
        close() {
            this.$emit('closeRequest')
        },
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                this.form.address 
            )
        },
    },
    mounted() {

    }
}
</script>
