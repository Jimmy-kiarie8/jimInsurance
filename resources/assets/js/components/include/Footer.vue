<template>
<v-content>
    <v-container fluid fill-height v-show="!loader">
        <v-layout justify-center align-center>
            <v-footer dark height="auto" style="position: fixed;">
                <v-card class="flex" flat tile>
                    <!-- <v-card-title class="white">
                        <strong class="subheading" style="color: #000">With you at every turn</strong>
                        <v-spacer></v-spacer>
                        <v-btn v-for="icon in icons" :key="icon" class="mx-3" dark icon>
                            <v-icon size="24px">{{ icon }}</v-icon>
                        </v-btn>
                    </v-card-title> -->

                    <v-card-actions class="grey darken-3 justify-center">
                        &copy;{{ new Date().getFullYear() }} — <strong>Powered by Hills Data Technologies. Kenya</strong>
                    </v-card-actions>
                </v-card>
            </v-footer>
        </v-layout>
    </v-container>
</v-content>
</template>

<script>
export default {
    data: () => ({
        icons: [
            'fab fa-facebook',
            'fab fa-twitter',
            'fab fa-google-plus',
            'fab fa-linkedin',
            'fab fa-instagram'
        ]
    })
}
</script>
