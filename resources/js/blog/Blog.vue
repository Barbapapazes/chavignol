<script lang="ts" setup>
const { emoji, fetchEmoji } = useEmoji()
const { fetchReactions } = useReactions()

onMounted(() => {
  fetchEmoji(window.postId)

  if (window.isLoggedIn) {
    fetchReactions(window.postId)
  }
})
</script>

<template>
  <ConfigProvider>
    <div class="mt-16">
      <section class="mx-auto max-w-screen-md">
        <h2 class="text-center text-lg font-bold">
          Do you like this post?
        </h2>

        <div class="mt-4 flex justify-center">
          <Emoji v-for="e in emoji" :key="e.id" :emoji="e" />
        </div>
      </section>

      <AuthenticationDialog />

      <Toaster />
    </div>
  </ConfigProvider>
</template>
