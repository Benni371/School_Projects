<template>
  <v-app>
    <!-- Link to Material Icons-->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"
      rel="stylesheet"
      type="text/css"
    />
    
    <app-bar :user="user"></app-bar>

    <v-main>
      <router-view :user="user"></router-view>
    </v-main>

  </v-app>
</template>

<script>
import AppBar from '@/components/AppBar.vue'


export default {
  name: 'App',
  components: {
    AppBar
  
  },
  asyncComputed: {
    user: {
      async get() {
         fetch(
      
        `${process.env.VUE_APP_API_ORIGIN}/api/v1/user`,
        
        {
          method: `GET`,
          credentials: `include`,
        }
   
      ).then(function(response){
        
        if (response.ok) {
       
        
          return response.json()
        }
      }).then((data) => {
  
        this.user = data
      })
      },
      default: {
      
        UserName: ''
      }
    }
  }
}
</script>
