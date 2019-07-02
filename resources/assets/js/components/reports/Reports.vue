<template>
<v-content>
    <div v-show="loader" style="text-align: center">
        <v-progress-circular :width="3" indeterminate color="pink" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-container fluid fill-height>
        <div v-show="!loader" style="width: 100%">
            <v-layout justify-center align-center>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex sm12>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex sm4>
                                        <v-card>
                                            <v-card-title fixed>
                                                <span class="headline">Premium balances </span>
                                            </v-card-title>
                                            <v-divider></v-divider>
                                            <el-select v-model="form.client" clearable filterable placeholder="Select Client">
                                                <el-option v-for="item in AllClients" :key="item.id" :label="item.name" :value="item.id">
                                                </el-option>
                                            </el-select>
                                            <v-flex sm10>
                                                <v-text-field v-model="form.start_date" label="start date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-flex sm10>
                                                <v-text-field v-model="form.end_date" label="End Date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-card-actions>
                                                <v-btn flat color="primary" @click="download" :loading="loading">Filter</v-btn>
                                                <v-spacer></v-spacer>
                                                <v-btn flat v-if="Report.length > 0">
                                                    <download-excel :data="Report" :fields="premium_fields">
                                                        Export
                                                        <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                                                        </download-excel>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-flex>
                                    <v-flex sm4>
                                        <v-card>
                                            <v-card-title fixed>
                                                <span class="headline">Renewal reminders </span>
                                            </v-card-title>
                                            <v-divider></v-divider>
                                            <!-- <el-select v-model="form.client" clearable filterable placeholder="Select Client">
                                                <el-option v-for="item in AllClients" :key="item.id" :label="item.name" :value="item.id">
                                                </el-option>
                                            </el-select> -->
                                            <v-flex sm10>
                                                <v-text-field v-model="reminder.start_date" label="start date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-flex sm10>
                                                <v-text-field v-model="reminder.end_date" label="End Date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-card-actions>
                                                <v-btn flat color="primary" @click="reminderReport()" :loading="loading">Filter</v-btn>
                                                <v-spacer></v-spacer>
                                                <v-btn flat v-if="filterreminder.length > 0">
                                                    <download-excel :data="filterreminder" :fields="reminder_fields">
                                                        Export
                                                        <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                                                    </download-excel>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-flex>
                                    <v-flex sm4>
                                        <v-card>
                                            <v-card-title fixed>
                                                <span class="headline">Production report</span>
                                            </v-card-title>
                                            <v-divider></v-divider>
                                            <v-flex sm10>
                                                <v-text-field v-model="products.start_date" label="start date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-flex sm10>
                                                <v-text-field v-model="products.end_date" label="End Date" type="date" color="blue darken-2" required></v-text-field>
                                            </v-flex>
                                            <v-card-actions>
                                                <v-btn flat color="primary" @click="productReport()" :loading="loading">Filter</v-btn>
                                                <v-spacer></v-spacer>
                                                <v-btn flat v-if="filterproducts.length > 0">
                                                    <download-excel :data="filterproducts" :fields="product_fields">
                                                        Export
                                                        <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                                                        </download-excel>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-layout>
        </div>
        <v-snackbar v-model="snackbar" absolute top right :color="color">
            <span>{{ message }}</span>
            <v-icon dark>check_circle</v-icon>
        </v-snackbar>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            snackbar: false,
            color: 'black',
            message: '',
            form: {
                start_date: '',
                end_date: '',
            },
            AllClients: [],
            selectC: [{
                name: 'All',
                id: 'all',
            }],
            filterproducts: [],
            filterreminder: [],
            reminder: {},
            products: {},
            Report: [],
            loader: false,
            loading: false,
            premium_fields: {
                "Client Number": "client_no",
                "Client Name": "client_name",
                "Effective Date": "effective_date",
                "Expiry Date": "exp_date",
                "Insured": "insured",
                "Premium Charge": "premium",
                "Premium Paid": "premium_paid",
                "Premium": "premium",
                "Insurance Class": "insurance_class",
            },
            product_fields: {
                "Policy Number": "policy_no",
                "Client Number": "client_no",
                "Client Name": "client_name",
                "Effective Date": "effective_date",
                "Expiry Date": "exp_date",
                "Insured": "insured",
                "Premium Charge": "premium",
                "Premium Paid": "premium_paid",
                "Premium": "premium",
                "Insurance Class": "insurance_class",
            },
            reminder_fields: {
                "Client Number": "client_no",
                "Client Name": "client_name",
                "Client Phone": "client_phone",
                "Effective Date": "effective_date",
                "Expiry Date": "exp_date",
                "Insured": "insured",
                "Premium": "premium",
                "Insurance Class": "insurance_class",
            }
        }
    },
    methods: {
        download() {
            axios.post("premium", this.form)
                .then(response => {
                    this.loading = false;
                    this.Report = response.data;
                    if (response.data.length > 0) {
                        this.snackbar = true
                        this.color = 'indigo'
                        this.message = 'Data fetched'
                    } else {
                        this.snackbar = true
                        this.color = 'red'
                        this.message = 'No Data'
                    }
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        productReport() {
            axios.post("products", this.products)
                .then(response => {
                    this.loading = false;
                    this.filterproducts = response.data;
                    if (response.data.length > 0) {
                        this.snackbar = true
                        this.color = 'indigo'
                        this.message = 'Data fetched'
                    } else {
                        this.snackbar = true
                        this.color = 'red'
                        this.message = 'No Data'
                    }
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        reminderReport() {
            axios.post("reminder", this.reminder)
                .then(response => {
                    this.loading = false;
                    this.filterreminder = response.data;
                    if (response.data.length > 0) {
                        this.snackbar = true
                        this.color = 'indigo'
                        this.message = 'Data fetched'
                    } else {
                        this.snackbar = true
                        this.color = 'red'
                        this.message = 'No Data'
                    }
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
    },
    mounted() {
        this.loader = true;

        axios.get("clients")
            .then(response => {
                this.loader = false;
                this.AllClients = response.data;
            })
            .catch(error => {
                this.loader = false;
                this.errors = error.response.data.errors;
            });
    }
}
</script>
