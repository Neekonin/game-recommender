<template>
  <form @submit.prevent="register" class="card">
    <h2>Criar conta</h2>

    <input v-model="form.name" placeholder="Nome" required />
    <input v-model="form.email" type="email" placeholder="Email" required />
    <input v-model="form.password" type="password" placeholder="Senha" required />
    <input v-model="form.password_confirmation" type="password" placeholder="Confirmar senha" required />

    <button type="submit">Cadastrar</button>
    <p class="switch">
        Já tem conta?
      <span @click="$emit('goLogin')">
        Entrar
      </span>
    </p>

    <p v-if="error" class="error">{{ error }}</p>
  </form>
</template>

<script>
import axios from 'axios'

export default {
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
