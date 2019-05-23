<template>
<v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Policy</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.file_no" :rules="rules.name" color="blue darken-2" label="File Number" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.file_no">{{ errors.file_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.policy_no" :rules="rules.name" color="blue darken-2" label="Policy Number" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.policy_no">{{ errors.policy_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.premium" color="blue darken-2" label="Premium" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.premium">{{ errors.premium[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.commission " :rules="rules.name" color="blue darken-2" label="commission" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.effective_date" type="date" color="blue darken-2" label="Effective Date" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.exp_date " type="date" color="blue darken-2" label="Expiry Date" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.InsClass_id" filterable clearable placeholder="Insurance Class">
                                            <el-option v-for="item in InsClass" :key="item.id" :label="item.title" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>

                                        <el-select v-model="form.InsType_id" filterable clearable placeholder="Insurance Type">
                                            <el-option v-for="item in InsType" :key="item.id" :label="item.title" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.policy_status_id" filterable clearable placeholder="Policy Status">
                                            <el-option v-for="item in PolicyStatus" :key="item.id" :label="item.title" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.client_id" filterable clearable placeholder="Client">
                                            <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" :loading="loading" flat color="primary" @click="save">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openAddRequest', 'clients'],
    data() {
        const defaultForm = Object.freeze({
            file_no: '',
            commission: '',
            premium: '',
            policy_no: '',
            effective_date: '',
            exp_date: '',
            client: '',
        })
        return {
            selectClass: [],
            selectType: [],
            selectPolicy: [],
            errors: {},
            InsClass: [],
            InsType: [],
            PolicyStatus: [],
            defaultForm,
            loading: false,
            form: Object.assign({}, defaultForm),
            rules: {
                name: [val => (val || '').length > 0 || 'This field is required']
            },
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.post('/policy', this.$data.form).
            then((response) => {
                    // this.resetForm();
                    this.$emit('alertRequest');
                    this.loading = false
                    console.log(response);
                    this.$parent.AllPolicies.push(response.data)
                    this.close();

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
        alert() {
            this.$emit('alertRequest')
        },
        close() {
            this.$emit('closeRequest')
        },
    },
    computed: {
        formIsValid() {
            return (
                this.form.file_no &&
                this.form.commission &&
                this.form.premium &&
                effective_date &&
                exp_date &&
                this.form.policy_no
            )
        },
    },
    mounted() {
        axios.get('/getinsuranceType')
            .then((response) => {
                this.InsType = response.data
            })

        axios.get('/getinsuranceClass')
            .then((response) => {
                this.InsClass = response.data
            })

        axios.get('/getStatus')
            .then((response) => {
                this.PolicyStatus = response.data
            })
    }
}
</script>
