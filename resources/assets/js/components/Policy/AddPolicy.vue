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
                                    <!-- <v-flex xs12 sm6>
                                        <v-text-field v-model="file_no" color="blue darken-2" label="File Number" required disabled>
                                        </v-text-field>
                                    </v-flex> -->
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.policy_no" color="blue darken-2" label="Policy Number" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.policy_no">{{ errors.policy_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.insured" color="blue darken-2" label="Insured" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.insured">{{ errors.insured[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.premium" color="blue darken-2" label="Premium" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.premium">{{ errors.premium[0] }}</small> -->
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
                                            <el-option v-for="item in InsClass" :key="item.id" :label="item.code" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <!-- <v-flex xs12 sm6>
                                        <el-select v-model="form.InsType_id" filterable clearable placeholder="Insurance Type">
                                            <el-option v-for="item in InsType" :key="item.id" :label="item.code" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.coverage" filterable clearable placeholder="Coverage">
                                            <el-option v-for="item in coverage" :key="item.id" :label="item.code" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.policy_status_id" filterable clearable placeholder="Policy Status">
                                            <el-option v-for="item in PolicyStatus" :key="item.id" :label="item.code" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex> -->
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.client_id" filterable clearable placeholder="Client">
                                            <el-option v-for="item in clients" :key="item.id" :label="item.name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.company" filterable clearable placeholder="Underwritter">
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
    props: ['openAddRequest', 'clients', 'coverage', 'company', 'file_no'],
    data() {
        const defaultForm = Object.freeze({
            InsClass_id: '',
            client_id: '',
            company: '',
            effective_date: "",
            exp_date: "",
            insured: "",
            policy_no: "",
            premium: "",
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
            comm: null
        }
    },
    methods: {
        save() {
            this.loading = true
            this.form.commission_rate = this.commission
            this.form.file_no = this.file_no
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
        /*getClass() {
            axios.get(`/insuraceclass/${this.form.InsClass_id}`).
            then((response) => {
                    // console.log('success');/

                    // console.log(response.data.commission_rate);
                    this.comm = response.data.commission_rate
                    this.commission();

                })
                .catch((error) => {
                    // this.errors = error.response.data.errors
                    // console.log(error.response.data.errors);
                    // console.log('error');/

                })
        },*/

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
        /*commission() {
            // alert('commiss')
            console.log(parseInt(this.form.premium));
            console.log(parseInt(this.comm));

            return this.form.commission_rate = (this.form.premium) * ((this.comm) / 100)
        }*/
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
    },
}
</script>
