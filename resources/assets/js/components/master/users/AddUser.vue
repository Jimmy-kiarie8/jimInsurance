<template>
<v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px" v-if="openAddRequest">
        <v-card>
            <v-card-title fixed>
                <span class="headline">Add User</span>
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
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.name" :rules="rules.name" color="purple darken-2" label="Full name" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.email" :rules="emailRules" color="blue darken-2" label="Email" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.address" :rules="rules.name" color="blue darken-2" label="Address" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.city" :rules="rules.name" color="blue darken-2" label="City" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.city">{{ errors.city[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <v-text-field v-model="form.phone" :rules="rules.name" color="blue darken-2" label="Phone" required></v-text-field>
                                        <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                    </v-flex>
                                    <v-flex xs12 sm6>
                                        <el-select v-model="form.role_id" filterable clearable placeholder="Role">
                                            <el-option v-for="item in AllRoles" :key="item.id" :label="item.name" :value="item.name">
                                            </el-option>
                                        </el-select>
                                    </v-flex>
                                    
                                    <!-- <v-flex xs12 sm6>
                                        <el-select v-model="form.role_id" filterable clearable placeholder="Company">
                                            <el-option v-for="item in allCompanies" :key="item.id" :label="item.company_name" :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </v-flex> -->
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
  props: ["openAddRequest", "allCompanies", "AllRoles"],
  data() {
    const defaultForm = Object.freeze({
      name: "",
      // password: '',
      email: "",
      phone: "",
      branch: "",
      address: "",
      city: ""
      // country: '',
    });
    return {
      loading: false,
      errors: [],
      selected: [],
      company: [],
      defaultForm,
      loader: false,
      e1: true,
      form: Object.assign({}, defaultForm),
      emailRules: [
        v => {
          return !!v || "E-mail is required";
        },
        v =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid"
      ],
      rules: {
        name: [val => (val || "").length > 0 || "This field is required"]
      }
    };
  },
  methods: {
    save() {
      this.loading = true;
      axios
        .post("/users", this.$data.form)
        .then(response => {
          // alert('error1')
          this.loading = false;
          // console.log(response);
          this.$parent.Allusers.push(response.data);
          this.close();
          // this.resetForm();
          this.$emit("alertRequest");
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
      this.$emit("closeRequest");
    }
  },
  mounted() {

  },
  computed: {
    formIsValid() {
      return (
        this.form.name &&
        this.form.email &&
        this.form.phone &&
        // this.form.zipcode &&
        this.form.branch &&
        this.form.address &&
        this.form.city
      );
    }
  },
  mounted() {}
};
</script>
