<template>
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-container">
      <header class="modal-header">
        <h2>Recomendações para você</h2>
        <button class="close-btn" @click="$emit('close')">✕</button>
      </header>

      <div class="games-grid">
        <div
          v-for="game in games"
          :key="game.id"
          class="game-card"
        >
          <div
            class="cover"
            :style="{ backgroundImage: `url(${game.cover_image})` }"
          />

          <div class="game-info">
            <h3>{{ game.name }}</h3>

            <div class="meta">
              <span>⭐ {{ game.rating ?? 'N/A' }}</span>
              <span v-if="game.released_at">
                📅 {{ game.released_at }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    games: {
      type: Array,
      required: true
    }
  }
};
</script>
