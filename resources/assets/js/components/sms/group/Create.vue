<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Group</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm12>
                                        <v-text-field v-model="form.group_name" color="blue darken-2" label="Group name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.group_name">{{ errors.group_name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm12>
                                        <v-text-field v-model="form.description" label="Description" multi-line></v-text-field>
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
            group_name: '',
            description: null,
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
            axios.post('/groups', this.$data.form).
            then((response) => {
                    eventBus.$emit('alertRequest', 'Group Created');
                    eventBus.$emit('refreshGroup');
                    this.loading = false
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
        eventBus.$on('openGroupEvent', data => {
            this.dialog = true
        });
    },
}
</script>
