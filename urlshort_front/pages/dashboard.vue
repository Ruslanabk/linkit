<template>
  <div class="blue-grey--text text--darken-3">
    <h1 class="my-6">Мои ссылки</h1>

    <v-row>
      <v-col cols="12" sm="12" md="9">
        <v-row>
          <v-col
            v-for="(link, i) in $store.state.links"
            :key="i"
            cols="12"
            sm="6"
            md="12"
            lg="4"
            xl="3"
          >
            <v-card color="green lighten-5" tile class="green--text text--darken-1">
              <v-card-title>{{link.route}}</v-card-title>
              <v-card-text>{{link.description}}</v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  :href="`${process.env.backendUrl}/${$store.state.user.username}/${link.route}`"
                  target="_blank"
                  rel="noopener noreferrer"
                  color="green"
                  outlined
                >Open link</v-btn>
                <v-btn color="red" outlined @click="delLink(link.id)">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" sm="12" md="3">
        <v-card tile>
          <v-card-title>Добавить ссылку</v-card-title>
          <v-card-text>
            <v-text-field
              v-model="newLink.route"
              dense
              label="Title"
              outlined
              color="green accent-2"
            ></v-text-field>
            <v-text-field v-model="newLink.url" dense label="Url" outlined color="green accent-2"></v-text-field>
            <v-text-field
              v-model="newLink.description"
              dense
              label="Description"
              outlined
              color="green accent-2"
            ></v-text-field>
            <v-btn color="green accent-2" class="blue-grey--text text--darken-2" @click="addLink">
              <v-icon>mdi-plus</v-icon>Save link
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  middleware: "authenticated",
  data() {
    return {
      addLinkPanel: false,
      newLink: {
        route: "",
        url: "",
        description: ""
      }
    };
  },
  methods: {
    getLinks() {
      this.$axios({
        method: "get",
        url: process.env.backendUrl + "/api/links",
        headers: { Authorization: "Bearer " + this.$store.state.token }
      }).then(response => {
        this.$store.commit("setLinks", response.data.result);
      });
    },
    addLink() {
      this.$axios({
        method: "post",
        url: process.env.backendUrl + "/api/links",
        headers: { Authorization: "Bearer " + this.$store.state.token },
        data: this.newLink
      }).then(response => {
        this.newLink = {};
        this.getLinks();
      });
    },
    delLink(id) {
      this.$axios({
        method: "delete",
        url: process.env.backendUrl + "/api/links/" + id,
        headers: { Authorization: "Bearer " + this.$store.state.token }
      }).then(response => {
        if (response.data.status == "success") {
          let links = this.$store.state.links;
          for (let i in links) {
            if (links[i].id == id) {
              links.splice(i, 1);
            }
          }
          this.$store.state.commit("setLinks", links);
        }
      });
    }
  },
  mounted() {
    this.getLinks();
  }
};
</script>