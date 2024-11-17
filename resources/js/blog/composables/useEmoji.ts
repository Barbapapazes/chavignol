import type { ReactionCount } from '@/blog/types/reaction'

const emoji = ref<ReactionCount[] | null>(null)

export function useEmoji() {
  function fetchEmoji(Id: number) {
    getEmoji(Id).then(({ data }) => {
      emoji.value = data
    })
  }

  return {
    emoji: readonly(emoji),

    fetchEmoji,
  }
}
