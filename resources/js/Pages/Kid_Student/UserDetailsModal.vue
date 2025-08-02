<template>
  <div :class="[$style.modalOverlay]" @click.self="$emit('close')">
    <div :class="[$style.modal, isDark ? $style.darkModal : $style.lightModal]">
      <div :class="$style.modalHeader">
        <div :class="$style.userInfo">
          <img
            :src="user.profile_photo_url"
            :class="$style.modalAvatar"
            :alt="user.name"
          />
          <div>
            <h2 :class="$style.userName">{{ user.name }}</h2>
            <p :class="$style.userRank">رتبه {{ rank }}</p>
          </div>
        </div>
        <button
          @click="$emit('close')"
          :class="$style.closeButton"
          aria-label="بستن"
        >
          &times;
        </button>
      </div>

      <div :class="$style.statsGrid">
        <div :class="$style.statCard">
          <p :class="$style.statLabel">کلمات یادگرفته‌شده</p>
          <p :class="$style.statValue">{{ user.learned_words }}</p>
        </div>
        <div :class="$style.statCard">
          <p :class="$style.statLabel">روزهای فعال</p>
          <p :class="$style.statValue">{{ user.active_streak }}</p>
        </div>
        <div :class="$style.statCard">
          <p :class="$style.statLabel">دقایق مطالعه</p>
          <p :class="$style.statValue">{{ user.total_study_minutes }}</p>
        </div>
        <div :class="$style.statCard">
          <p :class="$style.statLabel">امتیاز XP</p>
          <p :class="$style.statValue">{{ user.xp }}</p>
        </div>
      </div>

      <div :class="$style.achievementsSection">
        <h3 :class="$style.sectionTitle">دستاوردها</h3>
        <div :class="$style.achievementsList">
          <div
            v-for="n in 3"
            :key="n"
            :class="$style.achievementBadge"
          >
            🏆
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  user: Object,
  rank: Number,
  isDark: Boolean
});

defineEmits(['close']);
</script>

<style module>
.modalOverlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  backdrop-filter: blur(4px);
}

.modal {
  width: 90%;
  max-width: 500px;
  border-radius: 1rem;
  overflow: hidden;
  animation: modalFadeIn 0.3s ease-out;
}

.lightModal {
  background-color: #ffffff;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.darkModal {
  background-color: #1e293b;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.modalHeader {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 1.5rem;
}

.userInfo {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.modalAvatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}

.lightModal .modalAvatar {
  border: 3px solid #e2e8f0;
}

.darkModal .modalAvatar {
  border: 3px solid #475569;
}

.userName {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
}

.userRank {
  opacity: 0.7;
  font-size: 0.875rem;
}

.closeButton {
  font-size: 1.5rem;
  line-height: 1;
  padding: 0.25rem;
  cursor: pointer;
  transition: opacity 0.2s;
  background: none;
  border: none;
}

.lightModal .closeButton {
  color: #64748b;
}

.darkModal .closeButton {
  color: #94a3b8;
}

.closeButton:hover {
  opacity: 0.8;
}

.statsGrid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1rem;
  padding: 0 1.5rem 1.5rem;
}

.statCard {
  padding: 1rem;
  border-radius: 0.5rem;
  text-align: center;
}

.lightModal .statCard {
  background-color: #f8fafc;
}

.darkModal .statCard {
  background-color: #334155;
}

.statLabel {
  font-size: 0.875rem;
  opacity: 0.8;
  margin-bottom: 0.5rem;
}

.statValue {
  font-size: 1.25rem;
  font-weight: 700;
}

.achievementsSection {
  padding: 1rem 1.5rem 1.5rem;
  border-top-width: 1px;
}

.lightModal .achievementsSection {
  border-top-color: #e2e8f0;
}

.darkModal .achievementsSection {
  border-top-color: #475569;
}

.sectionTitle {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.achievementsList {
  display: flex;
  gap: 0.75rem;
}

.achievementBadge {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
}

.lightModal .achievementBadge {
  background-color: #f1f5f9;
}

.darkModal .achievementBadge {
  background-color: #334155;
}

@keyframes modalFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 480px) {
  .statsGrid {
    grid-template-columns: 1fr;
  }

  .modalAvatar {
    width: 50px;
    height: 50px;
  }

  .userName {
    font-size: 1.1rem;
  }
}
</style>
