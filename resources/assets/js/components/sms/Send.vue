<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Send Sms</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                        <v-container grid-list-xl fluid>
                            <v-text-field v-model="form.message" label="Message" multi-line></v-text-field>
                        </v-container>
                        <v-card-actions>
                            <v-btn flat @click="resetForm">reset</v-btn>
                            <v-btn flat @click="close">Close</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn :disabled="loading" flat color="primary" @click="save" :loading="loading">Submit</v-btn>
                        </v-card-actions>
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
            message: '',
            selected: []
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
            axios.post('/sendSms', this.$data.form).
            then((response) => {
                    this.loading = false
                    console.log(response);
                    // this.close();
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
    created() {
        eventBus.$on('sendSmsEvent', data => {
            this.dialog = true
            this.form.selected = data
        });
    },
}
</script>
