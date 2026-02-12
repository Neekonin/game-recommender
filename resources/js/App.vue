<template>
<div class="app-bg">
  <div
      :class="[
        'app-wrapper',
        screen === 'app' ? 'app-layout' : 'auth-layout'
      ]"
    >
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
      <RecommendationForm 
        v-else-if="screen === 'app'"
        @recommendationsShowed="onRecommendationsShowed"
        @logout="onLogout"
      />

      <RecommendationsModal
        v-if="showModal"
        :games="games"
        @close="showModal = false"
      />
    </div>
  </div>
</template>

<script>
import Login from './components/Login.vue';
import RegisterForm from './components/RegisterForm.vue';
import RecommendationForm from './components/RecommendationForm.vue';
import RecommendationsModal from './components/RecommendationsModal.vue';
import api from './services/api';

export default {
  components: {
    Login,
    RegisterForm,
    RecommendationForm,
    RecommendationsModal,
  },

  data() {
    return {
      screen: 'login',
      showModal: false,
      games: [],
    };
  },

  methods: {
    onLogged() {
      this.screen = 'app';
    },

    onLogout() {
      this.screen = 'login';
    },

    onRegistered() {
      this.screen = 'login';
    },

    onRecommendationsShowed(games) {
      this.games = games;
      this.showModal = true;
    },
  },

  mounted() {
    const token = localStorage.getItem('token');

    if (!token) {
      this.screen = 'login';
      return;
    }

    api.get('/user')
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
