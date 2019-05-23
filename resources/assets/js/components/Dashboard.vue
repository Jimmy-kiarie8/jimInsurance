<template>
<v-content>
    <v-container fluid fill-height>
        <v-layout justify-center align-center>
            <v-flex sm12>
                <v-layout wrap>
                    <div class="panel-header panel-header-lg row" style="width: 120% !important">
                        <div class="column">
                            <h3 class="text-center" style="color: #fff;">Policy Chart</h3>
                            <!-- <my-shipment :height="255" :width="1200"></my-shipment> -->
                        </div>
                        <!-- <v-btn @click="ref">Refresh</v-btn> -->
                    </div>
                </v-layout>
                <div class="col-md-12">
                    <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-primary">
                                                <v-icon color="green">local_shipping</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ t_allPolicies }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Today Policies</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="purple">account_circle</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ Allusers }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Users</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-info">
                                                <v-icon color="indigo">map</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ t_certificate_batch }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Today Certificate Batch</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-2">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-danger">
                                                <v-icon color="red">call_split</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ branches_count }}</b></span></h3>
                                            <h6 class="stats-title"><strong> Branches</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->

                <!-- <v-divider></v-divider> -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="chart-area">
                                    <!-- <my-schedule :height="255"></my-schedule> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="chart-area">
                                    <!-- <my-delivered :height="255"></my-delivered> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="chart-area">
                                    <!-- <my-cancled :height="255"></my-cancled> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 40px;">
                    <div class="card card-stats card-raised">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-danger">
                                                <v-icon color="danger">local_shipping</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ t_certificate_batch }}</b></span></h3>
                                            <h6 class="stats-title"><strong> Certificate  Batch</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-primary">
                                                <v-icon color="pink">check_circle</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ allPolicies }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Policies</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-3">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-success">
                                                <v-icon color="orange">cloud</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ allClients }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Clients</strong></h6>
                                        </div>
                                    </div>
                                </div>
                                <v-divider vertical></v-divider>
                                <div class="col-md-2">
                                    <div class="statistics">
                                        <div class="">
                                            <div class="icon icon-info">
                                                <v-icon color="info">block</v-icon>
                                            </div>
                                            <h3 class="info-title"><span><b>{{ Allusers }}</b></span></h3>
                                            <h6 class="stats-title"><strong>Users</strong></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <v-divider></v-divider> -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="chart-area">
                                    <!-- <my-country :height="255"></my-country> -->
                                </div>
                                <!-- <div class="progress-Ship">
                                    <img src="storage/country/ke.png" alt="">
                                    Kenya: {{ parseInt(countryC.Kenya/Allshipments*100) }} %
                                    <v-progress-linear color="secondary" height="2" :value="countryC.Kenya / Allshipments * 100"></v-progress-linear>
                                    <img src="storage/country/tz.png" alt="">
                                    Tanzania: {{ parseInt(countryC.Tanzania/Allshipments*100) }} %
                                    <v-progress-linear color="success" height="2" :value="countryC.Tanzania / Allshipments * 100"></v-progress-linear>
                                    <img src="storage/country/ug.png" alt="">
                                    Uganda: {{ parseInt(countryC.Uganda/Allshipments*100) }} %
                                    <v-progress-linear color="info" height="2" :value="countryC.Uganda / Allshipments * 100"></v-progress-linear>
                                </div> -->
                                <!-- <div class="progress-Ship">
                                    <div v-for="country in countryC" :key="country.id">
                                        {{ country.name }}: {{ parseInt(country.count / Allshipments * 100) }} %
                                        <v-progress-linear color="red" height="2" :value="country.count / Allshipments * 100"></v-progress-linear>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card card-chart">
                            <div class="card-body">
                                <div class="chart-area">
                                    <my-branch :height="255"></my-branch>
                                </div>
                                <div class="progress-Ship">
                                    <div v-for="branch in branchC" :key="branch.id">
                                        {{ branch.name }}: {{ parseInt(branch.count / Allshipments * 100) }} %
                                        <v-progress-linear color="indigo" height="2" :value="branch.count / Allshipments * 100"></v-progress-linear>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- <v-btn @click="getBranchCount" flat color="primary">Count</v-btn> -->
            </v-flex>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    data() {
        return {
            Allusers: null,
            loader: false,
            t_certificate_batch: null,
            policies: null,
            t_policies: null,
            certificate_batch: null,
            allClients: null,
            branches_count: null,
            t_allPolicies: null,
            allPolicies: null,
        }
    },
    mounted() {
        this.loader = true
        axios.get('user_count')
            .then((response) => {
                this.Allusers = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })

        axios.post('client_count')
            .then((response) => {
                this.allClients = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })

        axios.post('policies_count')
            .then((response) => {
                this.allPolicies = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })

        // Dashboard
        axios.post('t_policy_count')
            .then((response) => {
                this.t_allPolicies = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })

        axios.post('t_certificate_batch')
            .then((response) => {
                this.t_certificate_batch = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })
        axios.post('branches_count')
            .then((response) => {
                this.branches_count = response.data
            })
            .catch((error) => {
                this.errors = error.response.data.errors
            })
    }
}
</script>

<style scoped>
.justify-center {
    margin-top: -100px !important;
}

.card-stats {
    margin-top: -10px;
    padding: 20px 0;
}

/* .statistics {
    background: #f0f0f0 !important;
} */

.progress-Ship {
    margin-top: 100px !important;
}

.v-icon {
    font-size: 64px !important;
}

.v-icon {
    box-shadow: 0 9px 30px -6px rgba(255, 54, 54, .5);
    padding: 5px;
    border-radius: 50%;
}

.info-title {
    margin-top: 20px;
}
</style>
