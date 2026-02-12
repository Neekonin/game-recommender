<template>
  <div class="register-page">
    <div class="register-card">
      <h1 class="title">Criar Conta</h1>
      <p class="subtitle">
        Comece sua jornada e descubra novos mundos
      </p>

      <form @submit.prevent="register">
        <div class="field">
          <label>Nome</label>
          <input v-model="form.name" placeholder="Seu nome" required />
        </div>

        <div class="field">
          <label>Email</label>
          <input v-model="form.email" type="email" placeholder="seu@email.com" required />
        </div>

        <div class="field">
          <label>Senha</label>
          <input v-model="form.password" type="password" placeholder="••••••••" required />
        </div>

        <div class="field">
          <label>Confirmar senha</label>
          <input v-model="form.password_confirmation" type="password" placeholder="••••••••" required />
        </div>

        <button class="register-btn" type="submit">
          Cadastrar
        </button>

        <p class="switch">
          Já tem conta?
          <span @click="$emit('goLogin')">
            Entrar
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
    'registered'
  ],
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      error: null,
    }
  },
  methods: {
    async register() {
      try {
        const res = await api.post('/register', this.form);

        localStorage.setItem('token', res.data.token);
        localStorage.setItem('user', JSON.stringify(res.data.user));

        this.$emit('registered');
      } catch (e) {
        this.error = e.response?.data?.message || 'Erro ao cadastrar';
      }
    },
  },
}
</script>

<style scoped>
.card {
  max-width: 400px;
  margin: auto;
}
.error {
  color: red;
}
</style>
