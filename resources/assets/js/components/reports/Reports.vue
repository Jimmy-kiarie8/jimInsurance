<template>
<v-content>
    <div v-show="loader" style="text-align: center">
        <v-progress-circular :width="3" indeterminate color="pink" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-container fluid fill-height>
        <div v-show="!loader" width="100%">
            <v-layout justify-center align-center>
                <v-card style="width 50%;">
                    <v-card-title fixed>
                        <span class="headline">Reports</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-container grid-list-xl fluid>
                                    <v-layout wrap>

                                        <v-flex sm5 offset-sm1>
                                            <v-select :items="items" v-model="select" :hint="`${select.type}}`" label="Select Report" single-line item-text="type" item-value="Rtype" return-object persistent-hint></v-select>
                                        </v-flex>
                                        <v-flex sm5 offset-sm1>
                                            <v-select :items="AllClients" v-model="selectC" label="Select Client" single-line item-text="name" item-value="id" return-object persistent-hint></v-select>
                                        </v-flex>
                                        <v-flex xs5 sm5 offset-sm1>
                                            <v-text-field v-model="form.start_date" label="start date" type="date" color="blue darken-2" required></v-text-field>
                                        </v-flex>
                                        <v-flex xs5 sm5 offset-sm1>
                                            <v-text-field v-model="form.end_date" label="End Date" type="date" color="blue darken-2" required></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat>
                            <v-btn flat type="submit" success color="primary" @click="download">Filter</v-btn>
                            <v-spacer></v-spacer>
                            <download-excel :data="Report">
                                Export
                                <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                            </download-excel>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-layout>
        </div>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            AllClients: [],
            AllDrivers: [],
            form: {
                start_date: '',
                end_date: '',
            },
            AllClients: [],
            selectC: [{
                name: 'All',
                id: 'all',
            }],
            Report: [],
            loader: false,
            loading: false,
            select: [{
                type: 'Premium',
                Rtype: 'premium',
            }, ],
            items: [{
                    type: 'Premium',
                    Rtype: 'premium',
                },
                {
                    type: 'Renewal reminders',
                    Rtype: 'renewal',
                },
                {
                    type: 'Production report',
                    Rtype: 'product',
                },
            ]
        }
    },
    methods: {
        download() {
            axios.post("report", {
                    form: this.form,
                    report: this.select,
                    client: this.selectC,
                })
                .then(response => {
                    this.loading = false;
                    this.Report = response.data;
                })
                .catch(error => {
                    this.loading = false;
                    this.errors = error.response.data.errors;
                });
        }
    },
    mounted() {
        this.loader = true;

        axios.get("getCustomer")
            .then(response => {
                this.loader = false;
                this.AllClients = response.data;
            })
            .catch(error => {
                this.loader = false;
                this.errors = error.response.data.errors;
            });
    }
}
</script>
