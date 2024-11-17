<script lang="ts" setup>
import type { ReactionCount } from '@/blog/types/reaction'

const props = defineProps<{
  emoji: ReactionCount
}>()

const { toggleReaction, isReacted } = useReactions()
const { open } = useAuthenticationDialog()

function onClick() {
  if (!window.isLoggedIn) {
    open()
    return
  }

  toggleReaction(window.postId, props.emoji.id)
}
</script>

<template>
  <button type="button" class="flex flex-col items-center justify-center gap-1 p-4 text-5xl grayscale-[80%] transition-[filter] duration-150 ease-in hover:grayscale-0 data-[reacted=true]:drop-shadow-md data-[reacted=true]:grayscale-0" :data-reacted="isReacted(emoji.id)" @click="onClick">
    <span>{{ emoji.emoji }}</span>
    <span class="text-sm text-neutral-400">{{ emoji.count }}</span>
  </button>
</template>
