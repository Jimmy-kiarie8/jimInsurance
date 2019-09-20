<template>
<div>
    <v-app id="inspire">
        <!-- temporary -->
        <v-navigation-drawer right temporary v-model="right" fixed>
        </v-navigation-drawer>
        <!-- temporary -->
        <v-navigation-drawer fixed :color="color" :clipped="$vuetify.breakpoint.lgAndUp" app v-model="drawer">
            <v-list dense>
                <template>
                    <v-list-group append-icon="" style="background:#f0f0f0">
                        <v-list-tile slot="activator" style="background:#f5f5f5; padding: 0 0 40px 0; margin-top: 10px; padding: 30px 0 0 0;">
                        </v-list-tile>
                    </v-list-group>
                    <v-divider></v-divider>
                    <v-card>
                        <!-- <router-link to="/" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">home</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Dashboard
                                </div>
                            </div>
                        </router-link> -->
                        <!-- <router-link to="/certificates" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">book</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Manage Certificates
                                </div>
                            </div>
                        </router-link> -->
                        <router-link to="/companyprofile" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">account_circle</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Company Profile
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/clients" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">email</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Clients
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">home</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Policies
                                </div>
                            </div>
                        </router-link>
                        <router-link to="/reports" class="v-list__tile v-list__tile--link">
                            <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">book</i></div>
                            <div class="v-list__tile__content">
                                <div class="v-list__tile__title">
                                    Reports
                                </div>
                            </div>
                        </router-link>

                        <v-list-group prepend-icon="people_outline">
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Master Records</v-list-tile-title>
                            </v-list-tile>

                            <router-link to="/company" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">business</i></div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">
                                        Insurance Company
                                    </div>
                                </div>
                            </router-link>
                            <router-link to="/classes" class="v-list__tile theme--light" style="text-decoration: none" id="link-router">
                                <v-list-tile-action>
                                    <v-icon>people_outline</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Insurance classes </v-list-tile-title>
                            </router-link>
                            <!-- <router-link to="/inspolicy" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>book</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Policy status </v-list-tile-title>
                            </router-link>
                            <router-link to="/types" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>history</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Policy types </v-list-tile-title>
                            </router-link>
                            <router-link to="/coverage" class="v-list__tile theme--light" style="text-decoration: none">
                                <v-list-tile-action>
                                    <v-icon>gavel</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-title>Policy coverage </v-list-tile-title>
                            </router-link> -->
                            <router-link to="/sms" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">gavel</i></div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">
                                        Sms Contacts
                                    </div>
                                </div>
                            </router-link>
                            <router-link to="/groups" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">email</i></div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">
                                        Sms Groups
                                    </div>
                                </div>
                            </router-link>
                            <router-link to="/users" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">account_circle</i></div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">
                                        Manage Users
                                    </div>
                                </div>
                            </router-link>
                            <router-link to="/roles" class="v-list__tile v-list__tile--link">
                                <div class="v-list__tile__action"><i aria-hidden="true" style="color: rgb(28, 35, 79)" class="icon material-icons">account_circle</i></div>
                                <div class="v-list__tile__content">
                                    <div class="v-list__tile__title">
                                        Manage Roles
                                    </div>
                                </div>
                            </router-link>
                        </v-list-group>
                    </v-card>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar dark app :color="color" :clipped-left="$vuetify.breakpoint.lgAndUp" fixed>
            <v-toolbar-title style="width: 700px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                {{ company.company_name }}
                <img :src="company.logo" alt="" style="width: 60px; height: 60px; border-radius: 50%;">
            </v-toolbar-title>
                <v-spacer></v-spacer>
                <!-- <v-icon @click.stop="right = !right" style="cursor: pointer">apps</v-icon> -->
            <Logout :user="user"></Logout>
                <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
        </v-toolbar>

        <v-snackbar :timeout="timeout" bottom="bottom" :color="color" left="left" v-model="snackbar">
            {{ message }}
            <v-icon dark right>check_circle</v-icon>
        </v-snackbar>
    </v-app>
</div>
</template>

<script>
import Logout from "./Logout";
export default {
    props: ['user', 'logo'],
    components: {
        Logout
    },
    data() {
        return {
            snackbar: false,
            timeout: 4000,
            color: "black",
            message: "Success",
            sheet: false,
            color: 'rgb(25, 117, 210)',
            dialog: false,
            changeColor: 'item.color',
            drawer: true,
            drawerRight: false,
            right: null,
            menu: false,
            mode: '',
            company: {},
        }
    },
    methods: {
        showSnackbar(data) {
            this.snackbar = true
            this.message = data
        }
    },
    created () {
        eventBus.$on('alertRequest', data => {
            this.showSnackbar(data)
        });
    },
    mounted() {
        axios.post('getLogo')
            .then((response) => {
                this.company = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })
    },
}
</script>
