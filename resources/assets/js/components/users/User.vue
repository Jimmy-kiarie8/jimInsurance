<template>
<div>

    <v-content>

        <v-container fluid fill-height v-show="!loader">

            <v-layout justify-center align-center>

                <div class="container">

                    <v-card style="background: rgba(5, 117, 230, 0.16);">
                        <v-layout wrap>
                            <v-flex xs4 sm3 offset-sm4>
                                <v-select :items="items" v-model="select" :hint="`${select.state}, ${select.abbr}`" label="Select" single-line item-text="state" item-value="abbr" return-object persistent-hint></v-select>
                            </v-flex>
                            <!-- <v-spacer></v-spacer> -->
                            <v-flex xs4 sm3>
                                <v-btn raised color="info" @click="sort">Filter</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card>
                    <!-- users display -->

                    <v-card-title>
                        Users
                        <v-btn slot="activator" color="primary" dark @click="openAdd">Add User</v-btn>
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getUsers">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>

                    <v-data-table :headers="headers" :items="Allusers" class="elevation-1" :loading="loading" :search="search">

                        <v-progress-linear v-slot:progress color="blue" indeterminate></v-progress-linear>

                        <template slot="items" slot-scope="props">

                            <td>{{ props.item.name }}</td>

                            <td class="text-xs-right">{{ props.item.email }}</td>

                            <td class="text-xs-right">{{ props.item.address }}</td>

                            <td class="text-xs-right">{{ props.item.phone }}</td>

                            <td class="text-xs-right">{{ props.item.city }}</td>

                            <td class="text-xs-right">{{ props.item.branch }}</td>

                            <td class="text-xs-right">{{ props.item.status }}</td>

                            <td class="justify-center layout px-0">

                                <v-btn icon class="mx-0" @click="openEdit(props.item)">
                                    <v-icon small color="blue darken-2">edit</v-icon>
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
            <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
        </div>
        <v-snackbar :timeout="timeout" :bottom="y === 'bottom'" :color="color" :left="x === 'left'" v-model="snackbar">
            {{ message }}
            <v-icon dark right>check_circle</v-icon>
        </v-snackbar>
    </v-content>
    <AddUser @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :AllBranches="AllBranches"></AddUser>
    <ShowUser @closeRequest="close" :openShowRequest="dispShow"></ShowUser>
    <EditUser @closeRequest="close" :openEditRequest="dispEdit" @alertRequest="showAlert" :form="editedItem" :AllBranches="AllBranches"></EditUser>
</div>
</template>

<script>
let AddUser = require('./AddUser.vue')

let ShowUser = require('./ShowUser.vue')

let EditUser = require('./EditUser.vue')

export default {

    props: ['user', 'role'],

    components: {

        AddUser,

        ShowUser,

        EditUser

    },

    data() {

        return {

            select: {

                state: 'All',

                abbr: 'all'

            },

            items: [{

                    state: 'All',

                    abbr: 'all'

                },

                {

                    state: 'Admin',

                    abbr: 'Admin'

                },

                {

                    state: 'company Admin',

                    abbr: 'companyAdmin'

                },

                {

                    state: 'Customers',

                    abbr: 'Customer'

                },

                {

                    state: 'Drivers',

                    abbr: 'Driver'

                },

            ],

            headers: [{
                    text: "Name",

                    value: "name"
                },

                {
                    text: "Email",

                    value: "email"
                },

                {
                    text: "Address",

                    value: "address"
                },

                {
                    text: "Phone Number",

                    value: "phone"
                },

                {
                    text: "City",

                    value: "city"
                },

                {
                    text: "Branch",

                    value: "branch"
                },

                {
                    text: "Status",

                    value: "status"
                },

                {
                    text: 'Actions',

                    value: 'name',

                    sortable: false
                }
            ],

            AllBranches: {},

            search: '',

            loader: false,

            a1: null,

            dispAdd: false,

            dispShow: false,

            dispEdit: false,

            snackbar: false,

            loading: false,

            timeout: 5000,

            color: 'black',

            message: 'Success',

            y: 'bottom',

            x: 'left',

            Allusers: [],

            temp: '',

            editedItem: {},

            select: {
                state: 'All',
                abbr: 'all'
            },
            items: [{
                    state: 'All',
                    abbr: 'all'
                },
                {
                    state: 'Admin',
                    abbr: '1'
                },
                {
                    state: 'Branch Admin',
                    abbr: '2'
                },
                {
                    state: 'Customers',
                    abbr: '3'
                },
                {
                    state: 'Drivers',
                    abbr: '4'
                },
            ],

        }

    },

    watch: {

        search() {

            if (this.search.length > 0) {

                this.temp = this.Allusers.filter((item) => {

                    return item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1

                });

            } else {

                this.temp = this.Allusers

            }

        }

    },

    methods: {

        openShow(key) {

            // this.$children[4].list = this.company[key]

            this.$children[2].list = this.Allusers[key]

            this.dispShow = true

        },

        openAdd() {

            this.dispAdd = true

        },

        openEdit(item) {
            this.editedIndex = this.Allusers.indexOf(item)

            this.editedItem = Object.assign({}, item)

            // this.$children[4].list = this.company[key]

            // this.$children[3].form = this.Allusers[key]

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
                    this.Allusers = response.data
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

                        this.Allusers.splice(index, 1)

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

        getUsers() {
            this.loading = true
            axios.get('getUsers')

                .then((response) => {

                    this.Allusers = this.temp = response.data

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

        this.getUsers()

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

<style scoped>
.content--wrap {
    margin-top: -100px
}

#profile {
    width: 70px;
    height: 60px;
    border-radius: 50%;
    margin-left: 80px;
    margin-top: -30px;
}

i {
    padding: 7px;
    background: #f0f0f0;
    border-radius: 50%;
}

.list-group-item:hover,
.list-group-item:focus {
    z-index: 1;
    background: #f9f9f9;
    text-decoration: none;
}
</style>
