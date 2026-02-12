<template>
  <div class="modal-overlay" @click.self="handleClose">
    <div class="modal-container">

      <!-- HEADER -->
      <header class="modal-header">
        <h2 v-if="!selectedGame">Recomendações para você</h2>
        <h2 v-else>{{ selectedGame.name }}</h2>

        <button class="close-btn" @click="handleClose">✕</button>
      </header>

      <!-- ===================== -->
      <!-- GRID -->
      <!-- ===================== -->
      <div v-if="!selectedGame">
        <div class="games-grid">
          <div
            v-for="game in paginatedGames"
            :key="game.id"
            class="game-card"
            @click="openGame(game.id)"
          >
            <div
              class="cover"
              :style="{ backgroundImage: `url(${game.cover_image})` }"
            />
            <div class="game-info">
              <h3>{{ game.name }}</h3>
              <span>⭐ {{ game.rating ?? 'N/A' }}</span>
            </div>
          </div>
        </div>

        <!-- PAGINAÇÃO -->
        <div class="pagination" v-if="totalPages > 1">
          <button :disabled="currentPage === 1" @click="currentPage--">
            ◀
          </button>

          <span>Página {{ currentPage }} de {{ totalPages }}</span>

          <button :disabled="currentPage === totalPages" @click="currentPage++">
            ▶
          </button>
        </div>
      </div>

      <!-- ===================== -->
      <!-- DETALHES -->
      <!-- ===================== -->
      <div v-else class="game-details">
        <!-- HERO -->
        <div class="details-hero">
          <img :src="selectedGame.cover_image" class="hero-bg" />

          <!-- Botão Voltar fixo no topo -->
          <button class="back-btn" @click="selectedGame = null">
            Voltar
          </button>

          <!-- Conteúdo central -->
          <div class="hero-content">
            <h1 class="game-title">{{ selectedGame.name }}</h1>

            <div class="details-meta">
              <span class="meta-badge">⭐ {{ selectedGame.rating }}</span>
              <span class="meta-badge">📅 {{ selectedGame.released_at }}</span>
            </div>

            <button 
              v-if="selectedGame.trailer"
              class="trailer-btn"
              @click="openTrailer = true"
            >
              ▶ Assistir Trailer
            </button>
          </div>
        </div>


        <!-- DESCRIÇÃO -->
        <div class="details-content">
          <div class="details-section-game">
            <h3 class="section-title">Sobre o Jogo</h3>
            <p class="description" v-html="selectedGame.description"></p>
          </div>

          <!-- Screenshots -->
          <div v-if="selectedGame.screenshots?.length" class="gallery-section">
            <div class="details-section-image">
              <h3 class="section-title">Imagens</h3>
            </div>

            <!-- Grid de Miniaturas -->
            <div class="screenshots-grid">
              <img
                v-for="(img, index) in selectedGame.screenshots"
                :key="index"
                :src="img"
                @click="openLightbox(index)"
              />
            </div>

            <!-- Lightbox -->
            <div v-if="lightboxOpen" class="lightbox">

              <button class="lightbox-close" @click="closeLightbox">
                ✕
              </button>

              <button class="lightbox-btn left" @click="prevImage">
                ‹
              </button>

              <img
                class="lightbox-image"
                :src="selectedGame.screenshots[currentImageIndex]"
              />

              <button class="lightbox-btn right" @click="nextImage">
                ›
              </button>

            </div>
          </div>

          <!-- Stores -->
          <div v-if="selectedGame.stores?.length">
            <div class="details-section-buy">
              <h3 class="section-title">Onde Comprar</h3>
            </div>

            <div class="stores">
              <a
                v-for="store in selectedGame.stores"
                :key="store.url"
                :href="store.url"
                target="_blank"
                class="store-btn"
              >
                {{ store.name }}
              </a>
            </div>
          </div>
        </div>

        <!-- MODAL TRAILER -->
        <div v-if="openTrailer" class="modal" @click.self="openTrailer = false">
          <div class="modal-content">
            <video width="100%" controls autoplay>
              <source :src="selectedGame.trailer" type="video/mp4">
            </video>
          </div>
        </div>
    </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  props: {
    games: Array
  },

  data() {
    return {
      currentPage: 1,
      perPage: 16,
      selectedGame: null,
      openTrailer: false,
      lightboxOpen: false,
      currentImageIndex: 0,
    };
  },

  computed: {
    totalPages() {
      return Math.ceil(this.games.length / this.perPage);
    },

    paginatedGames() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.games.slice(start, start + this.perPage);
    }
  },

  methods: {
    handleClose() {
      this.selectedGame = null;
      this.selectedGame = null;
      this.lightboxOpen = false;
      this.currentImageIndex = 0;
      this.$emit('close');
    },

    openLightbox(index) {
      this.currentImageIndex = index;
      this.lightboxOpen = true;
      document.body.style.overflow = "hidden";
    },

    closeLightbox() {
      this.lightboxOpen = false;
      document.body.style.overflow = "auto";
    },

    nextImage() {
      const total = this.selectedGame.screenshots.length;
      this.currentImageIndex = (this.currentImageIndex + 1) % total;
    },

    prevImage() {
      const total = this.selectedGame.screenshots.length;
      this.currentImageIndex =
        (this.currentImageIndex - 1 + total) % total;
    },

    async openGame(id) {
      this.lightboxOpen = false;
      this.currentImageIndex = 0;

      try {
        const res = await api.get(`/game/${id}`);
        this.selectedGame = res.data;
      } catch (e) {
        console.error(e);
      }
    }
  },

  watch: {
    games() {
      this.currentPage = 1;
    },

    selectedGame() {
      this.lightboxOpen = false;
      this.currentImageIndex = 0;
    }
  }
};
</script>
