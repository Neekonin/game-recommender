<template>
  <header class="navbar">
    <div class="nav-left">
      <h1 class="logo">Encontre seus jogos</h1>
    </div>

    <div class="nav-right">

      <button class="favorites-btn" @click="openFavorites">
        ❤️ Favoritos
      </button>

      <div class="profile-wrapper">
        <button class="profile-btn" @click="toggleProfile">
          👤 Perfil
        </button>

        <div v-if="showProfile" class="profile-dropdown">
          <div class="profile-info">
            <strong>{{ user.name }}</strong>
            <small>{{ user.email }}</small>
          </div>

          <button class="logout-dropdown" @click="logout">
            Sair
          </button>
        </div>
      </div>
    </div>
  </header>

  <div class="main-content">
    <div class="filter-card">
      <header>
        <h2>Aqui você vai achar os jogos do seu gosto</h2>
        <p>Filtre por gêneros, estilos, plataformas e nota mínima.</p>
      </header>

      <section class="filter-group">
        <label>🎮 Gêneros</label>
        <div class="badges-container">
          <span
            v-for="g in genres"
            :key="g.id"
            class="badge"
            :class="{ active: filters.genres.includes(g.slug) }"
            @click="toggle(filters.genres, g.slug)"
          >
            {{ g.name }}
          </span>
        </div>
      </section>

      <section class="filter-group">
        <label>🧩 Estilos</label>
        <div class="badges-container small">
          <span
            v-for="s in styles"
            :key="s.id"
            class="badge"
            :class="{ active: filters.styles.includes(s.slug) }"
            @click="toggle(filters.styles, s.slug)"
          >
            {{ s.name }}
          </span>
        </div>
      </section>

      <section class="filter-group">
        <label>🖥️ Plataformas</label>
        <div class="badges-container small">
          <span
            v-for="p in platforms"
            :key="p.id"
            class="badge"
            :class="{ active: filters.platforms.includes(p.slug) }"
            @click="toggle(filters.platforms, p.slug)"
          >
            {{ p.name }}
          </span>
        </div>
      </section>

      <div class="rating-filter">
        <label>Nota mínima</label>

        <div class="stars">
          <span
            v-for="star in 5"
            :key="star"
            class="star"
            :class="{ active: star <= filters.min_rating }"
            @click="filters.min_rating = star"
          >
            ★
          </span>
        </div>
      </div>

      <button class="cta" @click="fetchRecommendations">
        🔍 Buscar recomendações
      </button>
    </div>

    <div v-if="showFavorites" class="favorites-overlay">
      <div class="favorites-modal">
  
        <div class="favorites-header">
          <h2>❤️ Seus Favoritos</h2>
          <button class="close-btn" @click="showFavorites = false">✕</button>
        </div>
  
        <div v-if="favoriteGames.length === 0" class="empty-state">
          <p>Você ainda não favoritou nenhum jogo.</p>
        </div>
  
        <div v-else class="favorites-grid">
          <div
              v-for="game in favoriteGames"
              :key="game.id"
              class="favorite-card"
              @click="openGameDetails(game)"
            >
  
            <img :src="game.cover_image" />
  
            <div class="favorite-info">
              <h3>{{ game.name }}</h3>
              <span>⭐ {{ game.rating }}</span>
            </div>
          </div>
        </div>
  
      </div>
    </div>
  </div>


</template>


<script>
import api from '../services/api';

export default {
  emits: [
    'recommendationsShowed', 
    'logout'
  ],
  data() {
    return {
      genres: [],
      styles: [],
      platforms: [],
      games: [],
      favoriteGames: [],
      showFavorites: false,
      showModal: false,
      filters: {
        genres: [],
        styles: [],
        platforms: [],
        min_rating: 0,
      },
      showProfile: false,
      user: {
        name: '',
        email: ''
      },
    };
  },
  async mounted() {
    const [g, s, p, userRes] = await Promise.all([
      api.get('/genres'),
      api.get('/game-styles'),
      api.get('/platforms'),
      api.get('/user'),
    ]);

    this.genres = g.data;
    this.styles = s.data;
    this.platforms = p.data;

    this.user = userRes.data;
  },
  methods: {
    toggle(list, value) {
      const index = list.indexOf(value);
      index === -1 ? list.push(value) : list.splice(index, 1);
    },

    applyFilters() {
      this.$emit('filter', this.filters);
    },

    async fetchRecommendations() {
      try {
        const res = await api.get('/recommendations', {
          params: this.filters
        });

        this.$emit('recommendationsShowed', res.data);
      } catch (e) {
        console.error(e);
      }
    },

    async openFavorites() {
      try {
        const res = await api.get('/user-favorite-games');
        this.favoriteGames = res.data;
        this.showFavorites = true;
      } catch (e) {
        console.error(e);
        alert('Erro ao carregar favoritos');
      }
    },

    openGameDetails(game) {
      this.$emit('recommendationsShowed', [game], game.id);
    },

    toggleProfile() {
      this.showProfile = !this.showProfile;
    },

    async logout() {
      try {
        await api.post('/logout');
      } catch (e) {
        console.error(e);
      }

      localStorage.removeItem('token');
      delete api.defaults.headers.common['Authorization'];

      this.$emit('logout');
    },
  }
};
</script>
