<template>
  <div class="d-flex justify-center">
    <v-card width="600" class="mt-6 pa-4">
      <v-card-title class="text-center blue-grey--text text--darken-2">
        <v-icon class="mr-1" color="blue-grey darken-2">mdi-login</v-icon>Login
      </v-card-title>
      <v-card-text>
        <v-text-field v-model="user.email" label="Email" color="green accent-2" outlined></v-text-field>
        <v-text-field v-model="user.password" label="Password" color="green accent-2" outlined></v-text-field>
        <v-btn color="green accent-2" class="blue-grey--text text--darken-2" @click="login">Sign in</v-btn>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data(){
    return {
      user: {
        email: '',
        password: ''
      }
    }
  }, 
  methods: {
    login(){
      this.$axios({
        method: 'post',
        url: process.env.backendUrl + '/api/login',
        data: {
          email: this.user.email,
          password: this.user.password,
          device_name: 'web'
        }
      }).then(
        (response)=>{
          this.$store.commit('setToken', response.data.result.token);
          this.$store.commit('setUserData', response.data.result.user);
          this.$router.replace({path: '/dashboard'});
        }
      )
    }
  }
}
</script>