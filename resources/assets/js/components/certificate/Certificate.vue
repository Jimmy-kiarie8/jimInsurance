<template>
<div>
    <v-content>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <!-- <v-btn @click="openAdd" color="primary">Add A Branch</v-btn> -->
                <div v-show="!loader">
                    <v-card-title>
                        Certificate Batch
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getCertificates">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-btn color="primary" flat @click="openAdd">Certificate Batch</v-btn>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :loading="loading" :items="AllCertificates" :search="search" counter class="elevation-1">
                        <v-progress-linear v-slot:progress color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.underwriter }} </td>
                            <td class="text-xs-right">{{ props.item.serial_from }}</td>
                            <td class="text-xs-right">{{ props.item.serial_to }}</td>
                            <td class="text-xs-right">{{ props.item.total }}</td>
                            <td class="justify-center layout px-0">
                                <v-btn icon class="mx-0" @click="editItem(props.item)">
                                    <v-icon color="blue darken-2" small>edit</v-icon>
                                </v-btn>
                                <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                                    <v-icon color="pink darken-2" small>delete</v-icon>
                                </v-btn>

                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                        <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                            From {{ pageStart }} to {{ pageStop }}
                        </template>
                    </v-data-table>
                </div>
            </v-layout>
        </v-container>
    </v-content>
    <AddCertificate :user="user" :openAddRequest="OpenAdd" @closeRequest="close" @alertRequest="alert"></AddCertificate>
    <EditCertificate :openAddRequest="OpenAdd" @closeRequest="close" @alertRequest="alert"></EditCertificate>
    <!-- <PrintCert :openPrintRequest="openPrint" @closeRequest="close" @alertRequest="alert" :printData="editedItem"></PrintCert> -->
    <v-snackbar :timeout="timeout" :bottom="y === 'bottom'" :color="color" :left="x === 'left'" v-model="snackbar">
        {{ message }}
        <v-icon dark right>check_circle</v-icon>
    </v-snackbar>
</div>
</template>

<script>
let AddCertificate = require('./AddCertificate')
let EditCertificate = require('./EditCertificate')
// let PrintCert = require('./PrintCert')
export default {
    props: ['user', 'role'],
    components: {
        AddCertificate,
        EditCertificate,
        // PrintCert
    },
    data() {
        return {
            errors: {},
            openPrint: false,
            loading: false,
            OpenAdd: false,
            search: '',
            snackbar: false,
            timeout: 5000,
            message: 'Success',
            color: 'black',
            y: 'bottom',
            x: 'left',
            dialog: false,
            headers: [{
                    text: 'Underwritter',
                    align: 'left',
                    value: 'underwriter'
                },
                {
                    text: 'Serial From',
                    value: 'serial_from'
                },
                {
                    text: 'Serial To',
                    value: 'serial_to'
                },
                {
                    text: 'Total Certificates',
                    value: 'total'
                },
                {
                    text: 'Actions',
                    value: 'name',
                    sortable: false
                }
            ],
            editedIndex: -1,
            loader: false,
            Editloader: false,
            editModal: false,
            AllCertificates: [],
            editedItem: {},
        }
    },
    methods: {
        editItem(item) {
            this.editModal = true
            this.editedIndex = this.AllCertificates.indexOf(item)
            this.editedItem = Object.assign({}, item)
        },
        printItem(item) {
            this.openPrint = true
            this.editedIndex = this.AllCertificates.indexOf(item)
            this.editedItem = Object.assign({}, item)
        },
        openAdd() {
            this.OpenAdd = true
        },

        deleteItem(item) {
            const index = this.AllCertificates.indexOf(item)
            confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
        },

        alert() {
            this.message = 'Branch added'
            this.color = 'black'
            this.snackbar = true
        },
        close() {
            this.OpenAdd = this.editModal = false
        },
        getCertificates() {
            this.loading=true
            axios.get('getCertificates')
            .then((response) => {
                this.AllCertificates = response.data
                this.loading = false
                this.loader = false
            })
            .catch((error) => {
                this.loading = false
                this.loader = false
                this.errors = error.response.data.errors
            })
        }
    },
    mounted() {
        this.loader = true
        this.getCertificates()
    },
}
</script>
