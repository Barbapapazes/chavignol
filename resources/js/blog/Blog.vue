<script lang="ts" setup>
const { state: emojiState } = useEmoji()
</script>

<template>
  <ConfigProvider>
    <div class="mt-16">
      <section class="mx-auto max-w-screen-md">
        <h2 class="text-center text-lg font-bold">
          Do you like this post?
        </h2>

        <div class="mt-4 flex justify-center">
          <span v-if="emojiState.status === 'pending'">Loading...</span>
          <template v-else-if="emojiState.data">
            <Emoji v-for="emoji in emojiState.data.data" :key="emoji.id" :emoji="emoji" />
          </template>
        </div>
      </section>

      <AuthenticationDialog />

      <Toaster />
    </div>
  </ConfigProvider>
</template>
