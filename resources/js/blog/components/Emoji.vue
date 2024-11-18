<script lang="ts" setup>
import type { ReactionCount } from '@/blog/types/reaction'

const props = defineProps<{
  emoji: ReactionCount
}>()

const { state: reactionsState } = useReactions()
const isReacted = computed(() => {
  if (!window.isLoggedIn) {
    return false
  }

  if (reactionsState.value.status === 'success') {
    return reactionsState.value.data.data.some(reaction => reaction.emoji.id === props.emoji.id)
  }

  return false
})

const queryCache = useQueryCache()
const {
  mutate: react,
} = useMutation({})

const {
  mutate: unreact,
} = useMutation({})

const { open } = useAuthenticationDialog()
function onClick() {
  if (!window.isLoggedIn) {
    open()
    return
  }

  if (isReacted.value) {
    unreact()
  }
  else {
    react()
  }
}
</script>

<template>
  <button type="button" class="flex flex-col items-center justify-center gap-1 p-4 text-5xl grayscale-[80%] transition-[filter] duration-150 ease-in hover:grayscale-0 data-[reacted=true]:drop-shadow-md data-[reacted=true]:grayscale-0" :data-reacted="isReacted" @click="onClick">
    <span>{{ emoji.emoji }}</span>
    <span class="text-sm text-neutral-400">{{ emoji.count }}</span>
  </button>
</template>
