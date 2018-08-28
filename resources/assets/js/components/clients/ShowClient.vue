<template>
<v-layout row justify-center>
    <v-dialog v-model="openShowRequest" persistent max-width="700px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">{{list.name}}' Details</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <div class="col-md-12 col-sm-12">
                        <ul class="list-group">
                            <li class="list-group-item row active">
                                <label class="col-md-5 col-lg-5"><b>Name</b></label> {{ showData.name }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>Email</b></label> {{ showData.email }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>Client Number</b></label> {{ showData.client_no }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>Pin Number</b></label> {{ showData.pin_no }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>Phone Number</b></label> {{ showData.phone }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>BirthDay</b></label> {{ showData.birth_day }}
                            </li>
                            <li class="list-group-item row">
                                <label class="col-md-5 col-lg-5"><b>Created On</b></label> {{ showData.created_at }}
                            </li>
                        </ul>
                    </div>
                </v-container>
            </v-card-text>
            <v-btn flat @click="close">Close</v-btn>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openShowRequest', 'showData'],
    data() {
        return {
            list: {}
        }
    },
    methods: {
        close() {
            this.$emit('closeRequest')
        },
    },
    mounted() {

    }
}
</script>
