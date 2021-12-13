import Vue from "vue";
import { authenticated } from "../util";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
//import About from "../views/About.vue";

Vue.use(VueRouter);
const checkAuth = async (to, from, next) => {
  try {
    console.log("IN INDEX.JS")
    if (await authenticated()) next()
    else next({
      path: '/login',
      replace: true
    })
  } catch (error) {
    console.error(error.message)
    next({
      path: '/login',
      replace: true
    })
  }
}


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    beforeEnter: checkAuth,
    props: true
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: "/about",
    name: "About",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/About.vue"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
