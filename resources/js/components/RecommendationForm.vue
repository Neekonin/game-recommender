<template>
  <div class="filter-card">
    <header>
      <h2>Descubra jogos para você</h2>
      <p>Filtre por gêneros, estilos e plataformas</p>
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

  <div>
    <RecommendationsModal
      v-if="showModal"
      :games="games"
      @close="showModal = false"
    />
  </div>
</template>


<script>
import api from '../services/api';
import RecommendationsModal from './RecommendationsModal.vue';

export default {
  components: { 
    RecommendationsModal
  },
  data() {
    return {
      genres: [],
      styles: [],
      platforms: [],
      games: [],
      showModal: false,
      filters: {
        genres: [],
        styles: [],
        platforms: [],
        min_rating: 0,
      }
    };
  },
  async mounted() {
    const [g, s, p] = await Promise.all([
      api.get('/genres'),
      api.get('/game-styles'),
      api.get('/platforms'),
    ]);

    this.genres = g.data;
    this.styles = s.data;
    this.platforms = p.data;
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
        const res = await api.get('/recommendations');
        this.games = res.data;
        this.showModal = true;

        this.$emit('recommendationsShowed');
      } catch (e) {
        console.error(e);
        alert('Erro ao buscar recomendações');
      }
    }
  }
};
</script>
