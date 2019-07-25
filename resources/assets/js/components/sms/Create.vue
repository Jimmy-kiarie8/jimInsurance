<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Contact</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm12>
                                        <v-text-field v-model="form.name" color="blue darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm12>
                                        <v-text-field v-model="form.phone" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                    <div v-show="loader" style="text-align: center; width: 100%;">
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
    data() {
        const defaultForm = Object.freeze({
            name: '',
            phone: null,
        })
        return {
            loading: false,
            dialog: false,
            errors: {},
            defaultForm,
            loader: false,
            form: Object.assign({}, defaultForm),
        }
    },
    methods: {
        save() {
            this.errors = {}
            this.loading = true
            axios.post('/sms', this.$data.form).
            then((response) => {
                    eventBus.$emit('alertRequest');
                    this.loading = false
                    console.log(response);
                    this.$parent.allContacts.push(response.data)
                    // this.close;
                    // this.resetForm();

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
        close() {
            this.dialog = false
        },
    },
    created () {
        eventBus.$on('smsContactEvent', data => {
            this.dialog = true
        });
    },
}
</script>
