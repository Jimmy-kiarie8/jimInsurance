<template>
<v-layout row justify-center>
    <v-dialog v-model="openEditRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" :rules="rules.name" color="purple darken-2" label="Full name" required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" :rules="rules.name" color="blue darken-2" label="Address" required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.city" :rules="rules.name" color="blue darken-2" label="City" required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" :rules="rules.name" color="blue darken-2" label="Phone" required></v-text-field>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.name" filterable clearable placeholder="Role" v-for="roles in form.roles" :key="roles.id">
                                            <el-option v-for="item in AllRoles" :key="item.id" :label="item.name" :value="roles.name">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="update" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                    <div v-show="loader" style="text-align: center">
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
    props: ['openEditRequest', 'form', 'AllBranches', 'AllRoles', 'countryList'],
    data() {
        return {
            e1: true,
            loader: false,
            loading: false,
            list: {},
            selected: [],
            permissions: [],
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
        update() {
            this.loading = true
            axios.patch(`/users/${this.form.id}`, {
                form: this.form,
                selected: this.selected
            }).
            then((response) => {
                    // console.log(response);
                    this.loading = false
                    this.$emit('alertRequest');
                    this.close();
                    Object.assign(this.$parent.Allusers[this.$parent.editedIndex], this.$parent.editedItem)
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                    this.loading = false
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
    created() {
        eventBus.$on('permEvent', data => {
            this.selected = data;
        });
    },
    computed: {
        formIsValid() {
            return (
                this.form.name &&
                this.form.email &&
                this.form.phone &&
                this.form.password &&
                this.form.branch &&
                this.form.address &&
                this.form.city &&
                this.form.country
            )
        },
    },
    mounted() {

        axios.get('/getPermissions')
            .then((response) => {
                this.permissions = response.data
            })
            .catch((errors) => {
                this.errors = error.response.data.errors
            })
    }
}
</script>
