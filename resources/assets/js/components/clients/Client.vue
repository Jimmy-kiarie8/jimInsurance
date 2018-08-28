<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card style="background: rgba(5, 117, 230, 0.16);">
                        <v-layout wrap>
                            <v-flex xs4 sm3 offset-sm4>
                                <v-select :items="AllBranches" v-model="select" :hint="`${select.branch_name}, ${select.id}`" label="Select Branch" single-line item-text="branch_name" item-value="id" return-object persistent-hint></v-select>
                            </v-flex>
                            <v-flex xs4 sm3>
                                <v-btn raised color="info" @click="sort">Filter</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card>
                    <v-card-title>
                        Clients
                        <v-btn slot="activator" color="primary" dark @click="openAdd">Add Client</v-btn>
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getClients">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="AllClients" class="elevation-1" :loading="loading" :search="search">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.name }}</td>
                            <td class="text-xs-right">{{ props.item.client_no }}</td>
                            <td class="text-xs-right">{{ props.item.email }}</td>
                            <td class="text-xs-right">{{ props.item.phone }}</td>
                            <td class="text-xs-right">{{ props.item.birth_day }}</td>
                            <td class="text-xs-right">{{ props.item.created_at }}</td>
                            <td class="justify-center layout px-0">
                                <v-btn icon class="mx-0" @click="openEdit(props.item)">
                                    <v-icon small color="blue darken-2">edit</v-icon>
                                </v-btn>
                                <v-btn icon class="mx-0" @click="openShow(props.item)">
                                    <v-icon small color="info darken-2">visibility</v-icon>
                                </v-btn>
                                <v-btn icon class="mx-0" @click="deleteItem(props.item)">
                                    <v-icon small color="pink darken-2">delete</v-icon>
                                </v-btn>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                    <!-- users display -->
                </div>
            </v-layout>
        </v-container>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="pink" style="margin: 1rem"></v-progress-circular>
        </div>
        <v-snackbar :timeout="timeout" bottom="bottom" :color="color" left="left" v-model="snackbar">
            {{ message }}
            <v-icon dark right>check_circle</v-icon>
        </v-snackbar>
    </v-content>
    <AddClient @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :AllBranches="AllBranches"></AddClient>
    <ShowClient @closeRequest="close" :openShowRequest="dispShow" :showData="editedItem"></ShowClient>
    <EditClient @closeRequest="close" :openEditRequest="dispEdit" @alertRequest="showAlert" :form="editedItem" :AllBranches="AllBranches"></EditClient>
</div>
</template>

<script>
let AddClient = require('./AddClient.vue')
let ShowClient = require('./ShowClient.vue')
let EditClient = require('./EditClient.vue')
export default {
    props: ['user', 'role'],
    components: {
        AddClient,
        ShowClient,
        EditClient
    },
    data() {
        return {
            headers: [{
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Client Number",
                    value: "client_no"
                },
                {
                    text: "Email",
                    value: "email"
                },
                {
                    text: "Phone Number",
                    value: "phone"
                },
                {
                    text: "BirthDay",
                    value: "birth_day"
                },
                {
                    text: "Created On",
                    value: "created_at"
                },
                {
                    text: 'Actions',
                    value: 'name',
                    sortable: false
                }
            ],
            AllBranches: [],
            search: '',
            loader: false,
            dispAdd: false,
            dispShow: false,
            dispEdit: false,
            snackbar: false,
            loading: false,
            timeout: 5000,
            color: 'black',
            message: 'Success',
            AllClients: [],
            editedItem: {},
            select: {
                branch_name: 'All',
                id: 'all'
            },
        }
    },
    methods: {
        openShow(item) {
            
            this.editedIndex = this.AllClients.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dispShow = true
        },
        openAdd() {
            this.dispAdd = true
        },
        openEdit(item) {
            this.editedIndex = this.AllClients.indexOf(item)
            this.editedItem = Object.assign({}, item)
            // this.$children[4].list = this.company[key]
            // this.$children[3].form = this.AllClients[key]
            this.dispEdit = true
        },
        showAlert() {
            this.message = 'Successifully Added';
            this.snackbar = true;
            this.color = 'black';
        },
        sort() {
            this.loading = true
            axios.post('getSorted', this.select)
                .then((response) => {
                    this.loading = false
                    this.AllClients = response.data
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        deleteItem(item) {
            if (confirm('Are you sure you want to delete this item?')) {
                this.loader = true
                axios.delete(`/users/${id}`)
                    .then((response) => {
                        this.AllClients.splice(index, 1)
                        this.loader = false
                        this.message = 'deleted successifully'
                        this.color = 'red'
                        this.snackbar = true
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors
                        this.loader = false
                        this.message = 'something went wrong'
                        this.color = 'red'
                        this.snackbar = true
                    })
            }
        },
        close() {
            this.dispAdd = this.dispShow = this.dispEdit = false
        },
        getClients() {
            axios.get('getClients')
                .then((response) => {
                    this.AllClients = response.data
                    this.loading = false
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        }
    },
    mounted() {
        this.loader = true
        this.getClients()
        axios.get('getBranch')
            .then((response) => {
                this.loader = false
                this.AllBranches = response.data
            })
            .catch((error) => {
                this.loader = false
                this.errors = error.response.data.errors
            })
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.role === 'Admin' || vm.role === 'companyAdmin') {
    //             next();
    //         } else {
    //             next('/');
    //         }
    //     })
    // }
}
</script>
