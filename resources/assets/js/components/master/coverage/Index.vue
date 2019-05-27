<template>
<div>
    <v-content>
        <v-container fluid fill-height v-show="!loader">
            <v-layout justify-center align-center>
                <div> 
                    <v-card>
                   
                    <!-- users display -->
                    <v-card-title>
                        Coverages
                        <!-- <download-excel :data="AllCoverages" :fields="json_fields">
                            Export
                            <img src="/storage/csv.png" style="width: 30px; height: 30px; cursor: pointer;">
                        </download-excel> -->
                            <v-btn slot="activator" color="primary" dark flat @click="openAdd">Add Coverage</v-btn>
                            <v-tooltip right>
                                <v-btn icon slot="activator" class="mx-0" @click="getCoverages">
                                    <v-icon color="blue darken-2" small>refresh</v-icon>
                                </v-btn>
                                <span>Refresh</span>
                            </v-tooltip>
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" append-icon="search" label="Search" single-line></v-text-field>
                    </v-card-title>
                    <v-data-table :headers="headers" :items="AllCoverages" class="elevation-1" :loading="loading" :search="search">
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.code }}</td>
                            <td class="text-xs-right">{{ props.item.description }}</td>
                            <td class="text-xs-right">{{ props.item.created_at }}</td>
                            <td class="justify-center layout px-0">
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="openEdit(props.item)" slot="activator">
                                        <v-icon small color="blue darken-2">edit</v-icon>
                                    </v-btn>
                                    <span>Edit</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <v-btn icon class="mx-0" @click="deleteItem(props.item)" slot="activator">
                                        <v-icon small color="pink darken-2">delete</v-icon>
                                    </v-btn>
                                    <span>Delete</span>
                                </v-tooltip>
                            </td>
                        </template>
                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                            Your search for "{{ search }}" found no results.
                        </v-alert>
                    </v-data-table>
                    <!-- users display -->
                    </v-card>
                </div>
            </v-layout>
        </v-container>
        <div v-show="loader" style="text-align: center; width: 100%;">
            <v-progress-circular :width="3" indeterminate color="blue" style="margin: 1rem"></v-progress-circular>
        </div>
        <v-snackbar :timeout="timeout" :bottom="y === 'bottom'" :color="color" :left="x === 'left'" v-model="snackbar">
            {{ message }}
            <v-icon dark right>check_circle</v-icon>
        </v-snackbar>
    </v-content>
    <Create></Create> 
    <Edit></Edit>
</div>
</template>

<script>
import Create from "./Create.vue";
// import Deleted from "./Deleted.vue";
import Edit from "./Edit.vue";
// import Show from "./Show.vue";
export default {
  props: ["user"],
  components: {
    Create,
    Edit
  },
  data() {
    return {
      AllShips: [],
      permEdit: false,
      Allcountries: [],
      select: {
        state: "All",
        abbr: "all"
      },
      headers: [
        {
          text: "Code",
          value: "code"
        },
        {
          text: "Description",
          value: "description"
        },
        {
          text: "Created On",
          value: "created_at"
        },
        {
          text: "Actions",
          value: "name",
          sortable: false
        }
      ],
      json_fields: {
        Name: "name",
        Email: "email",
        Phone: "phone",
        City: "city",
        Address: "address",
        Country: "country"
      },
      search: "",
      loader: false,
      snackbar: false,
      loading: false,
      timeout: 5000,
      color: "black",
      message: "Success",
      y: "bottom",
      x: "left",
      AllCoverages: [],
      editedItem: {}
    };
  },
  methods: {
    openDeleted() {
      eventBus.$emit("openDeletedEvent");
    },
    openAdd() {
      // alert('test')
      eventBus.$emit("openaddCoverageEvent");
      // this.dispAdd = true;
    },
    openEdit(item) {
      eventBus.$emit("openEditCoverageEvent", item);
    },
    showAlert() {
      this.message = "Successifully Added";
      this.snackbar = true;
      this.color = "black";
    },
    deleteItem(item) {
      if (confirm("Are you sure you want to delete this item?")) {
        this.loading = true;
        const index = this.AllCoverages.indexOf(item);
        axios
          .delete(`/coverage/${item.id}`)
          .then(response => {
            this.AllCoverages.splice(index, 1);
            eventBus.$emit("alertRequest", this.editedItem);
            this.loading = false;
            this.message = "deleted successifully";
            this.color = "red";
            this.snackbar = true;
            this.AllCoverages.splice(index, 1);
          })
          .catch(error => {
            this.loading = false;
            this.errors = error.response.data.errors;
            this.message = "something went wrong";
            this.color = "red";
            this.snackbar = true;
          });
      }
    },
    getCoverages() {
      this.loading = true;
      axios
        .get("/coverage")
        .then(response => {
          this.loading = false;
          this.loader = false;
          this.AllCoverages = response.data;
        })
        .catch(error => {
          this.loading = false;
          this.loader = false;
          this.errors = error.response.data.errors;
        });
    }
  },
  mounted() {
    this.loader = true;
    this.getCoverages();
  },
  // beforeRouteEnter(to, from, next) {
  //     next(vm => {
  //         if (vm.user.can["view users"]) {
  //             next();
  //         } else {
  //             next("/unauthorized");
  //         }
  //     });
  // },

  created() {
    eventBus.$on("userEvent", data => {
      this.getCoverages();
    });
  }
};
</script>

<style scoped>
.content--wrap {
  margin-top: -100px;
}

#profile {
  width: 70px;
  height: 60px;
  border-radius: 50%;
  margin-left: 80px;
  margin-top: -30px;
}

i {
  padding: 7px;
  background: #f0f0f0;
  border-radius: 50%;
}

.list-group-item:hover,
.list-group-item:focus {
  z-index: 1;
  background: #f9f9f9;
  text-decoration: none;
}
</style>
