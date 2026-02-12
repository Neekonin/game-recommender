<template>
  <div class="login-page">
    <div class="login-card">
      <h1 class="title">Login</h1>
      <p class="subtitle">
        Descubra jogos incríveis feitos para você
      </p>

      <form @submit.prevent="login">
        <div class="field">
          <label>Email</label>
          <input
            type="email"
            v-model="email"
            placeholder="seu@email.com"
            required
          />
        </div>

        <div class="field">
          <label>Senha</label>
          <input
            type="password"
            v-model="password"
            placeholder="••••••••"
            required
          />
        </div>

        <button class="login-btn" :disabled="loading">
          {{ loading ? 'Entrando...' : 'Entrar' }}
        </button>

        <p class="switch">
          Não tem conta?
          <span @click="$emit('goRegister')">
            Criar conta
          </span>
        </p>

        <p v-if="error" class="error">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  emits: [
    'logged',
    'goRegister'
  ],
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      error: null
    };
  },
  methods: {
    async login() {
        this.loading = true;
        this.error = null;

        try {
            const res = await api.post('/login', {
                email: this.email,
                password: this.password
            });

            localStorage.setItem('token', res.data.token);
            localStorage.setItem('user', JSON.stringify(res.data.user));

            this.$emit('logged');
        } catch (e) {
            this.error = 'Email ou senha inválidos';
        } finally {
            this.loading = false;
        }
    }
  }
};
</script>
