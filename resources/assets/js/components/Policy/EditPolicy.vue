<template>
<v-layout row justify-center>
    <v-dialog v-model="openEditRequest" persistent max-width="700px">
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
                                        <v-text-field v-model="Editdata.file_no" :rules="rules.name" color="blue darken-2" label="Branch name" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.file_no">{{ errors.file_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="Editdata.policy_no" :rules="rules.name" color="blue darken-2" label="Branch policy_no" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.policy_no">{{ errors.policy_no[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="Editdata.premium" color="blue darken-2" label="Premium" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.premium">{{ errors.premium[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="Editdata.commission " :rules="rules.name" color="blue darken-2" label="Commission" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="Editdata.effective_date" type="date" color="blue darken-2" label="Effective Date" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="Editdata.exp_date " type="date" color="blue darken-2" label="Expiry Date" required>
                                        </v-text-field>
                                        <!-- <small class="has-text-danger" v-if="errors.commission">{{ errors.commission[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                    <v-select :items="InsClass" v-model="selectClass" :hint="`${selectClass.title}, ${selectClass.id}`" label="Insurance Class" single-line item-text="title" item-value="id" return-object persistent-hint></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                    <v-select :items="InsType" v-model="selectType" :hint="`${selectType.title}, ${selectType.id}`" label="Insurance Type" single-line item-text="title" item-value="id" return-object persistent-hint></v-select>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                    <v-select :items="PolicyStatus" v-model="selectPolicy" :hint="`${selectPolicy.title}, ${selectPolicy.id}`" label="Policy Status" single-line item-text="title" item-value="id" return-object persistent-hint></v-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-card-actions>
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" :loading="loading" flat color="primary" @click="update">Submit</v-btn>
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
    props: ['openEditRequest', 'Editdata'],
    data() {
        return {
            selectClass: [],
            selectType: [],
            selectPolicy: [],
            InsClass: [],
            InsType: [],
            PolicyStatus: [],
            PolicyStatus: [],
            rules: {
                name: [val => (val || '').length > 0 || 'This field is required']
            },
            loading: false
        }
    },
    methods: {
        update() {
          this.loading=true
            axios.patch(`/policy/${this.Editdata.id}`, this.Editdata).
            then((response) => {
                  this.loading=false
                    // console.log(response);
                    this.$emit('alertRequest');
                    this.$emit('closeRequest');
                    Object.assign(this.$parent.AllPolicies[this.$parent.editedIndex], this.$parent.editedItem)

                })
                .catch((error) => {
                  this.loading=false
                  this.errors = error.response.data.errors
                  })
        },
        close() {
            this.$emit('closeRequest')
        },
    },
    mounted() {
        axios.get('/getinsuranceType')
            .then((response) => {
                this.InsType = response.data
            })

        axios.get('/getinsuranceClass')
            .then((response) => {
                this.InsClass = response.data
            })

        axios.get('/getStatus')
            .then((response) => {
                this.PolicyStatus = response.data
            })
    }
}
</script>
