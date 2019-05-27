<template>
<v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="400px">
        <v-card>
            <v-card-title fixed>
                <span type="headline">Add User</span>
                <v-spacer></v-spacer>
                <v-btn icon dark @click="close">
                    <v-icon color="black">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-form ref="form" @submit.prevent="submit">
                            <v-container grid-list-xl fluid>
                                <v-layout wrap>
                                     <v-flex xs12 sm2>
                                        <v-text-field v-model="type.code" color="blue darken-2" label="Code" required></v-text-field>
                                        <!-- <small type="has-text-danger" v-if="errors.code">{{ errors.code[0] }}</small> -->
                                    </v-flex>
                                    <v-flex xs12 sm12>
                                        <v-textarea v-model="type.description" color="blue">
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
      dialog: false,
      loading: false,
      type: [],
    };
  },
  methods: {
    update() {
      this.loading = true;
      axios
        .patch(`/insuracetype/${this.form.id}`, {
          form: this.form,
          selected: this.selected
        })
        .then(response => {
          // console.log(response);
          this.loading = false;
          this.$emit("alertRequest");
          this.close();
          Object.assign(
            this.$parent.Allusers[this.$parent.editedIndex],
            this.$parent.editedItem
          );
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.loading = false;
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
    eventBus.$on("openEditTypeEvent", data => {
      this.dialog = true;
      this.type = data;
    });
  }
};
</script>
