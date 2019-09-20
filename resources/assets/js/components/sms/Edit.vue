<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm12>
                                        <label for="">Group</label>
                                        <el-select v-model="form.group_id" clearable placeholder="Select Group">
                                            <el-option v-for="item in groups" :key="item.id" :label="item.group_name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
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
                                <v-btn flat @click="close">Close</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn :disabled="loading" flat color="primary" @click="update" :loading="loading">Submit</v-btn>
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
    data() {
        return {
            e1: true,
            dialog: false,
            loading: false,
            errors: {},
            groups: {},
            form: {},
        }
    },
    methods: {
        update() {
            this.loading = true
            axios.patch(`/sms/${this.form.id}`, this.form).
            then((response) => {
                    eventBus.$emit('refreshContact');
                    // console.log(response);
                    this.loading = false
                    this.close();
                })
                .catch((error) => {
                    this.loading = false
                    this.errors = error.response.data.errors
                })
        },
        close() {
            this.dialog = false
        },
        getGroups() {
            this.loading = true;
            axios
                .get("groups")
                .then(response => {
                    this.groups = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        },
    },
    created() {
        eventBus.$on('smsUpdateContactEvent', data => {
            this.dialog = true
            this.form = data
        });
    },
    mounted () {
        this.getGroups();
    },
}
</script>
