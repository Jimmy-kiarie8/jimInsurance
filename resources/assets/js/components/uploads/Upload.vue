<template>
<v-dialog v-model="dialog" persistent width="400px">
    <v-card style="overflow-x: hidden;">
        <v-card-title>
            Upload Contacts
        </v-card-title>
        <v-container grid-list-md>
            <v-card-text>
                <v-layout wrap>
                    <form action="/importContacts" method="post" enctype="multipart/form-data" style="width: 100%;">
                        <input type="hidden" name="_token" :value="csrf">
                        <v-btn color="red" darken-1 raised @click="onPickFile" style="color: #fff;">
                            Choose File<v-icon right dark>cloud_upload</v-icon>
                        </v-btn>
                        <input type="file" name="contacts" id="csv" ref="fileInput" style="display: none">
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-btn flat @click="close">Close</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn flat type="submit" color="primary">Upload Contacts</v-btn>
                        </v-card-actions>
                    </form>
                </v-layout>
            </v-card-text>
        </v-container>
    </v-card>
</v-dialog>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            imagePlaced: false,
            dialog: false,
            groups: {},
            form: {},
        }
    },
    methods: {
        onPickFile() {
            this.$refs.fileInput.click()
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
        eventBus.$on('openUploadEvent', data => {
            this.dialog = true
        })
    },
    mounted() {
        this.getGroups();
    },
}
</script>
