<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      absolute
      temporary
      app
      color="blue-grey darken-4"
      dark
    >
      <v-list class="mt-10">
        <v-list-item v-for="(item, i) in items" :key="i" :to="item.to" router exact>
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title v-text="item.title" />
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      fixed
      app
      class="elevation-2"
      color="blue-grey darken-4 green--text text--accent-2"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" color="green accent-2" />
      <v-toolbar-title v-text="title" />
    </v-app-bar>
    <v-content class="grey lighten-4">
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer fixed app color="black" dark>
      <span>&copy; {{title}} {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: false,
      items: [
        {
          icon: "mdi-home",
          title: "Home",
          to: "/"
        },
        {
          icon: "mdi-link",
          title: "My links",
          to: "/dashboard"
        }
      ],
      miniVariant: false,
      title: "UrlShort"
    };
  }
};
</script>
