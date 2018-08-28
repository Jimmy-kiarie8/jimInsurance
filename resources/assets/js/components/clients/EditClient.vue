<template>
<v-layout row justify-center>
    <v-dialog v-model="openEditRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.client_no" :rules="rules.name" color="blue darken-2" label="Client Number" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.client_no">{{ errors.client_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.pin_no" :rules="rules.name" color="blue darken-2" label="Client Pin" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.pin_no">{{ errors.pin_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" :rules="rules.name" color="blue darken-2" label="Full name" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.birth_day" :rules="rules.name" type="date" color="blue darken-2" label="birth_day" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.birth_day">{{ errors.birth_day[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" :rules="rules.name" color="blue darken-2" label="Phone" required></v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small> -->
                                    </v-flex>

                                </v-layout>
                            </v-container>
                            <v-card-actions>
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
    props: ['openEditRequest', 'form', 'AllBranches'],
    data() {
        return {
            e1: true,
            loader: false,
            loading: false,
            list: {},
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
            axios.patch(`/clients/${this.form.id}`, this.form).
            then((response) => {
                    console.log(response);
                    this.loading = false
                    // this.close;
                    this.$emit('alertRequest');
                    Object.assign(this.$parent.AllClients[this.$parent.editedIndex], this.$parent.editedItem)

                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        close() {
            this.$emit('closeRequest')
        },
    },
}
</script>
