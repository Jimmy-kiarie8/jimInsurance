<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div class="container">
                    <v-card-title>
                        Contacts
                        <v-btn slot="activator" color="primary" dark @click="openAdd" flat>Add Contact</v-btn>
                        <v-btn slot="activator" color="primary" dark @click="sendSms" flat>Send Sms</v-btn>
                        <v-tooltip right>
                            <v-btn icon slot="activator" class="mx-0" @click="getContacts">
                                <v-icon color="blue darken-2" small>refresh</v-icon>
                            </v-btn>
                            <span>Refresh</span>
                        </v-tooltip>
                        <v-spacer></v-spacer>
                        <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>
                    <v-data-table v-model="selected" :headers="headers" :items="allContacts" :pagination.sync="pagination" select-all item-key="name" class="elevation-1">
                        <template slot="headers" slot-scope="props">
                            <tr>
                                <th>
                                    <v-checkbox :input-value="props.all" :indeterminate="props.indeterminate" primary hide-details @click.native="toggleAll"></v-checkbox>
                                </th>
                                <th v-for="header in props.headers" :key="header.text" :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']" @click="changeSort(header.value)">
                                    <v-icon small>arrow_upward</v-icon>
                                    {{ header.text }}
                                </th>
                            </tr>
                        </template>
                        <template slot="items" slot-scope="props">
                            <tr :active="props.selected" @click="props.selected = !props.selected">
                                <td>
                                    <v-checkbox :input-value="props.selected" primary hide-details></v-checkbox>
                                </td>
                                <td>{{ props.item.name }}</td>
                                <td class="text-xs-right">{{ props.item.phone }}</td>
                                <td class="text-xs-right">{{ props.item.created_at }}</td>
                                <td class="text-xs-right">
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
                            </tr>
                        </template>
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
    <myCreate></myCreate>
    <!-- <myEdit></myEdit> -->
    <mySend></mySend>
</div>
</template>

<script>
import myCreate from './Create'
// import myEdit from './Edit'
import mySend from './Send'
export default {
    props: ["user"],
    components: {
        myCreate,
        // myEdit,
        mySend
    },
    data() {
        return {
            pagination: {
                sortBy: 'name'
            },
            selected: [],
            headers: [{
                    text: "Name",
                    value: "name"
                },
                {
                    text: "Phone Number",
                    value: "phone"
                },
                {
                    text: "Created on",
                    value: "created_at"
                },
                {
                    text: "Actions",
                    sortable: false
                }
            ],
            allCompanies: [],
            search: "",
            loader: false,
            dispAdd: false,
            dispShow: false,
            dispEdit: false,
            snackbar: false,
            loading: false,
            timeout: 5000,
            color: "black",
            message: "Success",
            allContacts: [],
            editedItem: {},
            contact_no: '',
            select: {
                branch_name: "All",
                id: "all"
            }
        };
    },
    methods: {
        openShow(item) {
            this.editedIndex = this.allContacts.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dispShow = true;
        },
        openAdd() {
            eventBus.$emit('smsContactEvent')
        },
        sendSms(item) {
            eventBus.$emit('sendSmsEvent', this.selected)
        },
        deleteItem(item) {
            if (confirm("Are you sure you want to delete this Contact?")) {
                this.loading = true;
                axios
                    .delete(`/sms/${item.id}`)
                    .then(response => {
                        this.getContacts()
                        this.loading = false;
                        this.message = "deleted successifully";
                        this.color = "red";
                        this.snackbar = true;
                        // this.allContacts.splice(index, 1);
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
        close() {
            this.dispAdd = this.dispShow = this.dispEdit = false;
        },
        getContacts() {
            this.loading = true;
            axios
                .get("sms")
                .then(response => {
                    this.allContacts = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
        getContactno() {
            axios.get('/contact_no')
                .then((response) => {
                    this.contact_no = 'CL_' + response.data
                })
        },

        toggleAll() {
            if (this.selected.length) this.selected = []
            else this.selected = this.allContacts.slice()
        },
        changeSort(column) {
            if (this.pagination.sortBy === column) {
                this.pagination.descending = !this.pagination.descending
            } else {
                this.pagination.sortBy = column
                this.pagination.descending = false
            }
        }
    },
    mounted() {
        this.loader = true;
        this.getContacts();
        axios
            .get("companies")
            .then(response => {
                this.loader = false;
                this.allCompanies = response.data;
            })
            .catch(error => {
                this.loader = false;
                this.errors = error.response.data.errors;
            });
    }
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         if (vm.role === 'Admin' || vm.role === 'companyAdmin') {
    //             next();
    //         } else {
    //             next('/');
    //         }
    //     })
    // }
};
</script>
