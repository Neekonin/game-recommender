<template>
  <div class="container">
    <h1>Recomendação de Jogos</h1>

    <!-- LOGIN -->
    <Login
      v-if="screen === 'login'"
      @goRegister="screen = 'register'"
      @logged="onLogged"
    />

    <!-- CADASTRO -->
    <RegisterForm
      v-else-if="screen === 'register'"
      @goLogin="screen = 'login'"
      @registered="onRegistered"
    />

    <!-- APLICAÇÃO -->
    <RecommendationForm v-else />
  </div>
</template>

<script>
import RecommendationForm from './components/RecommendationForm.vue';
import RegisterForm from './components/RegisterForm.vue';
import Login from './components/Login.vue';
import Api from './services/api';

export default {
  components: {
    RecommendationForm,
    RegisterForm,
    Login,
  },

  data() {
    return {
      screen: 'login',
    };
  },

  methods: {
    onLogged() {
      this.screen = 'app';
    },

    onRegistered() {
      this.screen = 'login';
    },
  },

  mounted() {
    const token = localStorage.getItem('token');

    if (!token) {
      this.screen = 'login';
      return;
    }

    Api.get('/user')
      .then(() => {
        this.screen = 'app';
      })
      .catch(() => {
        localStorage.clear();
        this.screen = 'login';
      });
  },
};
</script>
