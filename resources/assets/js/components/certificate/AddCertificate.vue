<template>
<v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Branch</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.serial_from" color="blue darken-2" label="Serial From" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.serial_from">{{ errors.serial_from[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.serial_to" color="blue darken-2" label="Serial To" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.serial_to">{{ errors.serial_to[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field disabled v-model="user.name" color="blue darken-2" label="UnderWritter name" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.underwriter">{{ errors.underwriter[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field disabled v-model="totalCerts" color="blue darken-2" label="Total Certificates" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="resetForm">reset</v-btn>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" :loading="loading" flat color="primary" @click="save">Submit</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-layout>
                </v-container>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openAddRequest', 'user'],
    data() {
        const defaultForm = Object.freeze({
            serial_from: 0,
            serial_to: 0,
            // total: '',
        })
        return {
            errors: {},
            loading: false,
            defaultForm,
            form: Object.assign({}, defaultForm),
            rules: {
                name: [val => (val || '').length > 0 || 'This field is required']
            },
        }
    },
    methods: {
        save() {
            this.loading = true
            axios.post('/certificates', this.$data.form).
            then((response) => {
                    this.loading = false
                    console.log(response);
                    this.$parent.AllCertificates.push(response.data)
                    this.close;
                    // this.resetForm();
                    // this.$emit('closeRequest');
                    this.$emit('alertRequest');

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
        alert() {
            this.$emit('alertRequest')
        },
        close() {
            this.$emit('closeRequest')
        },
    },
    computed: {
        formIsValid() {
            return (
                this.form.serial_from &&
                this.form.serial_to 
            )
        },
  
      totalCerts: function() {
  
        return parseFloat(this.form.serial_to) - parseFloat(this.form.serial_from)+parseFloat(1);
  
      },
    },
    mounted() {

    }
}
</script>
