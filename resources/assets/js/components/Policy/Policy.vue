<template>
<div>
    <v-content>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
        <!-- <router-link :to="test">test</router-link> -->
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <!-- <v-btn @click="openAdd" color="primary">Add A Branch</v-btn> -->
                <div v-show="!loader">
                    <v-text-field v-model="policy.search" append-icon="search" label="Enter policy no and press enter to search" @keyup.enter="policy_search"></v-text-field>
                    <v-pagination v-model="AllPolicies.current_page" :length="AllPolicies.last_page" total-visible="5" @input="next_page(AllPolicies.path, AllPolicies.current_page)" circle v-if="AllPolicies.last_page > 1"></v-pagination>
                    <v-card-title>
                        <v-btn color="primary" flat @click="openAdd">Add A Policy</v-btn>
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getPolicy">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-data-table :loading="loading" :headers="headers" :items="AllPolicies.data" :search="search" class="elevation-1">
                        <v-progress-linear v-slot:progress color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <!-- <td>{{ props.item.file_no }} </td>   -->
                            <td>{{ props.item.policy_no }}</td>
                            <td class="text-xs-right">{{ props.item.client_name }}</td>
                            <td class="text-xs-right">{{ props.item.client_phone }}</td>
                            <td class="text-xs-right">{{ props.item.premium }}</td>
                            <td class="text-xs-right">{{ props.item.effectiveDate }}</td>
                            <td class="text-xs-right">{{ props.item.expDate }}</td>
                            <td class="justify-center layout px-0">
                                <v-btn icon class="mx-0" @click="editItem(props.item)">
                                    <v-icon color="blue darken-2" small>edit</v-icon>
                                </v-btn>
                                <!-- <v-btn icon class="mx-0" @click="printItem(props.item)">
                                    <v-icon color="indigo darken-2" small>print</v-icon>
                                </v-btn> -->
                                <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                                    <v-icon color="pink darken-2" small>delete</v-icon>
                                </v-btn>

                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                </div>
            </v-layout>
        </v-container>
    </v-content>
    <AddPolicy :openAddRequest="OpenAdd" @closeRequest="close" @alertRequest="alert" :clients="allClients" :company="allCompanies" :coverage="allCoverages" :file_no="file_no"></AddPolicy>
    <EditPolicy :openEditRequest="editModal" @closeRequest="close" @alertRequest="alert" :Editdata="editedItem" :clients="allClients" :company="allCompanies" :coverage="allCoverages"></EditPolicy>
    <PrintCert :openPrintRequest="openPrint" @closeRequest="close" @alertRequest="alert" :printData="editedItem"></PrintCert>
    <v-snackbar :timeout="timeout" bottom='bottom' :color="color" left='left' v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
let AddPolicy = require('./AddPolicy')
let EditPolicy = require('./EditPolicy')
let PrintCert = require('./PrintCert')
export default {
    props: ['user'],
    components: {
        AddPolicy,
        EditPolicy,
        PrintCert
    },
    data() {
        return {
            errors: {},
            loading: false,
            OpenAdd: false,
            openPrint: false,
            file_no: null,
            search: '',
            snackbar: false,
            timeout: 5000,
            message: 'Success',
            color: 'black',
            dialog: false,
            policy: {
                search: ''
            },
            headers: [
                // {
                //     text: 'File Number',
                //     align: 'left',
                //     value: 'file_no'
                // },
                {
                    text: 'Policy Number',
                    value: 'policy_no'
                },
                {
                    text: 'Client Name',
                    value: 'client_name'
                },
                {
                    text: 'Client Phone',
                    value: 'client_name'
                },
                {
                    text: 'Premium',
                    value: 'premium'
                },
                {
                    text: 'Effective Date',
                    value: 'effectiveDate'
                },
                {
                    text: 'Expiry Date',
                    value: 'expDate'
                },
                {
                    text: 'Actions',
                    value: 'name',
                    sortable: false
                }
            ],
            Allusers: [],
            editedIndex: -1,
            loader: false,
            Editloader: false,
            editModal: false,
            allClients: [],
            AllPolicies: [],
            editedItem: {},
            allCoverages: [],
            allCompanies: [],
        }
    },

    methods: {
        editItem(item) {
            this.editModal = true
            this.getClient()
            this.getCoverage()
            this.getCompany()
            this.editedIndex = this.AllPolicies.indexOf(item)
            this.editedItem = Object.assign({}, item)
        },
        printItem(item) {
            this.openPrint = true
            this.editedIndex = this.AllPolicies.indexOf(item)
            this.editedItem = Object.assign({}, item)
        },
        openAdd() {
            this.OpenAdd = true
            this.getClient()
            this.getCompany()
            this.getCoverage()
            this.getFileno()
        },

        deleteItem(item) {
            if (confirm("Are you sure you want to delete this Client?")) {
                this.loading = true;
                axios
                    .delete(`/policy/${item.id}`)
                    .then(response => {
                        // this.AllPolicies.splice(index, 1);
                        this.loading = false;
                        this.message = "deleted successifully";
                        this.color = "red";
                        this.snackbar = true;
                        this.getPolicy()
                    })
                    .catch(error => {
                        this.loading = false;
                        this.message = "something went wrong";
                        this.color = "red";
                        this.snackbar = true;
                        this.errors = error.response.data.errors;
                    });
            }
        },
        next_page(path, page) {
            this.loading = true;
            axios.get(path + '?page=' + this.AllPolicies.current_page)
                .then((response) => {
                    this.AllPolicies = response.data
                    this.loading = false
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        alert() {
            this.message = 'Success'
            this.color = 'black'
            this.snackbar = true
        },
        close() {
            this.OpenAdd = this.editModal = this.openPrint = false
        },

        getPolicy() {
            this.loading = true
            axios.get('getPolicy')
                .then((response) => {
                    this.AllPolicies = response.data
                    this.loading = false
                    this.loader = false
                })
                .catch((error) => {
                    this.loading = false
                    this.loader = false
                    this.errors = error.response.data.errors
                })
        },

        getClient() {
            axios.get('clients')
                .then((response) => {
                    this.allClients = response.data
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        getCompany() {
            axios.get('companies')
                .then((response) => {
                    this.allCompanies = response.data
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        getCoverage() {
            axios.get('coverage')
                .then((response) => {
                    this.allCoverages = response.data
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        getFileno() {
        axios.get('/file_no')
            .then((response) => {
                this.file_no = 'PF_' + response.data
            })
        },

        policy_search() {
            this.loading = true;
            axios.get(`policy_search/${this.policy.search}`)
                .then(response => {
                    this.AllPolicies = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
    },
    mounted() {
        this.loader = true
        this.getPolicy()

    },
}
</script>
