<template>
<v-layout row justify-center>
    <v-dialog v-model="openPrintRequest" persistent max-width="1200px">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Certificate Print</span>
            </v-card-title>
            <v-card-text id="printMe">
                <v-container grid-list-md>
                    <table>
                        <!-- <thead>
                            <th style="padding: 0 90px;">qwerty</th>
                            <th style="padding: 0 90px;">qwerty</th>
                            <th style="padding: 0 90px;">qwerty</th>
                            <th style="padding: 0 90px;">qwerty</th>
                        </thead> -->
                        <tbody>
                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.client }}</td>
                                <td style="padding: 0 90px;">{{ printData.client }}</td>
                                <td style="padding: 0 90px;">{{ printData.client }}</td>
                            </tr>

                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.insured }}</td>
                                <td style="padding: 0 90px;">{{ printData.insured }}</td>
                                <td style="padding: 0 90px;">{{ printData.insured }}</td>
                            </tr>

                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.policy_no }}</td>
                                <td style="padding: 0 90px;">{{ printData.policy_no }}</td>
                                <td style="padding: 0 90px;">{{ printData.policy_no }}</td>
                            </tr>

                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.effective_date }}</td>
                                <td style="padding: 0 90px;">{{ printData.effective_date }}</td>
                                <td style="padding: 0 90px;">{{ printData.effective_date }}</td>
                            </tr>

                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.exp_date }}</td>
                                <td style="padding: 0 90px;">{{ printData.exp_date }}</td>
                                <td style="padding: 0 90px;">{{ printData.exp_date }}</td>
                            </tr>

                            <tr style="font-size: 20px;">
                                <td style="padding: 0 90px;">{{ printData.file_no }}</td>
                                <td style="padding: 0 90px;">{{ printData.file_no }}</td>
                                <td style="padding: 0 90px;">{{ printData.file_no }}</td>
                            </tr>
                        </tbody>
                    </table>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn flat @click="close">Close</v-btn>
                <v-btn flat @click="pdf">Pdf</v-btn>
                <v-spacer></v-spacer>
                <v-btn v-print="'#printMe'" flat color="primary">Print</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</v-layout>
</template>

<script>
export default {
    props: ['openPrintRequest', 'printData'],
    data: {
        // pdf: [],
    },
    methods: {
        pdf() {
        axios.get('getCertificates')
            .then((response) => {
                this.AllCertificates = response.data
                this.loader = false
            })
            .catch((error) => {
                this.errors = error.response.data.errors
                this.loader = false
            })
        },
        close() {
            this.$emit('closeRequest')
        }
    },
    mounted() {
        axios.get('getCertificates')
            .then((response) => {
                this.AllCertificates = response.data
                this.loader = false
            })
            .catch((error) => {
                this.errors = error.response.data.errors
                this.loader = false
            })
    },
}
</script>
