<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px" v-if="dialog">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add Policy Type</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap v-show="!loader">
                        <v-form ref="form" @submit.prevent>
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                    <v-flex xs12 sm12>
                                        <v-text-field v-model="form.code" color="purple darken-2" label="Code" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.code">{{ errors.code[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm12>
                                        <v-textarea v-model="form.description" color="blue">
                                            <div slot="label">
                                                Display content
                                            </div>
                                        </v-textarea>
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
      code: "",
      coverage: ""
    });
    return {
      loading: false,
      errors: [],
      selected: [],
      dialog: false,
      defaultForm,
      loader: false,
      e1: true,
      form: Object.assign({}, defaultForm),
      rules: {
        name: [val => (val || "").length > 0 || "This field is required"]
      }
    };
  },
  methods: {
    save() {
      this.loading = true;
      axios
        .post("/insuracetype", this.$data.form)
        .then(response => {
          // alert('error1')
          this.loading = false;
          // console.log(response);
          this.$parent.AllTypes.push(response.data);
          this.close();
          // this.resetForm();
          eventBus.$emit("alertEvent", "success");
        })
        .catch(error => {
          // alert('error2')
          this.loading = false;
          if (error.response.status === 500) {
            eventBus.$emit("errorEvent", error.response.statusText);
            return;
          }
          this.errors = error.response.data.errors;
          console.log(error);
          this.errors = error.response.data.errors;
        });
    },
    resetForm() {
      this.form = Object.assign({}, this.defaultForm);
      this.$refs.form.reset();
    },
    close() {
      this.dialog = false;
    }
  },
  created() {
    eventBus.$on("openaddTypeEvent", data => {
      this.dialog = true;
    });
  },
  mounted() {}
};
</script>
